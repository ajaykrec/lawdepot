<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Traits\AllFunction;
use App\Models\Country;
use App\Models\Zones;
use Illuminate\Support\Facades\DB;

class ZonesController extends Controller
{
    use AllFunction;     
    
    public function index(Request $request)
    {
        //=== check permision
        if(!has_permision(['zones'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Zones',
            'keywords'=>'',
            'description'=>'',
        ];    
        
        $filterArr                  = [];
        $filterArr['country_id']    = $request['country_id'] ?? '';        
        $filterArr['zone_name']     = $request['zone_name'] ?? '';  
        $filterArr['zone_code']     = $request['zone_code'] ?? '';
        $filterArr['status']        = $request['status'] ?? '';   

        //=== pagi_url
        $pagi_url = route('zones.index').'?';
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

        $q = Zones::query();
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'country_id'){
                        $q->where('country_id',$val);
                    }
                    if($key == 'zone_name'){
                        $q->where('zone_name','like','%'.$val.'%');
                    }
                    if($key == 'zone_code'){
                        $q->where('zone_code','like','%'.$val.'%');
                    }                    
                    if($key == 'status'){
                        $q->where('status',$val);
                    }
                }
            } 
        }   
        $q->with('country');  
        $q->orderBy("zone_name", "asc"); 
        $count = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 

        //p($results);
        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);

        $countries = AllFunction::get_countries();  

        $data = compact('meta','results','count','start_count','paginate','countries'); 
        $data = array_merge($data,$filterArr);        
       
        return view('admin.zones.index')->with($data);
    }
    
    public function create()
    {
        //=== check permision
        if(!has_permision(['zones'=>'RW'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Add Zones',
            'keywords'=>'',
            'description'=>'',
        ]; 
        $countries = AllFunction::get_countries();  
        $data = compact('meta','countries'); 
        return view('admin.zones.create')->with($data);
    }

    public function store(Request $request)
    {
        //=== check permision
        if(!has_permision(['zones'=>'RW'])){ return redirect( route('dashboard') ); }

        //==== apply_action =====
        $apply_action = $request['apply_action'] ?? '';
        if($apply_action){
            $id_array = $request['id'] ?? [];

            if( $apply_action == 'active' && $id_array){               
                Zones::whereIn('zone_id', $id_array)->update(array('status' => '1'));
                return redirect( route('zones.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'in_active' && $id_array){                
                Zones::whereIn('zone_id', $id_array)->update(array('status' => '0'));
                return redirect( route('zones.index') )->with('message','Selected item Updated successfully');
            }           
            else if( $apply_action == 'delete' && $id_array){  
                Zones::whereIn('zone_id', $id_array)->delete();
                return redirect( route('zones.index') )->with('message','Selected item deleted successfully');
            }  
        }

        //==== Add new data =====        
        $rules = [
            'country_id'    => 'required',
            'zone_name'     => 'required',
            'zone_code'     => 'required',            
            'status'        => 'required'
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
            $table = new Zones;
            $table->country_id      = $request['country_id'];            
            $table->zone_name       = $request['zone_name'];            
            $table->zone_code       = $request['zone_code'];           
            $table->status          = $request['status'] ?? 0;   
            $table->save();
            // redirect
            return redirect( route('zones.index') )->with('message','Zones created successfully');
        }        
    }
    
    public function show(string $id)
    {
        //====
    }
    
    public function edit(string $id)
    {
        //=== check permision
        if(!has_permision(['zones'=>'RW'])){ return redirect( route('dashboard') ); }

        $data = Zones::find($id); 
        if(!$data){
            return redirect( route('zones.index') );
        }
        $data = $data->toArray();

        $meta = [
            'title'=>'Edit Zones',
            'keywords'=>'',
            'description'=>'',
        ];  
        $countries = AllFunction::get_countries();      
        $data = compact('meta','data','id','countries');         
        return view('admin.zones.edit')->with($data);
    }
    
    public function update(Request $request, string $id)
    {
        
        //=== check permision
        if(!has_permision(['zones'=>'RW'])){ return redirect( route('dashboard') ); }
       
        $rules = [
            'country_id'    => 'required',
            'zone_name'     => 'required',            
            'zone_code'     => 'required',             
            'status'        => 'required'
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
            
            $table = Zones::find($id);
            $table->country_id     = $request['country_id'];            
            $table->zone_name      = $request['zone_name'];            
            $table->zone_code      = $request['zone_code'];           
            $table->status         = $request['status'] ?? 0;         
            $table->save();           
            return redirect( route('zones.index') )->with('message','Zones updated successfully');
        }
    }
   
    public function destroy(string $id)
    {
        //=== check permision
        if(!has_permision(['zones'=>'RW'])){ return redirect( route('dashboard') ); }

        $table = Zones::find($id);       
        $table->delete();

        return json_encode(array(
            'status'=>'success',
            'url'=>route('zones.index')
        ));
        exit;
    }
}
