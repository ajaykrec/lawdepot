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
use Illuminate\Support\Facades\DB;
use Inertia\Inertia; 

class DocumentController extends Controller
{
    use AllFunction; 

    public function index($slug, Request $request){  
       
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

        $steps = DB::table('documents_step')->select('*')->where('document_id',$document_id)->where('status',1)->orderBy('sort_order','asc')->get()->toArray(); 
        $steps = json_decode(json_encode($steps), true);       
        
        $step_id  = $request['step_id'] ?? $steps[0]['step_id'] ?? '';        
        $label_group  = $request['group'] ?? 1;        

        $steps_length = count($steps) + 1;        
        $percent = 100/$steps_length;
        $count = 0;
        foreach($steps as $val){
            $count++;
            if($val['step_id']==$step_id){                
                $percent =  $percent*$count;                
            }
        }   
        
        $questions = [];
        $result = DB::table('documents_question')->select('*')
        ->where('step_id',$step_id)
        ->where('label_group',$label_group)
        ->orderBy('label','asc')->get()->toArray(); 
        $result = json_decode(json_encode($result), true);
        if($result){
            foreach($result as $val){
                $val['options'] = DocumentController::get_options([
                    'question_id'=>$val['question_id'],  
                ]);
                $questions[$val['question_id']] = $val;
            }
        }        
        //p($questions);
        
        $pageData = compact('document','meta','header_banner','breadcrumb','steps','step_id','percent','questions'); 
        return Inertia::render('frontend/pages/document/Document', [            
            'pageData' => $pageData,            
        ]);
    }
    public function get_options($data){  
        $options = [];
        $question_id = $data['question_id'] ?? ''; 

        $result = DB::table('documents_question_option')->select('*')->where('question_id',$question_id)->orderBy('option_id','asc')->get()->toArray(); 
        $result = json_decode(json_encode($result), true);
        foreach($result as $val){
            $val['questions'] = DocumentController::get_questions([
                'option_id'=>$val['option_id'],  
            ]);
            $options[$val['option_id']] = $val;
        }
        return $options;
    }  
    public function get_questions($data){  
        $questions = [];
        $option_id = $data['option_id'] ?? ''; 

        $result = DB::table('documents_question')->select('*')->where('option_id',$option_id)->orderBy('label_group','asc')->get()->toArray(); 
        $result = json_decode(json_encode($result), true);
        foreach($result as $val){
            $val['options'] = DocumentController::get_options([
                'question_id'=>$val['question_id'],  
            ]);
            $questions[$val['question_id']] = $val;
        }
        return $questions;
    }  
    public function download($slug, Request $request){  
       
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

        $steps = DB::table('documents_step')->select('*')->where('document_id',$document_id)->where('status',1)->orderBy('sort_order','asc')->get()->toArray(); 
        $steps = json_decode(json_encode($steps), true);
        
        $percent = 100;
        
        $pageData = compact('document','meta','header_banner','breadcrumb','steps','percent'); 
        return Inertia::render('frontend/pages/document/Document_download', [            
            'pageData' => $pageData,            
        ]);
    }    
    
}
