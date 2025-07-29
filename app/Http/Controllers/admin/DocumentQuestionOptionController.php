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
use Illuminate\Support\Facades\DB;

class DocumentQuestionOptionController extends Controller
{
    use AllFunction; 

    public function __construct(){
        $this->width  = 100;
        $this->height = 100;
        $this->table_names = ['zones'];
    }
    
    public function index($question_id,Request $request)
    {    
        
        //=== check permision
        if(!has_permision(['document'])){ return redirect( route('dashboard') ); }
        
        $question = Documents_question::query()->where('question_id',$question_id)->with(['step'])->first()->toArray();  
        $step_id = $question['step_id'] ?? '';   
        $option_id = $question['option_id'] ?? '';   
        $document_id = $question['document_id'] ?? '';  
        
        $breadcrumb = AllFunction::get_questions_breadcrumb([
            'step_id'=>'',
            'question_id'=>$question_id,
            'option_id'=>'',
            'text'=>'',
            'breadcrumb'=>[]]
        );

        //=== url start====
        $URL = DocumentQuestionOptionController::get_url($step_id,$option_id);
        $url= $URL[0] ?? '';        
        //=== url ends====          
        
        $meta = [
            'title'=>'Options for : '.$question['question'] ?? '',
            'keywords'=>'',
            'description'=>'',
        ];    
        
        $filterArr                 = [];
        $filterArr['question_id']  = $question_id;
        $filterArr['title']        = $request['title'] ?? '';
        $filterArr['value']        = $request['value'] ?? '';        
        $filterArr['is_sub_question'] = $request['is_sub_question'] ?? '';        

        //=== pagi_url
        $pagi_url = route('document.options.index',$question_id).'?';
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

        $q = Documents_question_option::query();
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'question_id'){
                        $q->where('question_id',$val);
                    }
                    if($key == 'title'){
                        $q->where('title','like','%'.$val.'%');
                    }       
                    if($key == 'value'){
                        $q->where('value','like','%'.$val.'%');
                    }      
                    if($key == 'is_sub_question'){
                        $q->where('is_sub_question',$val);
                    }  
                }
            }
        } 
        $q->with(['questions']);
        $q->orderBy("title", "asc"); 
        $count    = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 
        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);       

        $data = compact('meta','results','count','start_count','paginate','document_id','step_id','option_id','url','breadcrumb'); 
        $data = array_merge($data,$filterArr);         
       
        return view('admin.document_questions_option.index')->with($data);
    }
    
    public function create($question_id)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }
        
        $question = Documents_question::query()->where('question_id',$question_id)->with(['step'])->first()->toArray();  
        $step_id = $question['step_id'] ?? '';  
        $option_id = $question['option_id'] ?? '';    
        $document_id = $question['document_id'] ?? '';  

        $breadcrumb = AllFunction::get_questions_breadcrumb([
            'step_id'=>'',
            'question_id'=>$question_id,
            'option_id'=>'',
            'text'=>'Add Option',
            'breadcrumb'=>[]]
        );
        
        //=== url start====
        $URL = DocumentQuestionOptionController::get_url($step_id,$option_id);
        $url= $URL[0] ?? '';        
        //=== url ends====          

        $meta = [
            'title'=>'Add Option for : '.$question['question'] ?? '',
            'keywords'=>'',
            'description'=>'',
        ];    
        $width  = $this->width; 
        $height = $this->height;  
        $table_names = $this->table_names;

        $data = compact('meta','width','height','table_names','step_id','option_id','document_id','question_id','url','breadcrumb'); 
        return view('admin.document_questions_option.create')->with($data);
    }

    public function store($question_id,Request $request)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }

        //==== apply_action =====
        $apply_action = $request['apply_action'] ?? '';
        if($apply_action){
            $id_array = $request['id'] ?? [];
            if( $apply_action == 'delete' && $id_array){
                //== unlink file
                $result = Documents_question_option::query()->whereIn('option_id', $id_array)->get()->toArray();
                if($result){
                    foreach($result as $val){
                        $delArr = array(
                            'file_path'=>'uploads/document_option',
                            'file_name'=>$val['image']
                        );
                        AllFunction::delete_file($delArr);
                    }
                }                
                //======     
                Documents_question_option::whereIn('option_id', $id_array)->delete();
                return redirect( route('document.options.index',$question_id) )->with('message','Selected item deleted successfully');
            }  
        }

        //==== Add new data =====     
        $is_table_value = $request['is_table_value'] ?? 0;
        $messages = [];   
        $rules = [
            'title'   => 'required',   
            'image'   => 'mimes:png,jpeg,gif,webp,svg|image|max:2048', // size : 1024*2 = 2048 = 2MB 
        ];

        if($is_table_value == 0){
            $rules['value1'] = 'required';
            $messages['value1.required'] = 'value is required';  
        }
        else{
            $rules['value2'] = 'required';
            $messages['value2.required'] = 'value is required';  
        }
        
        $validation = Validator::make( 
            $request->toArray(), 
            $rules, 
            $messages
        );        
        if($validation->fails()) {            
            return back()->withInput()->withErrors($validation->messages());            
        }
        else{
            
            $question = Documents_question::query()->where('question_id',$question_id)->with(['step'])->first()->toArray();  
            $step_id = $question['step_id'] ?? '';   
            $option_id = $question['option_id'] ?? '';   
            $document_id = $question['document_id'] ?? '';     
            
            //=== upload file
            $file = $request->file('image');
            if($file){
                $array = [
                    'file'=>$file,
                    'destination_path'=>'uploads/document_option',                    
                    'width'=>$this->width,
                    'height'=>$this->height,                  
                ];
                $image = AllFunction::upload_image($array);
            }
            else{
                $image = $request['image'] ?? '';
            }
            //====

            if($is_table_value == 0){
                $value = $request['value1'] ?? '';                
            }
            else{
                $value = $request['value2'] ?? '';                
            }

            // store
            $table = new Documents_question_option;
            $table->document_id     = $document_id;   
            $table->question_id     = $question_id;           
            $table->image           = $image;
            $table->placeholder     = $request['placeholder'] ?? '';
            $table->title           = $request['title'] ?? '';
            $table->value           = $value ?? '';
            $table->quick_info      = $request['quick_info'] ?? '';            
            $table->is_table_value  = $request['is_table_value'] ?? 0;
            $table->is_sub_question = $request['is_sub_question'] ?? 0;           
            $table->save();
            // redirect
            return redirect( route('document.options.index',$question_id) )->with('message','Document question created successfully');
        }        
    }
    
    public function show($id)
    {
        //====
    }
    
    public function edit($id)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }

        $data = Documents_question_option::query()->where('option_id',$id)->first()->toArray();         
        if(!$data){
            return redirect( route('document.index') );
        }        
        $question_id = $data['question_id'] ?? '';        
        $question = Documents_question::query()->where('question_id',$question_id)->with(['step'])->first()->toArray();  
        $step_id  = $question['step_id'] ?? '';   
        $option_id  = $question['option_id'] ?? '';   
        $document_id = $question['document_id'] ?? '';         

        $breadcrumb = AllFunction::get_questions_breadcrumb([
            'step_id'=>$step_id,
            'question_id'=>$question_id,
            'option_id'=>$id,
            'position'=>'edit',
            'text'=>'Edit option',
            'breadcrumb'=>[]]
        );        
        
        //=== url start====
        $URL = DocumentQuestionOptionController::get_url($step_id,$option_id);
        $url= $URL[0] ?? '';        
        //=== url ends====          
        
        $meta = [
            'title'=>'Edit Option for : '.$question['question'] ?? '',
            'keywords'=>'',
            'description'=>'',
        ];
        $width  = $this->width; 
        $height = $this->height;  
        $table_names = $this->table_names;
        $data = compact('meta','data','width','height','table_names','document_id','step_id','option_id','question_id','id','url','breadcrumb');         
        return view('admin.document_questions_option.edit')->with($data);
    }
    
    public function update(Request $request, string $id)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }        

        $is_table_value = $request['is_table_value'] ?? 0;
        $image = $request['image'] ?? '';
        $messages = [];

        $rules = [
            'title'   => 'required',            
        ]; 
        if($request->file('image')){
            $rules['image'] = 'mimes:png,jpeg,gif,webp,svg|image|max:2048'; // size : 1024*2 = 2048 = 2MB 
        }
       
        if($is_table_value == 0){
            $rules['value1'] = 'required';
            $messages['value1.required'] = 'value is required';  
        }
        else{
            $rules['value2'] = 'required';
            $messages['value2.required'] = 'value is required';  
        }
        $validation = Validator::make( 
            $request->toArray(), 
            $rules, 
            $messages
        );        
        if($validation->fails()) {  
            return back()->withInput()->withErrors($validation->messages());            
        }
        else{   
            
            //=== upload file
            $file = $request->file('image');
            if($file){
                $array = [
                    'file'=>$file,
                    'destination_path'=>'uploads/document_option',                    
                    'width'=>$this->width,
                    'height'=>$this->height,                  
                ];
                $image = AllFunction::upload_image($array);
            }
            else{
                $image = $request['image'] ?? '';
            }
            //=====

            if($is_table_value == 0){
                $value = $request['value1'] ?? '';                
            }
            else{
                $value = $request['value2'] ?? '';                
            }
           
            $data = Documents_question_option::query()
            ->where('option_id',$id)
            ->first()->toArray(); 
            $document_id = $data['document_id'] ?? '';
            $question_id = $data['question_id'] ?? '';

            $table = Documents_question_option::find($id);  
            $table->document_id     = $document_id;    
            $table->question_id     = $question_id;           
            $table->image           = $image;
            $table->placeholder     = $request['placeholder'] ?? '';
            $table->title           = $request['title'] ?? '';
            $table->value           = $value;
            $table->quick_info      = $request['quick_info'] ?? '';            
            $table->is_table_value  = $request['is_table_value'] ?? 0;
            $table->is_sub_question = $request['is_sub_question'] ?? 0;           
            $table->save();           
            return redirect( route('document.options.index',$question_id) )->with('message','Documents option updated successfully');
        }
    }
   
    public function destroy(string $id)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }


        $table = Documents_question_option::find($id); 
        $document_id = $table->document_id ?? ''; 
        $option_id   = $id;  

        $questionIdArry = [];      
        $q = DB::table('documents_question')
        ->select('question_id','option_id')
        ->where('document_id',$document_id)        
        ->where('option_id',$option_id)        
        ->orderBy("question_id","asc")->get()->toArray(); 
        $result = json_decode(json_encode($q), true);
        foreach($result as $val){
            $array = DocumentQuestionOptionController::get_option_questions($val['question_id']);           
            foreach($array as $k=>$v){               
                $questionIdArry[] = $v;               
            }
        }  

        //=== delete documents_question_option & it's image ===                
        $optionIdArry = [];  
        $q = DB::table('documents_question_option')
        ->where('document_id',$document_id)
        ->whereIn('question_id', $questionIdArry)
        ->orderBy("option_id","asc")->get()->toArray(); 
        $result = json_decode(json_encode($q), true);
        foreach($result as $val){   

            $optionIdArry[] = $val['option_id'];

            $delArr = array(
            'file_path'=>'uploads/document_option',
            'file_name'=>$val['image']
            );
            AllFunction::delete_file($delArr);
        }  
        
        $q = DB::table('documents_question_option')        
        ->whereIn('option_id',$optionIdArry)
        ->delete(); 

        //=== delete documents_question ===
        $q = DB::table('documents_question')        
        ->whereIn('question_id',$questionIdArry)
        ->delete(); 

        $table = Documents_question_option::find($id); 
        $question_id = $table->question_id ?? '';  
        $tableData = $table->toArray();

        //== unlink file         
        $delArr = array(
             'file_path'=>'uploads/document_option',
             'file_name'=>$tableData['image']
        );
        AllFunction::delete_file($delArr);
        //======

        $table->delete();

        return json_encode(array(
            'status'=>'success',
            'url'=>route('document.options.index',$question_id)
        ));
        exit;
    }
    public function get_option_questions($question_id, $returnArr = array() ){
        $returnArr[] = $question_id;   
        $q = DB::table('documents_question_option')
        ->select('option_id','question_id')
        ->where('question_id',$question_id)
        ->orderBy('option_id','asc')
        ->get()->toArray();         
        $o_result = json_decode(json_encode($q), true);
        foreach($o_result as $val){
            
            $q = DB::table('documents_question')->select('question_id','option_id')
            ->where('option_id',$val['option_id'])
            ->orderBy('question_id','asc')
            ->get()->toArray(); 
            $q_result = json_decode(json_encode($q), true);
            foreach($q_result as $val2){               
                $returnArr = DocumentQuestionOptionController::get_option_questions($val2['question_id'],$returnArr);            
            } 
            
        }        
        return $returnArr;
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
