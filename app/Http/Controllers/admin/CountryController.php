<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Traits\AllFunction;
use App\Models\Country;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    use AllFunction; 

    public function __construct(){
        $this->width  = 300;
        $this->height = 200;
    }
    
    public function index(Request $request)
    {
        //=== check permision
        if(!has_permision(['country'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Country',
            'keywords'=>'',
            'description'=>'',
        ];    
        
        $filterArr                  = [];
        $filterArr['language_id']   = $request['language_id'] ?? '';
        $filterArr['name']          = $request['name'] ?? '';
        $filterArr['code']          = $request['code'] ?? '';  
        $filterArr['status']        = $request['status'] ?? '';   

        //=== pagi_url
        $pagi_url = route('country.index').'?';
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

        $q = Country::query();
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'language_id'){
                        $q->where('language_id',$val);
                    }
                    if($key == 'name'){
                        $q->where('name','like','%'.$val.'%');
                    }
                    if($key == 'code'){
                        $q->where('code','like','%'.$val.'%');
                    }                    
                    if($key == 'status'){
                        $q->where('status',$val);
                    }
                }
            } 
        }   
        $q->with('language');    
        $q->orderBy("default", "desc");      
        $q->orderBy("sort_order", "asc"); 
        $count = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 
        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);

        $languages = AllFunction::get_languages();   

        $data = compact('meta','results','count','start_count','paginate','languages'); 
        $data = array_merge($data,$filterArr);        
       
        return view('admin.country.index')->with($data);
    }
    
    public function create()
    {
        //=== check permision
        if(!has_permision(['country'=>'RW'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Add Country',
            'keywords'=>'',
            'description'=>'',
        ];      
        $width  = $this->width; 
        $height = $this->height;  
        $languages = AllFunction::get_languages();       

        $data = compact('meta','width','height','languages'); 
        return view('admin.country.create')->with($data);
    }

    public function store(Request $request)
    {
        //=== check permision
        if(!has_permision(['country'=>'RW'])){ return redirect( route('dashboard') ); }

        //==== apply_action =====
        $apply_action = $request['apply_action'] ?? '';
        if($apply_action){
            $id_array = $request['id'] ?? [];

            if( $apply_action == 'active' && $id_array){               
                Country::whereIn('country_id', $id_array)->update(array('status' => '1'));
                return redirect( route('country.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'in_active' && $id_array){                
                Country::whereIn('country_id', $id_array)->update(array('status' => '0'));
                return redirect( route('country.index') )->with('message','Selected item Updated successfully');
            }           
            else if( $apply_action == 'delete' && $id_array){   
                //== unlink file
                $result = Country::query()->whereIn('country_id', $id_array)->get()->toArray();
                if($result){
                    foreach($result as $val){
                        $delArr = array(
                            'file_path'=>'uploads/country',
                            'file_name'=>$val['image']
                        );
                        AllFunction::delete_file($delArr);
                    }
                }                
                //======            
                Country::whereIn('country_id', $id_array)->delete();
                return redirect( route('country.index') )->with('message','Selected item deleted successfully');
            }  
        }

        //==== Add new data =====        
        $rules = [
            'language_id'=> 'required',
            'name'     => 'required',
            'code'     => 'required|unique:country', 
            'currency_code' => 'required|unique:country', 
            'image'    => 'required|mimes:png,jpeg,gif,webp|image|max:2048', // size : 1024*2 = 2048 = 2MB
            'status'   => 'required'
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
            $file = $request->file('image');
            if($file){
                $array = [
                    'file'=>$file,
                    'destination_path'=>'uploads/country',                    
                    'width'=>$this->width,
                    'height'=>$this->height,      
                ];
                $image = AllFunction::upload_image($array);
            }
            else{
                $image = $request['image'] ?? '';
            }

            $status = $request['status'] ?? 0; 
            if($request['default'] == 1){
                Country::whereIn('default', [0,1])->update(array('default' => '0'));
                $status = 1;
            }            

            // store
            $table = new Country;
            $table->language_id     = $request['language_id'];            
            $table->name            = $request['name'];             
            $table->code            = $request['code'];
            $table->currency_code   = $request['currency_code'];
            $table->image           = $image ?? '';  
            $table->default         = $request['default'] ?? 0;                   
            $table->status          = $status; 
            $table->sort_order      = $request['sort_order'] ?? 0;                 
            $table->save();
            // redirect
            return redirect( route('country.index') )->with('message','Country created successfully');
        }        
    }
    
    public function show(string $id)
    {
        //====
    }
    
    public function edit(string $id)
    {
        //=== check permision
        if(!has_permision(['country'=>'RW'])){ return redirect( route('dashboard') ); }

        $data = Country::find($id); 
        if(!$data){
            return redirect( route('country.index') );
        }
        $data = $data->toArray();

        $meta = [
            'title'=>'Edit Country',
            'keywords'=>'',
            'description'=>'',
        ];  
        $width  = $this->width; 
        $height = $this->height;  
        $languages = AllFunction::get_languages();        
        $data = compact('meta','data','id','width','height','languages');         
        return view('admin.country.edit')->with($data);
    }
    
    public function update(Request $request, string $id)
    {
        
        //=== check permision
        if(!has_permision(['country'=>'RW'])){ return redirect( route('dashboard') ); }
       
        $rules = [
            'language_id'=> 'required',
            'name'     => 'required',            
            'code'     => 'required|unique:country,code,'.$id.',country_id',  
            'currency_code' => 'required|unique:country,currency_code,'.$id.',country_id',                        
            'status'   => 'required'
        ];         
        $image = $request['image'] ?? '';
        if(!$image){
            $rules['image'] = 'required|mimes:png,jpeg,gif,webp|image|max:2048'; // size : 1024*2 = 2048 = 2MB 
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
            $file = $request->file('image');
            if($file){
                $array = [
                    'file'=>$file,
                    'destination_path'=>'uploads/country',                    
                    'width'=>$this->width,
                    'height'=>$this->height,      
                ];
                $image = AllFunction::upload_image($array);
            }
            else{
                $image = $request['image'] ?? '';
            }

            $status = $request['status'] ?? 0; 
            if($request['default'] == 1){
                Country::whereIn('default', [0,1])->update(array('default' => '0'));
                $status = 1;
            }  
            
            $table = Country::find($id);
            $table->language_id     = $request['language_id'];            
            $table->name            = $request['name'];            
            $table->code            = $request['code'];
            $table->currency_code   = $request['currency_code'];
            $table->image           = $image ?? '';  
            $table->default         = $request['default'] ?? 0;                   
            $table->status          = $status; 
            $table->sort_order      = $request['sort_order'] ?? 0;         
            $table->save();           
            return redirect( route('country.index') )->with('message','Country updated successfully');
        }
    }
   
    public function destroy(string $id)
    {
        //=== check permision
        if(!has_permision(['country'=>'RW'])){ return redirect( route('dashboard') ); }

        $table = Country::find($id);
        $tableData  = $table->toArray();
        //== unlink file       
        $delArr = array(
        'file_path'=>'uploads/country',
        'file_name'=>$tableData['image']
        );
        AllFunction::delete_file($delArr);
        //======
        $table->delete();

        return json_encode(array(
            'status'=>'success',
            'url'=>route('country.index')
        ));
        exit;
    }
}
