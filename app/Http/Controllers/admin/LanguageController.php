<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Traits\AllFunction;
use App\Models\Language;

class LanguageController extends Controller
{
    use AllFunction; 

    public function __construct(){
        $this->width  = 300;
        $this->height = 200;
    }
    
    public function index(Request $request)
    {
        //=== check permision
        if(!has_permision(['language'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Language',
            'keywords'=>'',
            'description'=>'',
        ];    
        
        $filterArr               = [];
        $filterArr['name']       = $request['name'] ?? '';
        $filterArr['code']       = $request['code'] ?? '';
        $filterArr['default']    = $request['default'] ?? '';  
        $filterArr['status']     = $request['status'] ?? '';   

        //=== pagi_url
        $pagi_url = route('language.index').'?';
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

        $q = Language::query();
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'name'){
                        $q->where('name','like','%'.$val.'%');
                    }
                    if($key == 'code'){
                        $q->where('code','like','%'.$val.'%');
                    }
                    if($key == 'default'){
                        $q->where('default',$val);
                    }
                    if($key == 'status'){
                        $q->where('status',$val);
                    }
                }
            }
        }     
        $q->orderBy("default", "desc");             
        $q->orderBy("sort_order", "asc"); 
        $count = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 
        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);

        $data = compact('meta','results','count','start_count','paginate'); 
        $data = array_merge($data,$filterArr);        
       
        return view('admin.language.index')->with($data);
    }
    
    public function create()
    {
        //=== check permision
        if(!has_permision(['language'=>'RW'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Add Language',
            'keywords'=>'',
            'description'=>'',
        ];      
        $width  = $this->width; 
        $height = $this->height;       
        $data = compact('meta','width','height'); 
        return view('admin.language.create')->with($data);
    }

    public function store(Request $request)
    {
        //=== check permision
        if(!has_permision(['language'=>'RW'])){ return redirect( route('dashboard') ); }

        //==== apply_action =====
        $apply_action = $request['apply_action'] ?? '';
        if($apply_action){
            $id_array = $request['id'] ?? [];

            if( $apply_action == 'active' && $id_array){               
                Language::whereIn('language_id', $id_array)->update(array('status' => '1'));
                return redirect( route('language.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'in_active' && $id_array){                
                Language::whereIn('language_id', $id_array)->update(array('status' => '0'));
                return redirect( route('language.index') )->with('message','Selected item Updated successfully');
            }           
            else if( $apply_action == 'delete' && $id_array){   
                //== unlink file
                $result = Language::query()->whereIn('language_id', $id_array)->get()->toArray();
                if($result){
                    foreach($result as $val){
                        $delArr = array(
                            'file_path'=>'uploads/language',
                            'file_name'=>$val['image']
                        );
                        AllFunction::delete_file($delArr);
                    }
                }                
                //======            
                Language::whereIn('language_id', $id_array)->delete();
                return redirect( route('language.index') )->with('message','Selected item deleted successfully');
            }  
        }

        //==== Add new data =====        
        $rules = [
            'name'     => 'required',
            'code'     => 'required|unique:language', 
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
                    'destination_path'=>'uploads/language',                    
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
                Language::whereIn('default', [0,1])->update(array('default' => '0'));
                $status = 1;
            }            

            // store
            $table = new Language;
            $table->name            = $request['name'];            
            $table->code            = $request['code'];
            $table->image           = $image ?? '';  
            $table->default         = $request['default'] ?? 0;                   
            $table->status          = $status; 
            $table->sort_order      = $request['sort_order'] ?? 0;                 
            $table->save();
            // redirect
            return redirect( route('language.index') )->with('message','Language created successfully');
        }        
    }
    
    public function show(string $id)
    {
        //=== check permision
        if(!has_permision(['language'])){ return redirect( route('dashboard') ); }

        $data = Language::find($id); 
        if(!$data){
            return redirect( route('language.index') );
        }
        $data = $data->toArray();

        $meta = [
            'title'=>'View Language',
            'keywords'=>'',
            'description'=>'',
        ];  
        
        $data = compact('meta','data'); 
        return view('admin.language.show')->with($data);
    }
    
    public function edit(string $id)
    {
        //=== check permision
        if(!has_permision(['language'=>'RW'])){ return redirect( route('dashboard') ); }

        $data = Language::find($id); 
        if(!$data){
            return redirect( route('language.index') );
        }
        $data = $data->toArray();

        $meta = [
            'title'=>'Edit Language',
            'keywords'=>'',
            'description'=>'',
        ];  
        $width  = $this->width; 
        $height = $this->height;   
        $data = compact('meta','data','id','width','height');         
        return view('admin.language.edit')->with($data);
    }
    
    public function update(Request $request, string $id)
    {
        
        //=== check permision
        if(!has_permision(['language'=>'RW'])){ return redirect( route('dashboard') ); }
       
        $rules = [
            'name'     => 'required',            
            'code'     => 'required|unique:language,code,'.$id.',language_id', 
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
                    'destination_path'=>'uploads/language',                    
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
                Language::whereIn('default', [0,1])->update(array('default' => '0'));
                $status = 1;
            }  
            
            $table = Language::find($id);
            $table->name            = $request['name'];            
            $table->code            = $request['code'];
            $table->image           = $image ?? '';  
            $table->default         = $request['default'] ?? 0;                   
            $table->status          = $status; 
            $table->sort_order      = $request['sort_order'] ?? 0;         
            $table->save();           
            return redirect( route('language.index') )->with('message','Language updated successfully');
        }
    }
   
    public function destroy(string $id)
    {
        //=== check permision
        if(!has_permision(['language'=>'RW'])){ return redirect( route('dashboard') ); }

        $table = Language::find($id);
        $table->delete();

        return json_encode(array(
            'status'=>'success',
            'url'=>route('language.index')
        ));
        exit;
    }
}
