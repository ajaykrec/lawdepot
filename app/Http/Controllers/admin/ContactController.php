<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Traits\AllFunction;
use App\Models\Contacts;

class ContactController extends Controller
{
    use AllFunction; 
    
    public function index(Request $request){
        //=== check permision
        if(!has_permision(['contact'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Contact',
            'keywords'=>'',
            'description'=>'',
        ];    
        
        $filterArr               = [];
        $filterArr['name']       = $request['name'] ?? '';
        $filterArr['email']      = $request['email'] ?? '';  

        //=== pagi_url
        $pagi_url = route('contact.index').'?';
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

        $q = Contacts::query();
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'name'){
                        $q->where('name','like','%'.$val.'%');
                    }
                    if($key == 'email'){
                        $q->where('email','like','%'.$val.'%');
                    }
                   
                }
            }
        }            
        $q->orderBy("created_at", "desc"); 
        $count = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 
        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);

        $data = compact('meta','results','count','start_count','paginate'); 
        $data = array_merge($data,$filterArr);        
       
        return view('admin.contact.index')->with($data);
    }
    
    public function create(){
        //
    }
    
    public function store(Request $request){

        //=== check permision
        if(!has_permision(['contact'=>'RW'])){ return redirect( route('dashboard') ); }
        
        //==== apply_action =====
        $apply_action = $request['apply_action'] ?? '';
        if($apply_action){
            $id_array = $request['id'] ?? [];

            if( $apply_action == 'active' && $id_array){   
                Contacts::whereIn('contact_id', $id_array)->update(array('status' => '1'));
                return redirect( route('contact.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'in_active' && $id_array){                 
                Contacts::whereIn('contact_id', $id_array)->update(array('status' => '0'));
                return redirect( route('contact.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'delete' && $id_array){                 
                Contacts::whereIn('contact_id', $id_array)->delete();
                return redirect( route('contact.index') )->with('message','Selected item deleted successfully');
            }  
        }
    }
    
    public function show($id){
        //=== check permision
        if(!has_permision(['contact'])){ return redirect( route('dashboard') ); }

        $data = Contacts::find($id); 
        if(!$data){
            return redirect( route('contact.index') );
        }
        $data = $data->toArray();
        
        if($data['status'] == '0'){
            Contacts::where('contact_id', $id)->update(array('status' => '1'));
        }        

        $meta = [
            'title'=>'View Contact',
            'keywords'=>'',
            'description'=>'',
        ];  
        
        $data = compact('meta','data'); 
        return view('admin.contact.show')->with($data);
    }
    
    public function edit($id){
        //
    }
    
    public function update(Request $request, $id){
        //
    }
    
    public function destroy($id){
        //=== check permision
        if(!has_permision(['contact'=>'RW'])){ return redirect( route('dashboard') ); }

        $table = Contacts::find($id);
        $table->delete();

        return json_encode(array(
            'status'=>'success',
            'url'=>route('contact.index')
        ));
        exit;
    }
}
