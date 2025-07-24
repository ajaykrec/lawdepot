<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Traits\AllFunction;
use App\Models\Document_category;
use App\Models\Document;
use App\Models\Documents_step; 
use App\Models\Documents_faq;
use App\Models\Documents_question;
use App\Models\Documents_question_option;
use Illuminate\Support\Facades\DB;


class DocumentStepCopyController extends Controller
{
    use AllFunction;    
    
    public function create(Request $request, string $step_id)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }  

        $step = Documents_step::find($step_id)->toArray(); 

        $q = DB::table('documents')
        ->select('document_id','name','slug')
        ->where('document_id','!=', $step['document_id'])
        ->orderBy("name","asc")->get()->toArray(); 
        $documents = json_decode(json_encode($q), true);       

        $data = compact('step','documents'); 
        return view('admin.document_copy_steps.index')->with($data);

    }
    public function store(Request $request)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }  

        $parent_step_id  = $request['step_id'] ?? '';
        $step = Documents_step::find($parent_step_id)->toArray();
        $parent_document_id = $step['document_id'];
        $document_id = $request['document_id'] ?? '';   
        //========   
        
        $old_step_id_arry = [];
        $stepArry = [];    
        $count = -1;            
        $q = DB::table('documents_step')
        ->where('step_id',$parent_step_id)
        ->orderBy("step_id","asc")->get()->toArray(); 
        $documents_step = json_decode(json_encode($q), true);
        foreach($documents_step as $val){
            $count++;
            $stepArry[] = $val['step_id'];
            $old_step_id_arry[$val['step_id']] = $count;
        }          

        $q = DB::table('documents_faq')
        ->select('*')
        ->whereIn('step_id', $stepArry)
        ->orderBy("dfaq_id","asc")->get()->toArray(); 
        $documents_faq = json_decode(json_encode($q), true);         

        //====
        $returnQuestionIdArry = [];      
        $q = DB::table('documents_question')
        ->select('question_id','option_id')
        ->where('document_id',$parent_document_id)
        ->where('step_id',$parent_step_id)
        ->orderBy("question_id","asc")->get()->toArray(); 
        $documents_question = json_decode(json_encode($q), true);
        foreach($documents_question as $val){
            $array = DocumentStepCopyController::get_option_questions($val['question_id']);           
            foreach($array as $k=>$v){               
                $returnQuestionIdArry[] = $v;               
            }
        } 
        
        $old_question_id_arry = [];   
        $questionIdArry = [];      
        $count = -1;      
        $q = DB::table('documents_question')
        ->select('*')
        ->where('document_id',$parent_document_id)
        ->whereIn('question_id', $returnQuestionIdArry)
        ->orderBy("question_id","asc")->get()->toArray(); 
        $documents_question = json_decode(json_encode($q), true);
        foreach($documents_question as $val){
            $count++;
            $questionIdArry[] = $val['question_id'];
            $old_question_id_arry[$val['question_id']] = $count;            
        } 
        //p($documents_question);
        //p($questionIdArry);
        //p($old_question_id_arry);   
        //=====     

        $old_option_id_arry = [];   
        $count = -1;               
        $q = DB::table('documents_question_option')
        ->where('document_id',$parent_document_id)
        ->whereIn('question_id', $questionIdArry)
        ->orderBy("option_id","asc")->get()->toArray(); 
        $documents_question_option = json_decode(json_encode($q), true);
        foreach($documents_question_option as $val){
            $count++;
            $old_option_id_arry[$val['option_id']] = $count;
        } 
        
        //=== insert documents_step        
        $new_step_id_arry = [];
        foreach($documents_step as $val){
            $table = new Documents_step;            
            $table->document_id  = $document_id;
            $table->name         = $val['name'];
            $table->group_count  = $val['group_count'];           
            $table->sort_order   = $val['sort_order'];
            $table->status       = $val['status'];            
            $table->save(); 
            $new_step_id_arry[] = $table->step_id;
        } 
        
        //=== insert documents_faq         
        foreach($documents_faq as $val){
            $position = $old_step_id_arry[$val['step_id']];
            $table = new Documents_faq;            
            $table->step_id      = $new_step_id_arry[$position];
            $table->question     = $val['question'];
            $table->answer       = $val['answer'];           
            $table->label_group  = $val['label_group'];
            $table->status       = $val['status'];            
            $table->save();             
        }    
        
        //=== insert documents_question    
        $new_question_id_arry = [];     
        foreach($documents_question as $val){

            $step_id = $val['step_id'];
            if($val['step_id'] != '0'){
                $position = $old_step_id_arry[$val['step_id']];
                $step_id = $new_step_id_arry[$position];
            }            

            $table = new Documents_question;    
            $table->document_id         = $document_id;        
            $table->step_id             = $step_id;
            $table->option_id           = $val['option_id'];
            $table->label               = $val['label'];           
            $table->sort_order          = $val['sort_order'];
            $table->short_question      = $val['short_question'];  
            $table->question            = $val['question'];
            $table->quick_info          = $val['quick_info'];       
            $table->description         = $val['description'];
            $table->placeholder         = $val['placeholder'];       
            $table->answer_type         = $val['answer_type'];
            $table->display_type        = $val['display_type'];       
            $table->field_name          = $val['field_name'];
            $table->label_group         = $val['label_group'];       
            $table->blank_space         = $val['blank_space'];
            $table->is_add_another      = $val['is_add_another'];       
            $table->add_another_max     = $val['add_another_max'];
            $table->add_another_text    = $val['add_another_text'];             
            $table->add_another_button_text = $val['add_another_button_text']; 
            $table->save(); 
            $new_question_id_arry[] = $table->question_id;            
        } 
        
        //=== insert documents_question_option    
        $new_option_id_arry = [];     
        foreach($documents_question_option as $val){
           
            if($val['image']){
                $array = [
                    'file_name'=>$val['image'],
                    'destination_path'=>'uploads/document_option', 
                ];
                $image = AllFunction::copy_file($array);
            }
            else{
                $image = '';
            }  

            $position = $old_question_id_arry[$val['question_id']];           

            $table = new Documents_question_option;    
            $table->document_id         = $document_id;        
            $table->question_id         = $new_question_id_arry[$position];
            $table->image               = $image;        
            $table->placeholder         = $val['placeholder'];           
            $table->title               = $val['title'];
            $table->value               = $val['value'];  
            $table->quick_info          = $val['quick_info'];       
            $table->is_table_value      = $val['is_table_value'];
            $table->is_sub_question     = $val['is_sub_question'];   
            $table->save(); 
            $new_option_id_arry[] = $table->option_id;            
        }    
        
        //=== update option_id in documents_question  
        $q = DB::table('documents_question')
        ->select('question_id','option_id')
        ->where('document_id',$document_id)
        ->whereIn('question_id',$new_question_id_arry) 
        ->orderBy("question_id","asc")->get()->toArray(); 
        $documents_question = json_decode(json_encode($q), true);
        foreach($documents_question as $val){

            $option_id = $val['option_id'];
            if($val['option_id'] != '0'){
                $position  = $old_option_id_arry[$val['option_id']];
                $option_id = $new_option_id_arry[$position];
            }            

            $table = Documents_question::find($val['question_id']);  
            $table->option_id = $option_id; 
            $table->save();           
        }  

        return json_encode(array(
            'status'=>'success',
            'url'=>route('document.steps.index',$document_id) 
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
                $returnArr = DocumentStepCopyController::get_option_questions($val2['question_id'],$returnArr);            
            } 
            
        }        
        return $returnArr;
    }


}
