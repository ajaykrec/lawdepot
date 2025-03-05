<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Traits\AllFunction;
use App\Models\Customers;
use App\Models\Customers_membership;

class CustomerMembershipController extends Controller
{
    use AllFunction; 
    
    public function index($customer_id,Request $request)
    {       
        //=== check permision
        if(!has_permision(['customers'])){ return redirect( route('dashboard') ); }

        $customer = Customers::find($customer_id)->toArray();        

        $meta = [
            'title'=>'Membership for : '.$customer['name'] ?? '',
            'keywords'=>'',
            'description'=>'',
        ];   

        $filterArr                 = [];
        $filterArr['customer_id']  = $customer_id;
        $filterArr['status']       = $request['status'] ?? '';   

        //=== pagi_url
        $pagi_url = route('customers.membership.index',$customer_id).'?';
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

        $q = Customers_membership::query();
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'customer_id'){
                        $q->where('customer_id',$val);
                    }       
                    if($key == 'status'){
                        $q->where('status',$val);
                    }
                }
            }
        }     
        $q->with(['membership']);     
        $q->orderBy("created_at", "DESC");   
        $count    = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 
        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);

        $data = compact('meta','results','count','start_count','paginate','customer_id'); 
        $data = array_merge($data,$filterArr);        
       
        return view('admin.customers_membership.index')->with($data);
    }
    
    public function create($customer_id)
    {
        //==
    }

    public function store($customer_id,Request $request)
    {
        //=== check permision
        if(!has_permision(['customers'=>'RW'])){ return redirect( route('dashboard') ); }

        //==== apply_action =====
        $apply_action = $request['apply_action'] ?? '';
        if($apply_action){
            $id_array = $request['id'] ?? [];

            if( $apply_action == 'active' && $id_array){
                Customers_membership::whereIn('cus_membership_id', $id_array)->update(array('status' => '1'));
                return redirect( route('customers.membership.index',$customer_id) )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'in_active' && $id_array){                
                Customers_membership::whereIn('cus_membership_id', $id_array)->update(array('status' => '0'));
                return redirect( route('customers.membership.index',$customer_id) )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'delete' && $id_array){     
                Customers_membership::whereIn('cus_membership_id', $id_array)->delete();
                return redirect( route('customers.membership.index',$customer_id) )->with('message','Selected item deleted successfully');
            }  
        }

    }
    
    public function show($cus_membership_id)
    {
        //====
    }
    
    public function edit($cus_membership_id)
    {
        //===
    }
    
    public function update(Request $request, string $cus_membership_id)
    {
        //===
    }
   
    public function destroy(string $cus_membership_id)
    {
        //=== check permision
        if(!has_permision(['customers'=>'RW'])){ return redirect( route('dashboard') ); }

        $table = Customers_membership::find($cus_membership_id); 
        $customer_id =  $table->customer_id ?? '';  
        $table->delete();

        return json_encode(array(
            'status'=>'success',
            'url'=>route('customers.membership.index',$customer_id)
        ));
        exit;
    }
}
