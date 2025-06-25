<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Traits\AllFunction;
use App\Models\Membership;
use App\Models\Country;

class MembershipController extends Controller
{
    use AllFunction; 
    
    public function index(Request $request)
    {
        //=== check permision
        if(!has_permision(['membership'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Membership Setting',
            'keywords'=>'',
            'description'=>'',
        ];    
        
        $filterArr                      = [];
        $filterArr['name']              = $request['name'] ?? ''; 
        $filterArr['country_id']        = $request['country_id'] ?? '';
        $filterArr['status']            = $request['status'] ?? '';   
        $filterArr['mode']              = $request['mode'] ?? '';   
        

        //=== pagi_url
        $pagi_url = route('membership-setting.index').'?';
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

        $q = Membership::query();
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'name'){
                        $q->where('name','like','%'.$val.'%');
                    }   
                    if($key == 'country_id'){
                        $q->where('country_id', $val);
                    }  
                    if($key == 'mode'){
                        $q->where('mode', $val);
                    }
                    if($key == 'status'){
                        $q->where('status', $val);
                    }
                }
            }
        }    
        $q->with(['country']);         
        $q->orderBy("sort_order", "asc"); 
        $count    = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 
        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);

        $countries = Country::select('*')->orderBy("name", "asc")->get()->toArray();       

        $data = compact('meta','results','count','start_count','paginate','countries'); 
        $data = array_merge($data,$filterArr);        
       
        return view('admin.membership.index')->with($data);
    }
    
    public function create()
    {
        //=== check permision
        if(!has_permision(['membership'=>'RW'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Add Membership Setting',
            'keywords'=>'',
            'description'=>'',
        ];   
        $countries = Country::select('*')->orderBy("name", "asc")->get()->toArray();  

        $data = compact('meta','countries'); 
        return view('admin.membership.create')->with($data);
    }

    public function store(Request $request)
    {
        //=== check permision
        if(!has_permision(['membership'=>'RW'])){ return redirect( route('dashboard') ); }

        //==== apply_action =====
        $apply_action = $request['apply_action'] ?? '';
        if($apply_action){
            $id_array = $request['id'] ?? [];

            if( $apply_action == 'active' && $id_array){
                Membership::whereIn('membership_id', $id_array)->update(array('status' => '1'));
                return redirect( route('membership-setting.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'in_active' && $id_array){                
                Membership::whereIn('membership_id', $id_array)->update(array('status' => '0'));
                return redirect( route('membership-setting.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'delete' && $id_array){ 
                Membership::whereIn('membership_id', $id_array)->delete();
                return redirect( route('membership-setting.index') )->with('message','Selected item deleted successfully');
            }  
        }

        //==== Add new data =====        
        $rules = [
            'country_id'=> 'required',
            'name'    => 'required',
            'code'    => 'required',
            'price'   => 'required',   
            'time_period'   => 'required',            
            'time_period_sufix'   => 'required',                     
            'status'  => 'required',
            'mode'  => 'required',
            
        ];
        $messages = [];
        $messages['country_id.required'] = 'Country is required';
        $validation = Validator::make( 
            $request->toArray(), 
            $rules, 
            $messages
        );        
        if($validation->fails()) {            
            return back()->withInput()->withErrors($validation->messages());            
        }
        else{

            $country_id = $request['country_id'] ?? '';
            $country = Country::find($country_id);

            // store
            $table = new Membership;
            $table->country_id          = $request['country_id'] ?? '';
            $table->name                = $request['name'] ?? '';   
            $table->code                = $request['code'] ?? '';               
            $table->description         = $request['description'] ?? '';
            $table->specification       = json_encode($request['specification'] ?? '');
            $table->price               = $request['price'] ?? 0;
            $table->currency_code       = $country->currency_code ?? '';
            $table->time_period         = $request['time_period'] ?? 0;
            $table->time_period_sufix   = $request['time_period_sufix'] ?? '';   
            $table->mode                = $request['mode'] ?? '';
            $table->trial_period_days   = $request['trial_period_days'] ?? 0;
            $table->is_per_document     = $request['is_per_document'] ?? 0;
            $table->button_color        = $request['button_color'] ?? '';  
            
            $table->sort_order          = ( $request['sort_order'] == '' ) ? 0 : $request['sort_order'];
            $table->status              = $request['status'] ?? 1;
            $table->save();
            // redirect
            return redirect( route('membership-setting.index') )->with('message','Membership created successfully');
        }        
    }
    
    public function show(string $id){
        //===
    }
    
    public function edit(string $id)
    {
        //=== check permision
        if(!has_permision(['membership'=>'RW'])){ return redirect( route('dashboard') ); }

        $data = Membership::find($id); 
        if(!$data){
            return redirect( route('membership-setting.index') );
        }
        $data = $data->toArray();
        $meta = [
            'title'=>'Edit Membership Setting',
            'keywords'=>'',
            'description'=>'',
        ];

        $countries = Country::select('*')->orderBy("name", "asc")->get()->toArray();  
        
        $data = compact('meta','data','id','countries');         
        return view('admin.membership.edit')->with($data);
    }
    
    public function update(Request $request, string $id)
    {
        //=== check permision
        if(!has_permision(['membership'=>'RW'])){ return redirect( route('dashboard') ); }

        $rules = [
            'country_id'=> 'required',
            'name'    => 'required',
            'code'    => 'required',
            'price'   => 'required',   
            'time_period'   => 'required',            
            'time_period_sufix'   => 'required',                     
            'status'  => 'required',
            'mode' => 'required',
        ];
        $messages = [];
        $messages['country_id.required'] = 'Country is required';
        $validation = Validator::make( 
            $request->toArray(), 
            $rules, 
            $messages
        );        
        if($validation->fails()) {            
            return back()->withInput()->withErrors($validation->messages());            
        }
        else{

            $country_id = $request['country_id'] ?? '';
            $country = Country::find($country_id);

            $table = Membership::find($id);
            $table->country_id          = $request['country_id'] ?? '';
            $table->name                = $request['name'] ?? '';      
            $table->code                = $request['code'] ?? '';         
            $table->description         = $request['description'] ?? '';
            $table->specification       = json_encode($request['specification'] ?? '');    
            $table->price               = $request['price'] ?? 0;
            $table->currency_code       = $country->currency_code ?? '';
            $table->time_period         = $request['time_period'] ?? 0;
            $table->time_period_sufix   = $request['time_period_sufix'] ?? '';
            $table->mode                = $request['mode'] ?? '';
            $table->trial_period_days   = $request['trial_period_days'] ?? 0;
            $table->is_per_document     = $request['is_per_document'] ?? 0;
            $table->button_color        = $request['button_color'] ?? '';   

            $table->sort_order          = ( $request['sort_order'] == '' ) ? 0 : $request['sort_order'];
            $table->status              = $request['status'] ?? 1;
            $table->save();           
            return redirect( route('membership-setting.index') )->with('message','Membership updated successfully');
        }
    }
   
    public function destroy(string $id)
    {
        //=== check permision
        if(!has_permision(['membership'=>'RW'])){ return redirect( route('dashboard') ); }

        $table = Membership::find($id); 
        $table->delete();

        return json_encode(array(
            'status'=>'success',
            'url'=>route('membership-setting.index')
        ));
        exit;
    }
}
