<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Users_type;
use App\Traits\AllFunction; 

class UserController extends Controller
{

    use AllFunction; 
    
    public function index(Request $request)
    {
        //=== check user is: superadmin 
        if( Auth::user()->users_types->usertype_id != '1'){ 
            return redirect( route('dashboard') );  
        }

        $meta = [
            'title'=>'Users',
            'keywords'=>'',
            'description'=>'',
        ];    
        
        $filterArr               = [];
        $filterArr['name']       = $request['name'] ?? '';
        $filterArr['email']      = $request['email'] ?? '';  
        $filterArr['usertype_id']= $request['usertype_id'] ?? '';  
        $filterArr['status']     = $request['status'] ?? '';  
        $filterArr['created_at'] = $request['created_at'] ?? '';   

        //=== pagi_url
        $pagi_url = route('users.index').'?';
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

        $q = User::query();
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'name'){
                        $q->where('name','like','%'.$val.'%');
                    }
                    if($key == 'email'){
                        $q->where('email','like','%'.$val.'%');
                    }
                    if($key == 'usertype_id'){
                        $q->where('usertype_id',$val);
                    }
                    if($key == 'created_at'){
                        $q->whereDate('created_at',date('Y-m-d',strtotime($val)));
                    }
                    if($key == 'status'){
                        $q->where('status',$val);
                    }
                }
            }
        }            
        $q->orderBy("name", "asc"); 
        $count    = $q->count();     
        $results  = $q->with('users_types')->limit($limit)->offset($offset)->get()->toArray(); 
        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);

        $user_types = Users_type::orderBy('user_type')->get()->toArray(); 

        $data = compact('meta','results','count','start_count','paginate','user_types'); 
        $data = array_merge($data,$filterArr);        
       
        return view('admin.users.index')->with($data);
    }

    
    public function create()
    {
        //=== check user is: superadmin 
        if( Auth::user()->users_types->usertype_id != '1'){ 
            return redirect( route('dashboard') );  
        }

        $meta = [
            'title'=>'Add User',
            'keywords'=>'',
            'description'=>'',
        ];          
        $user_types = Users_type::where('usertype_id','!=','1')->orderBy('user_type')->get()->toArray(); 
        $data = compact('meta','user_types'); 
        return view('admin.users.create')->with($data);
    }

    
    public function store(Request $request)
    {
        //=== check user is: superadmin 
        if( Auth::user()->users_types->usertype_id != '1'){ 
            return redirect( route('dashboard') );  
        }

        //==== apply_action =====
        $apply_action = $request['apply_action'] ?? '';
        if($apply_action){
            $id_array = $request['id'] ?? [];

            if( $apply_action == 'active' && $id_array){
                User::whereIn('user_id', $id_array)->update(array('status' => '1'));
                return redirect( route('users.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'in_active' && $id_array){
                User::whereIn('user_id', $id_array)->update(array('status' => '0'));
                return redirect( route('users.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'delete' && $id_array){
                User::whereIn('user_id', $id_array)->delete();
                return redirect( route('users.index') )->with('message','Selected item deleted successfully');
            }  
        }

        //==== Add new data =====
        $rules = [
            'name' => 'required',
            'email'   => 'required|email|unique:users',             
            'password'   => 'required|min:6',
            'phone_number'   => 'required',
            'usertype_id'   => 'required',
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
            $table = new User;
            $table->name            = $request['name'];
            $table->email           = $request['email'];
            $table->password        = Hash::make($request['password']);
            $table->phone_number    = $request['phone_number'];            
            $table->usertype_id     = $request['usertype_id'];
            $table->company         = $request['company'];
            $table->country         = $request['country'];
            $table->address         = $request['address'];            
            $table->status          = $request['status'] ?? 0;            
            $table->save();
            // redirect
            return redirect( route('users.index') )->with('message','User created successfully');
        }        
    }

    
    public function show($id)
    {
        //=== check user is: superadmin 
        if( Auth::user()->users_types->usertype_id != '1'){ 
            return redirect( route('dashboard') );  
        }

        $data = User::with('users_types')->find($id); 
        if(!$data){
            return redirect( route('users.index') );
        }
        $data = $data->toArray();       

        $return_social_media = [];
        $social_media_table  = (array) json_decode($data['social_media']);
        if($social_media_table){
            foreach($social_media_table as $key=>$val){
                $val = (array) $val;
                $return_social_media[$key] = $val;                
            }
        }  
        $data['social_media'] = $return_social_media;  

        $meta = [
            'title'=>'View User',
            'keywords'=>'',
            'description'=>'',
        ];  
        $data = compact('meta','data'); 
        return view('admin.users.show')->with($data);
    }

    
    public function edit($id)
    {
        //=== check user is: superadmin 
        if( Auth::user()->users_types->usertype_id != '1'){ 
            return redirect( route('dashboard') );  
        }

        $data = User::find($id); 
        if(!$data){
            return redirect( route('users.index') );
        }
        $data = $data->toArray();

        $meta = [
            'title'=>'Edit User',
            'keywords'=>'',
            'description'=>'',
        ];  
        $user_types = Users_type::where('usertype_id','!=','1')->orderBy('user_type')->get()->toArray(); 
        $data = compact('meta','data','id','user_types');         
        return view('admin.users.edit')->with($data);
    }

    
    public function update(Request $request, $id)
    {
        //=== check user is: superadmin 
        if( Auth::user()->users_types->usertype_id != '1'){ 
            return redirect( route('dashboard') );  
        }

        $user = Auth::user()->toArray();
        $loggedin_usertype_id = $user['usertype_id'];

        $rules = [
            'name'          => 'required',
            'email'         => 'required|email|unique:users,email,'.$id.',user_id',             
            'phone_number'  => 'required',    
            'usertype_id'   => 'required',                  
        ];
       
        if( $request['password'] !='' ){
            $rules['password'] = 'required|min:6';
        }
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
            $table = User::find($id);
            $table->name            = $request['name'];
            $table->email           = $request['email'];            
            
            if( $request['password'] !='' ){
                $table->password    = Hash::make($request['password']);
            }            
            $table->phone_number    = $request['phone_number']; 
            $table->company         = $request['company'];
            $table->country         = $request['country'];
            $table->address         = $request['address']; 
            $table->usertype_id     = $request['usertype_id'];
            $table->status          = $request['status'] ?? 0;       
            $table->save();           
            return redirect( route('users.index') )->with('message','User updated successfully');
        }
    }
    
    public function destroy($id)
    {
        //=== check user is: superadmin 
        if( Auth::user()->users_types->usertype_id != '1'){ 
            return redirect( route('dashboard') );  
        }
        
        $table = User::find($id);
        $table->delete();

        return json_encode(array(
            'status'=>'success',
            'url'=>route('users.index')
        ));
        exit;
    }
}
