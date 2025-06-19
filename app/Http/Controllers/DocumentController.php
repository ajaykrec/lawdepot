<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\AllFunction; 
use App\Models\Pages;
use App\Models\Document_category;
use App\Models\Document;
use App\Models\Documents_step;
use App\Models\Documents_question;
use App\Models\Documents_question_option;
use App\Models\Customers_document;
use App\Models\Customers_membership;


use Illuminate\Support\Facades\DB;
use Inertia\Inertia; 

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use OpenAI\Laravel\Facades\OpenAI;

class DocumentController extends Controller
{
    use AllFunction; 

    public function index($slug, Request $request){ 
        
        //Session::forget('document_id');  
        //Session::forget('fields');  
       
        $country = AllFunction::get_current_country();         
        $country_id = $country['country_id'] ?? '';        

        $q = DB::table('documents');       
        $q = $q->leftJoin('documents_category','documents_category.category_id','=','documents.category_id');   
        $q = $q->select('documents.*', 'documents_category.name as cat_name','documents_category.slug as cat_slug');   
        $q = $q->where('documents.country_id',$country_id);   
        $q = $q->where('documents.slug',$slug); 
        $document = $q->first(); 
        $document = json_decode(json_encode($document), true);         

        $document_id = $document['document_id'] ?? '';  
        
        ######## 
        AllFunction::reset_session_document_id($document_id);   
        ########      
        
        $meta = [
            'title'=>$document['meta_title'] ?? '',
            'keywords'=>$document['meta_keyword'] ?? '',
            'description'=>$document['meta_description'] ?? '',
        ];  
        $header_banner = [
            'title'=>$document['name'] ?? '',
            'banner_image'=>'',
            'banner_text'=>'',
        ];
        $breadcrumb = [
            ['name'=>'Home', 'url'=>route('home')],
            ['name'=>$document['cat_name'], 'url'=>route('category.index',$document['cat_slug'])],
            ['name'=>$document['name'], 'url'=>''],
        ];

        $steps = DB::table('documents_step')->select('*')->where('document_id',$document_id)->where('status',1)->orderBy('sort_order','asc')->get()->toArray(); 
        $steps = json_decode(json_encode($steps), true);       
        
        $step_id = $request['step_id'] ?? $steps[0]['step_id'] ?? '';        
        $group = $request['group'] ?? 1;   
        
        $urlArry = AllFunction::get_next_previous_url([
            'document_id'=>$document_id,  
            'step_id'=>$step_id,  
            'group'=>$group,  
        ]);

        $previous_url = $urlArry['previous_url'] ?? '';
        $next_url = $urlArry['next_url'] ?? '';

        $steps_length = count($steps) + 1;        
        $percent = 100/$steps_length;
        $count = 0;
        foreach($steps as $val){
            $count++;
            if($val['step_id']==$step_id){                
                $percent = $percent*$count;                
            }
        }   
        
        $questions = [];
        $result = DB::table('documents_question')->select('*')
        ->where('document_id',$document_id)
        ->where('step_id',$step_id)
        ->where('label_group',$group)
        ->orderBy('sort_order','asc')
        ->orderBy('label','desc')
        ->get()->toArray(); 
        $result = json_decode(json_encode($result), true);        
        if($result){
            foreach($result as $val){
                $val['options'] = AllFunction::get_options([
                    'question_id'=>$val['question_id'],  
                ]);
                $questions[$val['question_id']] = $val;
            }
        }  
        $questions = array_values($questions);  
        
        $fields = AllFunction::get_document_fields($questions,'field_name'); 
        $session_fields = (Session::has('fields')) ? Session::get('fields') : '';   
        $is_download = AllFunction::percentage_of_answer( $document_id, $session_fields );               
        if( $session_fields ){             
            $session_fields = (array)json_decode($session_fields); 
            $fields = array_merge($fields, $session_fields); 
        }  
                
       
        $q = DB::table('documents_faq')->select('*')
        ->where('step_id',$step_id)
        ->where('label_group',$group)
        ->orderBy('question','asc')->get()->toArray();         
        $faqs = json_decode(json_encode($q), true);         
        
        
        // $filter_question_value = AllFunction::filter_question_value([
        //     'document_id'=>$document_id ?? '',            
        // ]);
        // p($filter_question_value);       

        // $templateApiJsonData = AllFunction::get_templateApiJsonData([
        //     'document_id'=>$document_id,
        //     'session_fields'=>(Session::has('fields')) ? Session::get('fields') : '',
        // ]);   
        // p($templateApiJsonData);   
        //p($session_fields);   

        $pageData = compact('document','meta','header_banner','breadcrumb','steps','step_id','group','percent','questions','fields','previous_url','next_url','faqs','is_download'); 
        return Inertia::render('frontend/pages/document/Document', [            
            'pageData' => $pageData,            
        ]);
    }   
    public function doc_post($slug, Request $request){

        $rules = [];
        $messages = [];
        $validation = Validator::make( 
            $request->toArray(), 
            $rules, 
            $messages
        );        
        if($validation->fails()){   
            echo json_encode(
                array(
                'status'  => 'error',                 
                'message' => $validation->messages()->toArray(),							
            ));		
            exit;
        }
        else{           
            $step_id = $request['step_id'] ?? '';        
            $group  = $request['group'] ?? ''; 
            $inputs = $request['fields'] ?? [];  
            $inputs = (array)json_decode($inputs);               
            
            $returnfields = [];
            foreach($inputs as $key=>$val){ 
                $returnfields[$key] = $val;
            }
            $fields = $returnfields;             
           
            $step_row = DB::table('documents_step')->select('*')->where('step_id',$step_id)->first(); 
            $step_row = json_decode(json_encode($step_row), true); 
            $document_id = $step_row['document_id'] ?? ''; 
            
            //== reset session: for different document_id ====
            // if( Session::has('document_id') ){  
            //     if($document_id!=Session::get('document_id')){
            //         Session::forget('document_id');  
            //         Session::forget('fields');  
            //     }                
            // }
            //==========

            if( Session::has('fields') ){  
                $session_fields = (array)json_decode(Session::get('fields')); 
                $returnArr = [];
                foreach($session_fields as $key=>$val){
                    $returnArr[$key] = $fields[$key] ?? $val;
                }
                $fields = array_merge($returnArr, $fields);                 
            }  

            //p($fields);

            Session::put('document_id', $document_id);          
            Session::put('fields', json_encode($fields));
            
            $urlArry = AllFunction::get_next_previous_url([
                'document_id'=>$document_id,  
                'step_id'=>$step_id,  
                'group'=>$group,  
            ]);    
            $previous_url = $urlArry['previous_url'] ?? '';
            $next_url = $urlArry['next_url'] ?? '';
            
            return redirect( $next_url )->with(['success'=>'']);
        }        
    }
    public function download($slug, Request $request){  

        $customer = (Session::has('customer_data')) ? Session::get('customer_data') : []; 
        $customer_id = $customer['customer_id'] ?? '';
       
        $country = AllFunction::get_current_country();         
        $country_id = $country['country_id'] ?? '';

        $q = DB::table('documents');       
        $q = $q->leftJoin('documents_category','documents_category.category_id','=','documents.category_id');   
        $q = $q->select('documents.*', 'documents_category.name as cat_name','documents_category.slug as cat_slug');   
        $q = $q->where('documents.country_id',$country_id);   
        $q = $q->where('documents.slug',$slug); 
        $document = $q->first(); 
        $document = json_decode(json_encode($document), true); 

        $document_id = $document['document_id'] ?? '';        
        
        $meta = [
            'title'=>$document['meta_title'] ?? '',
            'keywords'=>$document['meta_keyword'] ?? '',
            'description'=>$document['meta_description'] ?? '',
        ];  
        $header_banner = [
            'title'=>$document['name'],
            'banner_image'=>'',
            'banner_text'=>'',
        ];
        $breadcrumb = [
            ['name'=>'Home', 'url'=>route('home')],
            ['name'=>$document['cat_name'], 'url'=>route('category.index',$document['cat_slug'])],
            ['name'=>$document['name'], 'url'=>''],
        ];

        $session_fields = (Session::has('fields')) ? Session::get('fields') : '';         
        $is_download = AllFunction::percentage_of_answer( $document_id, $session_fields );         
        //=== check download permision ===
        if(!$is_download){
            return redirect( route('doc.index',$slug) );
        }
        //=====

        $active_membership = AllFunction::get_active_membership();  

        $steps = DB::table('documents_step')->select('*')->where('document_id',$document_id)->where('status',1)->orderBy('sort_order','asc')->get()->toArray(); 
        $steps = json_decode(json_encode($steps), true);        
        $percent = 100;
       
        $templateApiJsonData = AllFunction::get_templateApiJsonData([
            'document_id'=>$document_id,
            'session_fields'=>$session_fields,
        ]); 
        $templateApiJsonData = $templateApiJsonData;  
        //p($templateApiJsonData);
        $guest_document_count = AllFunction::guest_document_count($document_id);        

        $last_templateApiJsonData_question = (Session::has('last_templateApiJsonData_question')) ? Session::get('last_templateApiJsonData_question') : '';  
        if( $last_templateApiJsonData_question !== $templateApiJsonData['question'] ){
            
            Session::put('last_templateApiJsonData_question', $templateApiJsonData['question']);           
            //=== call OpenAI [start] ======         
            if( $guest_document_count < 2 && $document['openai_system_content'] && $document['openai_user_content']){ 
                
                $messagesArr = [
                    [
                        'role'=>'system', 
                        'content'=> $document['openai_system_content']
                    ],
                    [
                        'role'=>'user', 
                        'content' => $document['openai_user_content'] . "\n```json\n" . 
                        json_encode($templateApiJsonData['question'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . 
                        "\n```"
                    ],
                ];         
            
                $result = OpenAI::chat()->create([
                    'model' => 'gpt-4-turbo',
                    'messages' =>  $messagesArr,
                ]);
                
                $openai_document = $result->choices[0]->message->content;       
                $openai_document = AllFunction::convertMarkdownToHtml($openai_document); 
                Session::put('openai_document', $openai_document);  
                AllFunction::save_document();                 
            }
        }        
        //=== call OpenAI [ends] ======          
        $template = (Session::has('openai_document')) ? Session::get('openai_document') : '';         
        $document['template'] = $template;        

        $pageData = compact('document','meta','header_banner','breadcrumb','steps','percent','active_membership','templateApiJsonData','is_download','guest_document_count'); 
        return Inertia::render('frontend/pages/document/Document_download', [            
            'pageData' => $pageData,            
        ]);
    }   

    public function save_document(Request $request){ 
        AllFunction::save_document();
        //==== remove session ====
        Session::forget('document_id'); 
        Session::forget('fields'); 
        Session::forget('openai_document'); 
        //=====  
        return redirect( route('customer.documents') )->with(['success'=>'Document saved successfully']);
    }
}
