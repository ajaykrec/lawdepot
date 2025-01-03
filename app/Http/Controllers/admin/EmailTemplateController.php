<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Traits\AllFunction;
use App\Models\Email_templates;

class EmailTemplateController extends Controller
{
    use AllFunction; 

    public function index(Request $request)
    {
        //=== check permision
        if(!has_permision(['emailtemplates'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Email Templates',
            'keywords'=>'',
            'description'=>'',
        ];    
        
        $filterArr               = [];
        $filterArr['title']      = $request['title'] ?? '';
        $filterArr['status']     = $request['status'] ?? '';   

        //=== pagi_url
        $pagi_url = route('email-templates.index').'?';
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

        $q = Email_templates::query();
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'title'){
                        $q->where('title','like','%'.$val.'%');
                    }
                    if($key == 'status'){
                        $q->where('status',$val);
                    }
                }
            }
        }            
        $q->orderBy("title", "asc"); 
        $count = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 
        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);

        $data = compact('meta','results','count','start_count','paginate'); 
        $data = array_merge($data,$filterArr);        
       
        return view('admin.email_emplates.index')->with($data);
    }
    
    public function create()
    {
         //=== check permision
         if(!has_permision(['emailtemplates'=>'RW'])){ return redirect( route('dashboard') ); }

         $meta = [
             'title'=>'Add Email Template',
             'keywords'=>'',
             'description'=>'',
         ];          
         $data = compact('meta'); 
         return view('admin.email_emplates.create')->with($data);
    }
    
    public function store(Request $request)
    {
        //=== check permision
        if(!has_permision(['emailtemplates'=>'RW'])){ return redirect( route('dashboard') ); }

        //==== apply_action =====
        $apply_action = $request['apply_action'] ?? '';
        if($apply_action){
            $id_array = $request['id'] ?? [];

            if( $apply_action == 'active' && $id_array){ 
                Email_templates::whereIn('email_template_id', $id_array)->update(array('status' => '1'));
                return redirect( route('email-templates.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'in_active' && $id_array){                 
                Email_templates::whereIn('email_template_id', $id_array)->update(array('status' => '0'));
                return redirect( route('email-templates.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'delete' && $id_array){
                Email_templates::whereIn('email_template_id', $id_array)->delete();
                return redirect( route('email-templates.index') )->with('message','Selected item deleted successfully');
            }  
        }

        //==== Add new data =====
        $rules = [
            'title'     => 'required',
            'subject'   => 'required', 
            'body'      => 'required',             
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
            $table = new Email_templates;
            $table->title    = $request['title'];
            $table->subject  = $request['subject'];
            $table->body     = $request['body'] ;
            $table->status   = $request['status'] ?? '0';
            $table->save();
            // redirect
            return redirect( route('email-templates.index') )->with('message','Email Template created successfully');
        }        
    }
    
    public function show($id)
    {
        //=== check permision
        if(!has_permision(['emailtemplates'])){ return redirect( route('dashboard') ); }

        $data = Email_templates::find($id); 
        if(!$data){
            return redirect( route('email-templates.index') );
        }
        $data = $data->toArray();

        $meta = [
            'title'=>'View Email Template',
            'keywords'=>'',
            'description'=>'',
        ];  
        
        $data = compact('meta','data'); 
        return view('admin.email_emplates.show')->with($data);
    }
    
    public function edit($id)
    {
        //=== check permision
        if(!has_permision(['emailtemplates'=>'RW'])){ return redirect( route('dashboard') ); }

        $data = Email_templates::find($id); 
        if(!$data){
            return redirect( route('email-templates.index') );
        }
        $data = $data->toArray();

        $meta = [
            'title'=>'Edit Email Template',
            'keywords'=>'',
            'description'=>'',
        ];  
        
        $data = compact('meta','data','id');         
        return view('admin.email_emplates.edit')->with($data);
    }
    
    public function update(Request $request, $id)
    {
        //=== check permision
        if(!has_permision(['emailtemplates'=>'RW'])){ return redirect( route('dashboard') ); }

        $rules = [
            'title'     => 'required',
            'subject'   => 'required', 
            'body'      => 'required',  
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
            $table = Email_templates::find($id);
            $table->title    = $request['title'];
            $table->subject  = $request['subject'];
            $table->body     = $request['body'] ;
            $table->status   = $request['status'] ?? '0';
            $table->save();           
            return redirect( route('email-templates.index') )->with('message','Email Template updated successfully');
        }
    }
    
    public function destroy($id)
    {
        //=== check permision
        if(!has_permision(['emailtemplates'=>'RW'])){ return redirect( route('dashboard') ); }

        $table = Email_templates::find($id);
        $table->delete();

        return json_encode(array(
            'status'=>'success',
            'url'=>route('email-templates.index')
        ));
        exit;
    }
}
