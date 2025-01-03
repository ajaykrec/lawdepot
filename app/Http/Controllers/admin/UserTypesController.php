<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Users_type;
use App\Models\Modules;
use App\Traits\AllFunction;

class UserTypesController extends Controller
{
    use AllFunction; 
    
    public function index(Request $request){

        //=== check user is: superadmin 
        if( Auth::user()->users_types->usertype_id != '1'){ 
            return redirect( route('dashboard') );  
        }

        $meta = [
            'title'=>'User Types',
            'keywords'=>'',
            'description'=>'',
        ];    
        
        $filterArr               = [];
        $filterArr['user_type']  = $request['user_type'] ?? '';       

        //=== pagi_url
        $pagi_url = route('user-types.index').'?';
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

        $q = Users_type::query();
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'user_type'){
                        $q->where('user_type','like','%'.$val.'%');
                    }                    
                }
            }
        }            
        $q->orderBy("usertype_id", "asc"); 
        $count    = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 
        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);

        $data = compact('meta','results','count','start_count','paginate'); 
        $data = array_merge($data,$filterArr);        
       
        return view('admin.user_types.index')->with($data);
    }

    
    public function create(){
        //
    }    
    public function store(Request $request){
        //
    }    
    public function show($id){
        //
    }
    
    public function edit($id){

        //=== check user is: superadmin 
        if( Auth::user()->users_types->usertype_id != '1'){ 
            return redirect( route('dashboard') );  
        }

        $data = Users_type::find($id); 
        if(!$data){
            return redirect( route('user-types.index') );
        }
        else{
            $data    = $data->toArray();
            $modules = Modules::orderBy('name','asc')->get()->toArray();           
            $meta = [
                'title'=>'Edit User Type',
                'keywords'=>'',
                'description'=>'',
            ]; 
            
            $data = compact('meta','data','id','modules');         
            return view('admin.user_types.edit')->with($data);
        }
        
    }

    
    public function update(Request $request, $id){

        //=== check user is: superadmin 
        if( Auth::user()->users_types->usertype_id != '1'){ 
            return redirect( route('dashboard') );  
        }

        $rules = [
            'user_type' => 'required',           
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

            $table = Users_type::find($id);
            $table->user_type    = $request['user_type'];
            $table->modules      = json_encode($request['modules']);           
            $table->save();           
            return redirect( route('user-types.index') )->with('message','User type updated successfully');
        }
    }

    
    public function destroy($id){
        //
    }
}
