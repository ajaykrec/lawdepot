<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Traits\AllFunction;
use App\Models\Document_category;
use App\Models\Document;
use App\Models\Documents_step;
use App\Models\Documents_question;
use App\Models\Documents_question_option;

class DocumentQuestionController extends Controller
{
    use AllFunction; 

    public function __construct(){
        $this->answer_types = ['radio','radio_group','checkbox','dropdown','text','textarea','date']; 
    }
    
    public function index(Request $request)
    {       
        //=== check permision
        if(!has_permision(['document'])){ return redirect( route('dashboard') ); }

        $step_id   = $request['step_id'] ?? '';
        $option_id = $request['option_id'] ?? '';

        $breadcrumb = AllFunction::get_questions_breadcrumb([
            'step_id'=>$step_id,
            'question_id'=>'',
            'option_id'=>$option_id,
            'text'=>'',
            'breadcrumb'=>[]]
        );

        if($step_id){
            $row_data = Documents_step::find($step_id)->toArray(); 
            $title = $row_data['name'] ?? '';
            $document_id = $row_data['document_id'] ?? '';   
            $question_id = '';   
        }
        else{
            $row_data = Documents_question_option::find($option_id)->toArray();  
            $title = $row_data['title'] ?? '';
            $document_id = $row_data['document_id'] ?? '';    
            $question_id = $row_data['question_id'] ?? '';      
        }        

        $meta = [
            'title'=>'Questions for : '.$title ?? '',
            'keywords'=>'',
            'description'=>'',
        ];    
        
        $filterArr                 = [];
        $filterArr['step_id']      = $request['step_id'] ?? '';
        $filterArr['option_id']    = $request['option_id'] ?? '';
        $filterArr['label']        = $request['label'] ?? '';
        $filterArr['question']     = $request['question'] ?? '';
        $filterArr['answer_type']  = $request['answer_type'] ?? '';
        $filterArr['display_type'] = $request['display_type'] ?? '';
        $filterArr['field_name']   = $request['field_name'] ?? '';   

        //=== url start====
        $URL = DocumentQuestionController::get_url($step_id,$option_id);
        $url_1=$URL[0] ?? '';
        $url_2=$URL[1] ?? '';        
        //=== url ends====

        //=== pagi_url
        $pagi_url = route('questions.index').'?';
        if($filterArr){
            $count = 0;
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    $count++;
                    if($count == 1){
                        $pagi_url.=$key.'='.$val;
                    }
                    else{
                        $pagi_url.='&'.$key.'='.$val;
                    }      
                }       
            }
        }

        $limit  = AllFunction::admin_limit();
        $page   = $request['_p'] ?? 1;
        $offset = ($page - 1)*$limit;
        $start_count  = ($page * $limit - $limit + 1);

        $q = Documents_question::query();
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'step_id'){
                        $q->where('step_id',$val);
                    }
                    if($key == 'option_id'){
                        $q->where('option_id',$val);
                    }
                    if($key == 'label'){
                        $q->where('label','like','%'.$val.'%');
                    }       
                    if($key == 'question'){
                        $q->where('question','like','%'.$val.'%');
                    }      
                    if($key == 'answer_type'){
                        $q->where('answer_type',$val);
                    }   
                    if($key == 'display_type'){
                        $q->where('display_type',$val);
                    }                   
                    if($key == 'field_name'){
                        $q->where('field_name','like','%'.$val.'%');
                    }
                }
            }
        } 
        $q->with(['options']);
        $q->orderBy("question_id", "asc"); 
        $count    = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 

        $return_array = [];
        foreach($results as $val){
            $add_another_max = AllFunction::get_add_another_max($val['question_id']);     
            $val['add_another_max'] = $add_another_max;   
            $return_array[] = $val;
        }
        $results  = $return_array;
        //p($results);        

        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);

        $answer_types = $this->answer_types;

        $data = compact('meta','results','count','start_count','paginate','document_id','question_id','answer_types','url_1','url_2','breadcrumb'); 
        $data = array_merge($data,$filterArr);  
       
        return view('admin.document_questions.index')->with($data);
    }
    
    public function create(Request $request)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }

        $step_id      = $request['step_id'] ?? '';
        $option_id    = $request['option_id'] ?? '';            

        $breadcrumb = AllFunction::get_questions_breadcrumb([
            'step_id'=>$step_id,
            'question_id'=>'',
            'option_id'=>$option_id,
            'text'=>'Add question',
            'breadcrumb'=>[]]
        );

        if($step_id){
            $row_data = Documents_step::find($step_id)->toArray(); 
            $title = $row_data['name'] ?? '';
            $document_id = $row_data['document_id'] ?? '';   
            $question_id = '';   
            $group_count = $row_data['group_count'] ?? 1;   
        }
        else{
            $row_data = Documents_question_option::find($option_id)->toArray();  
            $title = $row_data['title'] ?? '';
            $document_id = $row_data['document_id'] ?? '';    
            $question_id = $row_data['question_id'] ?? '';  
            $group_count = 1;       
        }  

        $show_add_another = AllFunction::show_add_another($step_id); 
        $add_another_max = AllFunction::get_add_another_max($question_id); 

        //=== url start====
        $URL = DocumentQuestionController::get_url($step_id,$option_id);
        $url_1=$URL[0] ?? '';
        $url_2=$URL[2] ?? '';        
        //=== url ends====

        $meta = [
            'title'=>'Add question for : '.$title ?? '',
            'keywords'=>'',
            'description'=>'',
        ];    

        $answer_types = $this->answer_types;
        
        $data = compact('meta','document_id','step_id','option_id','question_id','answer_types','url_1','url_2','breadcrumb','group_count','show_add_another','add_another_max'); 
        return view('admin.document_questions.create')->with($data);
    }

    public function store(Request $request)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }        
       
        $step_id      = $request['step_id'] ?? '';
        $option_id    = $request['option_id'] ?? '';  
        
       
        //=== url start====
        $URL = DocumentQuestionController::get_url($step_id,$option_id);
        $url= $URL[0] ?? '';        
        //=== url ends====       

        //==== apply_action =====
        $apply_action = $request['apply_action'] ?? '';   
        if($apply_action){
            $id_array = $request['id'] ?? [];
            if( $apply_action == 'delete' && $id_array){     
                Documents_question::whereIn('question_id', $id_array)->delete();
                return redirect( $url )->with('message','Selected item deleted successfully');
            }  
        }

        //==== Add new data =====        
        $rules = [
            'question'      => 'required',   
            'answer_type'   => 'required',            
            'display_type'  => 'required',  
        ];
        $messages = [];
        $validation = Validator::make( 
            $request->toArray(), 
            $rules, 
            $messages
        );        
        if($validation->fails()) {            
            return back()->withInput()->withErrors($validation->messages());            
        }
        else{

            if($step_id){
                $row_data = Documents_step::find($step_id)->toArray(); 
                $document_id = $row_data['document_id'] ?? '';  
            }
            else{
                $row_data = Documents_question_option::find($option_id)->toArray();                 
                $document_id = $row_data['document_id'] ?? ''; 
            }     
            
            $answer_type = $request['answer_type'] ?? '';
            $arrType = ['radio','radio_group'];
            if( in_array($answer_type, $arrType) ){
                $display_type = $request['display_type'] ?? 0;
            }
            else{
                $display_type = 0;
            }

            $add_another_max = $request['add_another_max'] ?? 0;
            if( $add_another_max =='' ){
                $add_another_max = 0;
            }

            // store
            $table = new Documents_question;
            $table->document_id     = $document_id;
            $table->step_id         = $request['step_id'] ?? 0;
            $table->option_id       = $request['option_id'] ?? 0;
            $table->label           = $request['label'] ?? '';
            $table->question        = $request['question'] ?? '';
            $table->placeholder     = $request['placeholder'] ?? '';
            $table->answer_type     = $request['answer_type'] ?? '';
            $table->display_type    = $display_type;
            $table->label_group     = $request['label_group'] ?? 1;
            $table->blank_space     = $request['blank_space'] ?? 1;
            $table->is_add_another  = $request['is_add_another'] ?? 0; 
            $table->add_another_max = $add_another_max;           
            $table->add_another_text= $request['add_another_text'] ?? '';           
            $table->save();

            $question_id = $table->question_id;

            //=== generate_field_name ===
            $table = Documents_question::find($question_id);  
            $table->field_name = AllFunction::generate_field_name($question_id);
            $table->save();          
            //========           

            // redirect
            return redirect( $url )->with('message','Document question created successfully');
        }        
    }
    
    public function show($step_id)
    {
        //====
    }
    
    public function edit($question_id)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }

        $data = Documents_question::query()        
        ->where('question_id',$question_id)
        ->first()->toArray();         
        if(!$data){
            return redirect( route('document.index') );
        }        
        $step_id = $data['step_id'] ?? '';
        $option_id = $data['option_id'] ?? '';
        $document_id = $data['document_id'] ?? '';

        $show_add_another = AllFunction::show_add_another($step_id); 
        $add_another_max = AllFunction::get_add_another_max($question_id);         

        $breadcrumb = AllFunction::get_questions_breadcrumb([
            'step_id'=>$step_id,
            'question_id'=>'',
            'option_id'=>$option_id,
            'text'=>'Edit question',
            'breadcrumb'=>[]]
        );

        if($step_id){
            $row_data = Documents_step::find($step_id)->toArray(); 
            $title = $row_data['name'] ?? '';   
            $group_count = $row_data['group_count'] ?? 1;            
        }
        else{
            $row_data = Documents_question_option::find($option_id)->toArray();  
            $title = $row_data['title'] ?? '';   
            $group_count = 1;                     
        } 

        $meta = [
            'title'=>'Edit question for : '.$title ?? '',
            'keywords'=>'',
            'description'=>'',
        ];


        //=== url start====
        $URL = DocumentQuestionController::get_url($step_id,$option_id);
        $url= $URL[0] ?? '';        
        //=== url ends====           

        $answer_types = $this->answer_types;
        $data = compact('meta','data','document_id','step_id','option_id','question_id','answer_types','url','breadcrumb','group_count','show_add_another','add_another_max');         
        return view('admin.document_questions.edit')->with($data);
    }
    
    public function update(Request $request, string $question_id)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }        

        $rules = [
            'question'      => 'required',   
            'answer_type'   => 'required',            
            'display_type'  => 'required', 
        ];
        $messages = [];
        $validation = Validator::make( 
            $request->toArray(), 
            $rules, 
            $messages
        );        
        if($validation->fails()) {            
            return back()->withInput()->withErrors($validation->messages());            
        }
        else{                
           
            $question_row = Documents_question::query()            
            ->where('question_id',$question_id)
            ->first()->toArray();       

            $document_id = $question_row['document_id'] ?? '';  
            $step_id =  $question_row['step_id'] ?? 0;  
            $option_id =  $question_row['option_id'] ?? 0;  

            //=== url start====
            $URL = DocumentQuestionController::get_url($step_id,$option_id);
            $url= $URL[0] ?? '';        
            //=== url ends====   
            
            $answer_type = $request['answer_type'] ?? '';
            $arrType = ['radio','radio_group'];
            if( in_array($answer_type, $arrType) ){
                $display_type = $request['display_type'] ?? 0;
            }
            else{
                $display_type = 0;
            }

            $add_another_max = $request['add_another_max'] ?? 0;
            if( $add_another_max =='' ){
                $add_another_max = 0;
            }

            $table = Documents_question::find($question_id);   
            $table->document_id     = $document_id;
            $table->step_id         = $step_id;
            $table->option_id       = $option_id;
            $table->label           = $request['label'] ?? '';
            $table->question        = $request['question'] ?? '';
            $table->placeholder     = $request['placeholder'] ?? '';
            $table->answer_type     = $request['answer_type'] ?? '';
            $table->display_type    = $display_type;
            $table->field_name      = AllFunction::generate_field_name($question_id);
            $table->label_group     = $request['label_group'] ?? 1;
            $table->blank_space     = $request['blank_space'] ?? 1;
            $table->is_add_another  = $request['is_add_another'] ?? 0;
            $table->add_another_max = $add_another_max;           
            $table->add_another_text= $request['add_another_text'] ?? '';                       
            $table->save();           
            return redirect( $url )->with('message','Documents question updated successfully');
        }
    }
   
    public function destroy(string $question_id)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }

        $table = Documents_question::find($question_id); 
        $step_id =  $table->step_id ?? '';  
        $option_id =  $table->option_id ?? ''; 

        //=== url start====
        $URL = DocumentQuestionController::get_url($step_id,$option_id);
        $url= $URL[0] ?? '';        
        //=== url ends====          

        $table->delete();

        return json_encode(array(
            'status'=>'success',
            'url'=>$url
        ));
        exit;
    }

    public function get_url($step_id,$option_id){
        $urlArr                 = [];
        $urlArr['step_id']      = $step_id;
        $urlArr['option_id']    = $option_id;

        $url_1 = route('questions.index').'?';
        $url_2 = route('questions.create').'?'; 
        $url_3 = route('questions.store').'?'; 

        if($urlArr){
            $count = 0;
            foreach($urlArr as $key=>$val){
                if($val > 0 ){
                    $count++;
                    if($count == 1){
                        $url_1.=$key.'='.$val;  
                        $url_2.=$key.'='.$val;           
                        $url_3.=$key.'='.$val;                                 
                    }
                    else{
                        $url_1.='&'.$key.'='.$val;
                        $url_2.='&'.$key.'='.$val;                 
                        $url_3.='&'.$key.'='.$val;                                       
                    }      
                }       
            }
        }
        return [$url_1, $url_2, $url_3];
    }
}
