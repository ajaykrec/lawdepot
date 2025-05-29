<?php 
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Traits\AllFunction;
use App\Models\Customers;
use App\Models\Customers_address;

use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    use AllFunction; 

    public function __construct(){
        $this->width  = 500;
        $this->height = 500;
    }
    
    public function index(Request $request)
    {
        //=== check permision
        if(!has_permision(['customers'])){ return redirect( route('dashboard') ); } 

        $meta = [
            'title'=>'Customers',
            'keywords'=>'',
            'description'=>'',
        ];    
        
        $filterArr               = [];
        $filterArr['name']       = $request['name'] ?? '';
        $filterArr['email']      = $request['email'] ?? '';
        $filterArr['phone']      = $request['phone'] ?? '';
        $filterArr['status']     = $request['status'] ?? '';   

        //=== pagi_url
        $pagi_url = route('customers.index').'?';
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

        $q = Customers::query();
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
                    if($key == 'status'){
                        $q->where('status',$val);
                    }
                }
            }
        }     
        $q->with(['membership','documents']);        
        $q->orderBy("name", "asc"); 
        $count = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 
        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);        

        $data = compact('meta','results','count','start_count','paginate'); 
        
        $data = array_merge($data,$filterArr);        
       
        return view('admin.customers.index')->with($data);
    }
    
    public function create()
    {
        //=== check permision
        if(!has_permision(['customers'=>'RW'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Add Customer',
            'keywords'=>'',
            'description'=>'',
        ];    
        $width  = $this->width; 
        $height = $this->height;  

        $countries = AllFunction::get_countries();  
        
        $data = compact('meta','width','height','countries'); 
        return view('admin.customers.create')->with($data);
    }

    public function store(Request $request)
    {
        //=== check permision
        if(!has_permision(['customers'=>'RW'])){ return redirect( route('dashboard') ); }

        //==== apply_action =====
        $apply_action = $request['apply_action'] ?? '';
        if($apply_action){
            $id_array = $request['id'] ?? [];

            if( $apply_action == 'active' && $id_array){      
                Customers::whereIn('customer_id', $id_array)->update(array('status' => '1'));
                return redirect( route('customers.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'in_active' && $id_array){                
                Customers::whereIn('customer_id', $id_array)->update(array('status' => '0'));
                return redirect( route('customers.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'delete' && $id_array){
                //== unlink file
                $result = Customers::query()->whereIn('customer_id', $id_array)->get()->toArray();
                if($result){
                    foreach($result as $val){
                        $delArr = array(
                            'file_path'=>'uploads/customers',
                            'file_name'=>$val['profile_photo']
                        );
                        AllFunction::delete_file($delArr);
                    }
                }                
                //======
                Customers::whereIn('customer_id', $id_array)->delete();
                Customers_address::whereIn('customer_id', $id_array)->delete();
                return redirect( route('customers.index') )->with('message','Selected item deleted successfully');
            }  
        }

        //==== Add new data =====  
        $rules = [
            'name'              => 'required',
            'email'             => 'required|unique:customers', 
            'phone'             => 'required|unique:customers', 
            'password'          => 'required|min:6',  
            'confirm_password'  => 'required|same:password',             
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

            //=== upload file
            $file = $request->file('profile_photo');
            if($file){
                $array = [
                    'file'=>$file,
                    'destination_path'=>'uploads/customers',                    
                    'width'=>$this->width,
                    'height'=>$this->height,                  
                ];
                $profile_photo = AllFunction::upload_image($array);
            }
            else{
                $profile_photo = $request['profile_photo'] ?? '';
            }

            $dob = $request['dob'] ?? '';   


            //==== add customer into Stripe ====
            $stripe = new \Stripe\StripeClient(env('STRIPE_Secret_key'));
            $stripe_response = $stripe->customers->create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone'=> $request['phone'],
            ]);
            //=====
            
            $table = new Customers;
            $table->profile_photo       = $profile_photo;
            $table->stripe_customer_id  = $stripe_response->id ?? '';                
            $table->name                = $request['name'];            
            $table->email               = $request['email'];
            $table->phone               = $request['phone'];
            $table->password            = Hash::make($request['password']);
            if($dob){
                $table->dob = date('Y-m-d',strtotime($dob));  
            }                             
            $table->status              = $request['status'] ?? 1;
            $table->save();
            return redirect( route('customers.index') )->with('message','Customer created successfully');
        }        
    }
    
    public function show(string $id)
    {
        //=== check permision
        if(!has_permision(['customers'])){ return redirect( route('dashboard') ); }        

        $data = (array) DB::table('customers')
        ->leftJoin('customers_address', 'customers_address.customer_id', '=', 'customers.customer_id')  
        ->leftJoin('country', 'country.country_id', '=', 'customers_address.country_id')    
        ->leftJoin('zones', 'zones.zone_id', '=', 'customers_address.zone_id')         
        ->select('customers.*', 'customers_address.*')
        ->where('customers.customer_id', $id)
        ->get()->first();  

        $meta = [
            'title'=>'View Customer',
            'keywords'=>'',
            'description'=>'',
        ];  
        
        $data = compact('meta','data'); 

        return view('admin.customers.show')->with($data);
    }
    
    public function edit(string $id)
    {
        //=== check permision
        if(!has_permision(['customers'=>'RW'])){ return redirect( route('dashboard') ); }

        $data = Customers::with('address')->find($id);         
        if(!$data){
            return redirect( route('customers.index') );
        }
        $data = $data->toArray();      

        $meta = [
            'title'=>'Edit Customer',
            'keywords'=>'',
            'description'=>'',
        ];

        $width  = $this->width; 
        $height = $this->height;

        $countries = AllFunction::get_countries();     
        
        $data = compact('meta','data','id','width','height','countries');         
        return view('admin.customers.edit')->with($data);
    }
    
    public function update(Request $request, string $id)
    {
        //=== check permision
        if(!has_permision(['customers'=>'RW'])){ return redirect( route('dashboard') ); }        
        $password = $request['password'] ?? '';
        $rules = [
            'name'      => 'required',
            'email'     => 'required|unique:customers,email,'.$id.',customer_id',  
            'phone'     => 'required|unique:customers,phone,'.$id.',customer_id',             
        ];
        if( $password !='' ){
            $rules['password'] = 'required|min:6';
            $rules['confirm_password'] = 'required|same:password';            
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

            //=== upload file
            $file = $request->file('profile_photo');
            if($file){
                $array = [
                    'file'=>$file,
                    'destination_path'=>'uploads/customers',                    
                    'width'=>$this->width,
                    'height'=>$this->height,                  
                ];
                $profile_photo = AllFunction::upload_image($array);
            }
            else{
                $profile_photo = $request['profile_photo'] ?? '';
            }

            
            $dob = $request['dob'] ?? '';   

            $table = Customers::find($id);
            $table->profile_photo       = $profile_photo;
            $table->name                = $request['name'];            
            $table->email               = $request['email'];
            $table->phone               = $request['phone'];
            if( $request['password'] !='' ){
                $table->password = Hash::make($request['password']);
            }             
            if($dob){
                $table->dob = date('Y-m-d',strtotime($dob));  
            }               
            $table->status              = $request['status'];
            $table->save();   
            
            $customer = $table->toArray();
            //==== update customer into Stripe ====
            $stripe = new \Stripe\StripeClient(env('STRIPE_Secret_key'));
            $customer = $stripe->customers->update(
                $customer['stripe_customer_id'],
                [
                    'name' => $customer['name'],
                    'email' => $customer['email'],
                    'phone' => $customer['phone'],
                ]
            );           
            //=====            

            return redirect( route('customers.index') )->with('message','Customer updated successfully');
        }
    }
   
    public function destroy(string $id)
    {
        //=== check permision
        if(!has_permision(['customers'=>'RW'])){ return redirect( route('dashboard') ); }

        $table = Customers::find($id); 
        $tableData = $table->toArray();
        //== unlink file        
        $delArr    = array(
            'file_path'=>'uploads/customers',
            'file_name'=>$tableData['profile_photo']
        );
        AllFunction::delete_file($delArr);
        //======

        //==== delete customer from Stripe ====
        $stripe = new \Stripe\StripeClient(env('STRIPE_Secret_key'));
        $deleted = $stripe->customers->delete($tableData['stripe_customer_id'], []);
        //=====   

        $table->delete();        
        Customers_address::where('customer_id', $id)->delete();

        return json_encode(array(
            'status'=>'success',
            'url'=>route('customers.index')
        ));
        exit;
    }
}
