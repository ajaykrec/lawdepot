<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Traits\AllFunction;
use App\Models\Orders;
use App\Models\Orders_item;

class OrderController extends Controller
{
    use AllFunction; 
    
    public function index(Request $request)
    {
       
        //=== check permision
        if(!has_permision(['orders'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Orders',
            'keywords'=>'',
            'description'=>'',
        ];    
        
        $filterArr                  = [];
        $filterArr['name']          = $request['name'] ?? '';
        $filterArr['email']         = $request['email'] ?? '';
        $filterArr['phone']         = $request['phone'] ?? '';        
        $filterArr['order_status']  = $request['order_status'] ?? '';   

        //=== pagi_url
        $pagi_url = route('orders.index').'?';
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

        $limit  = 10;
        $page   = $request['_p'] ?? 1;
        $offset = ($page - 1)*$limit;
        $start_count  = ($page * $limit - $limit + 1);

        $q = Orders::query();
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'name'){
                        $q->where('name','like','%'.$val.'%');
                    }
                    if($key == 'email'){
                        $q->where('email','like','%'.$val.'%');
                    }
                    if($key == 'phone'){
                        $q->where('phone','like','%'.$val.'%');
                    }
                    if($key == 'order_status'){
                        $q->where('order_status',$val);
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
        return view('admin.orders.index')->with($data);
    }
    
    public function create(){   

    }
    
    public function store(Request $request){
        //=== check permision
        if(!has_permision(['orders'=>'RW'])){ return redirect( route('dashboard') ); }

        //==== apply_action =====
        $apply_action = $request['apply_action'] ?? '';
        if($apply_action){
            $id_array = $request['id'] ?? [];

            if( $apply_action == 'Pending' && $id_array){      
                Orders::whereIn('order_id', $id_array)->update(array('order_status' => '0'));
                return redirect( route('orders.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'Completed' && $id_array){                
                Orders::whereIn('order_id', $id_array)->update(array('order_status' => '1'));
                return redirect( route('orders.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'Cancelled' && $id_array){                
                Orders::whereIn('order_id', $id_array)->update(array('order_status' => '2'));
                return redirect( route('orders.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'delete' && $id_array){  
                Orders_item::whereIn('order_id', $id_array)->delete();              
                Orders::whereIn('order_id', $id_array)->delete();
                return redirect( route('orders.index') )->with('message','Selected item deleted successfully');
            }  
        }
    }

    public function show($id){
        //=== check permision
        if(!has_permision(['orders'])){ return redirect( route('dashboard') ); }

        $data = Orders::with('orderitems')->find($id); 
        if(!$data){
            return redirect( route('orders') );
        }
        $data = $data->toArray();
        $setting = AllFunction::get_setting([
            'site_name',
            'logo',
            'site_url',
            'contact_phone',
            'contact_email',
            'contact_address',
        ]);
        $data['setting']  = $setting;
        $data['show_tag'] = '1';
        //p($data);

        $meta = [
            'title'=>'View Orders',
            'keywords'=>'',
            'description'=>'',
        ];  
        
        $data = compact('meta','data'); 
        return view('admin.orders.show')->with($data);
    }
    
    public function edit($id){
        //=== check permision
        if(!has_permision(['orders'=>'RW'])){ return redirect( route('dashboard') ); }

        $data = Orders::find($id); 
        if(!$data){
            return redirect( route('orders') );
        }
        $data = $data->toArray();

        $meta = [
            'title'=>'Edit Orders',
            'keywords'=>'',
            'description'=>'',
        ];          
        $data = compact('meta','data','id');         
        return view('admin.orders.edit')->with($data);
    }
    
    public function update(Request $request, $id){
        //=== check permision
        if(!has_permision(['orders'=>'RW'])){ return redirect( route('dashboard') ); }

        $rules = [
            'order_status' => 'required',
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
            $table = Orders::find($id);
            $table->order_status = $request['order_status'] ?? 0;            
            $table->save();           
            return redirect( route('orders.index') )->with('message','Orders updated successfully');
        }
    }
   
    public function destroy($id){
        //=== check permision
        if(!has_permision(['orders'=>'RW'])){ return redirect( route('dashboard') ); }
   
        Orders_item::where('order_id', $id)->delete();
        Orders::where('order_id', $id)->delete();

        return json_encode(array(
            'status'=>'success',
            'url'=>route('orders.index')
        ));
        exit;
    }
}
