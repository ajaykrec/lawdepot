<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Traits\AllFunction;
use App\Models\Document;
use App\Models\Documents_step;
use App\Models\Documents_faq;

class DocumentFaqController extends Controller
{
    use AllFunction; 
    
    public function index($step_id,Request $request)
    {       
        //=== check permision
        if(!has_permision(['document'])){ return redirect( route('dashboard') ); }

        $step = Documents_step::find($step_id)->toArray();        

        $meta = [
            'title'=>'Faqs for : '.$step['name'] ?? '',
            'keywords'=>'',
            'description'=>'',
        ];    
        $document_id   = $step['document_id'] ?? '';        

        $filterArr                 = [];
        $filterArr['step_id']      = $step_id;
        $filterArr['question']     = $request['question'] ?? '';
        $filterArr['status']       = $request['status'] ?? '';   

        //=== pagi_url
        $pagi_url = route('document.faqs.index',$step_id).'?';
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

        $q = Documents_faq::query();
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'step_id'){
                        $q->where('step_id',$val);
                    }
                    if($key == 'question'){
                        $q->where('question','like','%'.$val.'%');
                    }                    
                    if($key == 'status'){
                        $q->where('status',$val);
                    }
                }
            }
        }     
        $q->with(['step']);     
        $q->orderBy("label_group", "asc");     
        $q->orderBy("question", "asc"); 
        $count    = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 
        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);

        $data = compact('meta','results','count','start_count','paginate','document_id','step_id'); 
        $data = array_merge($data,$filterArr);        
       
        return view('admin.document_faqs.index')->with($data);
    }
    
    public function create($step_id)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }

        $step = Documents_step::find($step_id)->toArray();        
        $document_id   = $step['document_id'] ?? '';
        $group_count   = $step['group_count'] ?? 1;

        $meta = [
            'title'=>'Add Faq for : '.$step['name'] ?? '',
            'keywords'=>'',
            'description'=>'',
        ];    
        
        $data = compact('meta','step_id','document_id','group_count'); 
        return view('admin.document_faqs.create')->with($data);
    }

    public function store($step_id,Request $request)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }

        //==== apply_action =====
        $apply_action = $request['apply_action'] ?? '';
        if($apply_action){
            $id_array = $request['id'] ?? [];

            if( $apply_action == 'active' && $id_array){
                Documents_faq::whereIn('dfaq_id', $id_array)->update(array('status' => '1'));
                return redirect( route('document.faqs.index',$step_id) )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'in_active' && $id_array){                
                Documents_faq::whereIn('dfaq_id', $id_array)->update(array('status' => '0'));
                return redirect( route('document.faqs.index',$step_id) )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'delete' && $id_array){     
                Documents_faq::whereIn('dfaq_id', $id_array)->delete();
                return redirect( route('document.faqs.index',$step_id) )->with('message','Selected item deleted successfully');
            }  
        }

        //==== Add new data =====        
        $rules = [
            'question' => 'required',    
            'answer' => 'required',         
            'label_group' => 'required',                               
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

            // store
            $table = new Documents_faq;
            $table->step_id     = $step_id;
            $table->question    = $request['question'] ?? '';            
            $table->answer      = $request['answer'] ?? '';
            $table->label_group = $request['label_group']  ?? 1;
            $table->status      = $request['status'] ?? 1;
            $table->save();
            // redirect
            return redirect( route('document.faqs.index',$step_id) )->with('message','Document Faq created successfully');
        }        
    }
    
    public function show($step_id)
    {
        //====
    }
    
    public function edit($dfaq_id)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }

        $data = Documents_faq::query()
        ->with(['step'])
        ->where('dfaq_id',$dfaq_id)
        ->first()->toArray();         
        if(!$data){
            return redirect( route('document.index') );
        }        
        $step_id = $data['step_id'] ?? '';
        $document_id = $data['step']['document_id'] ?? '';
        $group_count = $data['step']['group_count'] ?? 1;

        $meta = [
            'title'=>'Edit step for : '.$data['step']['name'] ?? '',
            'keywords'=>'',
            'description'=>'',
        ];
        
        $data = compact('meta','data','step_id','document_id','dfaq_id','group_count');         
        return view('admin.document_faqs.edit')->with($data);
    }
    
    public function update(Request $request, string $dfaq_id)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }        

        $rules = [
            'question' => 'required',    
            'answer' => 'required',         
            'label_group' => 'required',                               
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
           
            $dstep_row = Documents_faq::query()
            ->with(['step'])
            ->where('dfaq_id',$dfaq_id)
            ->first()->toArray();       

            $step_id =  $dstep_row['step_id'] ?? '';  

            $table = Documents_faq::find($dfaq_id);            
            $table->step_id     = $step_id;
            $table->question    = $request['question'] ?? '';            
            $table->answer      = $request['answer'] ?? '';
            $table->label_group = $request['label_group']  ?? 1;
            $table->status      = $request['status'] ?? 1;
            $table->save();           
            return redirect( route('document.faqs.index',$step_id) )->with('message','Documents faq updated successfully');
        }
    }
   
    public function destroy(string $dfaq_id)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }

        $table = Documents_faq::find($dfaq_id); 
        $step_id =  $table->step_id ?? '';  
        $table->delete();

        return json_encode(array(
            'status'=>'success',
            'url'=>route('document.faqs.index',$step_id)
        ));
        exit;
    }
}
