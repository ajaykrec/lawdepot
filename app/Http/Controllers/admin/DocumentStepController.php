<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Traits\AllFunction;
use App\Models\Document;
use App\Models\Document_category;
use App\Models\Documents_step;

class DocumentStepController extends Controller
{
    use AllFunction; 
    
    public function index($document_id,Request $request)
    {       
        //=== check permision
        if(!has_permision(['document'])){ return redirect( route('dashboard') ); }

        $document = Document::find($document_id)->toArray();         

        $meta = [
            'title'=>'Steps for : '.$document['name'] ?? '',
            'keywords'=>'',
            'description'=>'',
        ];    
        
        $filterArr                 = [];
        $filterArr['document_id']  = $document_id;
        $filterArr['name']         = $request['name'] ?? '';
        $filterArr['status']       = $request['status'] ?? '';   

        //=== pagi_url
        $pagi_url = route('document.steps.index',$document_id).'?';
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

        $q = Documents_step::query();
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'document_id'){
                        $q->where('document_id',$val);
                    }
                    if($key == 'name'){
                        $q->where('name','like','%'.$val.'%');
                    }                    
                    if($key == 'status'){
                        $q->where('status',$val);
                    }
                }
            }
        }     
        $q->with(['questions']);                
        $q->orderBy("sort_order", "asc"); 
        $count    = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 
        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);

        $data = compact('meta','results','count','start_count','paginate'); 
        $data = array_merge($data,$filterArr);        
       
        return view('admin.document_steps.index')->with($data);
    }
    
    public function create($document_id)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }

        $document = Document::find($document_id)->toArray(); 

        $meta = [
            'title'=>'Add step for : '.$document['name'] ?? '',
            'keywords'=>'',
            'description'=>'',
        ];    
        
        $data = compact('meta','document_id'); 
        return view('admin.document_steps.create')->with($data);
    }

    public function store($document_id,Request $request)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }

        //==== apply_action =====
        $apply_action = $request['apply_action'] ?? '';
        if($apply_action){
            $id_array = $request['id'] ?? [];

            if( $apply_action == 'active' && $id_array){
                Documents_step::whereIn('step_id', $id_array)->update(array('status' => '1'));
                return redirect( route('document.steps.index',$document_id) )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'in_active' && $id_array){                
                Documents_step::whereIn('step_id', $id_array)->update(array('status' => '0'));
                return redirect( route('document.steps.index',$document_id) )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'delete' && $id_array){     
                Documents_step::whereIn('step_id', $id_array)->delete();
                return redirect( route('document.steps.index',$document_id) )->with('message','Selected item deleted successfully');
            }  
        }

        //==== Add new data =====        
        $rules = [
            'name' => 'required',            
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
            $table = new Documents_step;
            $table->document_id         = $document_id;
            $table->name                = $request['name'];
            $table->sort_order          = $request['sort_order'] ?? 0;
            $table->status              = $request['status'] ?? 1;
            $table->save();
            // redirect
            return redirect( route('document.steps.index',$document_id) )->with('message','Document step created successfully');
        }        
    }
    
    public function show($step_id)
    {
        //====
    }
    
    public function edit($step_id)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }

        $data = Documents_step::query()
        ->with(['document'])
        ->where('step_id',$step_id)
        ->first()->toArray();         
        if(!$data){
            return redirect( route('document.index') );
        }        
        $document_id = $data['document_id'] ?? '';

        $meta = [
            'title'=>'Edit step for : '.$data['document']['name'] ?? '',
            'keywords'=>'',
            'description'=>'',
        ];
        
        $data = compact('meta','data','step_id','document_id');         
        return view('admin.document_steps.edit')->with($data);
    }
    
    public function update(Request $request, string $step_id)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }        

        $rules = [
            'name' => 'required',            
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
           
            $step_row = Documents_step::query()
            ->with(['document'])
            ->where('step_id',$step_id)
            ->first()->toArray();       

            $document_id =  $step_row['document_id'] ?? '';  

            $table = Documents_step::find($step_id);            
            $table->name         = $request['name'];            
            $table->sort_order   = $request['sort_order'] ?? '';
            $table->status       = $request['status'] ?? 1;
            $table->save();           
            return redirect( route('document.steps.index',$document_id) )->with('message','Documents step updated successfully');
        }
    }
   
    public function destroy(string $step_id)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }

        $table = Documents_step::find($step_id); 
        $document_id =  $table->document_id ?? '';  
        $table->delete();

        return json_encode(array(
            'status'=>'success',
            'url'=>route('document.steps.index',$document_id)
        ));
        exit;
    }
}
