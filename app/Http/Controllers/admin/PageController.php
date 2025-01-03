<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Traits\AllFunction;
use App\Models\Pages;
use App\Models\Pages_language;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    use AllFunction; 

    public function __construct(){
        $this->width  = 1200;
        $this->height = 300;
    }
    
    public function index(Request $request)
    {
        //=== check permision
        if(!has_permision(['pages'])){ return redirect( route('dashboard') ); }       

        $meta = [
            'title'=>'Pages',
            'keywords'=>'',
            'description'=>'',
        ];    
        
        $filterArr               = [];
        $filterArr['name']       = $request['name'] ?? '';
        $filterArr['slug']       = $request['slug'] ?? '';
        $filterArr['status']     = $request['status'] ?? '';   
        $language_id = AllFunction::default_language_id();

        //=== pagi_url
        $pagi_url = route('pages.index').'?';
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
        
        $q = DB::table('pages');  
        $q = $q->leftJoin('pages_language','pages_language.page_id','=','pages.page_id');  
        $q = $q->where('pages_language.language_id',$language_id);         
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'name'){
                        $q->where('pages_language.name','like','%'.$val.'%');
                    }
                    if($key == 'slug'){
                        $q->where('pages.slug','like','%'.$val.'%');
                    }
                    if($key == 'status'){
                        $q->where('pages.status',$val);
                    }
                }
            }
        }            
        $q->orderBy("pages_language.name", "asc"); 
        $count = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 
        $results = json_decode(json_encode($results), true); 

        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);        

        $data = compact('meta','results','count','start_count','paginate');         
        $data = array_merge($data,$filterArr);        
       
        return view('admin.pages.index')->with($data);
    }
    
    public function create()
    {
        //=== check permision
        if(!has_permision(['pages'=>'RW'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Add Page',
            'keywords'=>'',
            'description'=>'',
        ];    
        $width  = $this->width; 
        $height = $this->height;  
        $languages = AllFunction::get_languages();        
        $data = compact('meta','width','height','languages'); 
        return view('admin.pages.create')->with($data);
    }

    public function store(Request $request)
    {
        //=== check permision
        if(!has_permision(['pages'=>'RW'])){ return redirect( route('dashboard') ); }

        //==== apply_action =====
        $apply_action = $request['apply_action'] ?? '';
        if($apply_action){
            $id_array = $request['id'] ?? [];

            if( $apply_action == 'active' && $id_array){      
                Pages::whereIn('page_id', $id_array)->update(array('status' => '1'));
                return redirect( route('pages.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'in_active' && $id_array){                
                Pages::whereIn('page_id', $id_array)->update(array('status' => '0'));
                return redirect( route('pages.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'delete' && $id_array){
                //== unlink file
                $result = Pages::query()->whereIn('page_id', $id_array)->get()->toArray();
                if($result){
                    foreach($result as $val){
                        $delArr = array(
                            'file_path'=>'uploads/pages',
                            'file_name'=>$val['banner_image']
                        );
                        AllFunction::delete_file($delArr);
                    }
                }                
                //======
                Pages::whereIn('page_id', $id_array)->delete();
                Pages_language::whereIn('page_id', $id_array)->delete();
                return redirect( route('pages.index') )->with('message','Selected item deleted successfully');
            }  
        }

        //==== Add new data =====       
        $languages = AllFunction::get_languages(); 
        $messages = [];
        $rules = [           
            'slug'      => 'required|unique:pages', 
            'status'    => 'required'
        ];
        foreach($languages as $val){
            $language_id = $val['language_id'];
            $name = $request['name'][$language_id] ?? '';
            if(!$name){
                $rules['name['.$language_id.']'] = 'required';
                $messages['name['.$language_id.'].required'] = 'Name is required';
            }            
        }        
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
            $file = $request->file('banner_image');
            if($file){
                $array = [
                    'file'=>$file,
                    'destination_path'=>'uploads/pages',                    
                    'width'=>$this->width,
                    'height'=>$this->height,                  
                ];
                $banner_image = AllFunction::upload_image($array);
            }
            else{
                $banner_image = $request['banner_image'] ?? '';
            }

            // store
            $table = new Pages;            
            $table->slug           = $request['slug'];
            $table->banner_image   = $banner_image;
            $table->status         = $request['status'];
            $table->save();

            $page_id = $table->page_id;              
           
            Pages_language::where('page_id', $page_id)->delete();
            foreach($languages as $val){
                $language_id = $val['language_id'];
                $table = new Pages_language;
                $table->page_id             = $page_id;
                $table->language_id         = $language_id;
                $table->name                = $request['name'][$language_id] ?? '';
                $table->content             = $request['content'][$language_id] ?? '';
                $table->meta_title          = $request['meta_title'][$language_id] ?? '';
                $table->meta_keyword        = $request['meta_keyword'][$language_id] ?? '';
                $table->meta_description    = $request['meta_description'][$language_id] ?? '';  
                $table->save();
            }              
            // redirect
            return redirect( route('pages.index') )->with('message','Page created successfully');
        }        
    }
    
    public function show(string $id)
    {
        //====
    }
    
    public function edit(string $id)
    {
        //=== check permision
        if(!has_permision(['pages'=>'RW'])){ return redirect( route('dashboard') ); }

        $data = Pages::where('page_id',$id); 
        if(!$data){
            return redirect( route('pages.index') );
        }
        $data = $data->with('pages_language')->first()->toArray();
        $pages_language = $data['pages_language'] ?? [];
        $meta = [
            'title'=>'Edit Page',
            'keywords'=>'',
            'description'=>'',
        ];        
        $width  = $this->width; 
        $height = $this->height; 
        $languages = AllFunction::get_languages(); 
        $lang_data = [];
        foreach($pages_language as $val){
            $lang_data[$val['language_id']] = $val;
        }
        
        $data = compact('meta','data','lang_data','id','width','height','languages');         
        return view('admin.pages.edit')->with($data);
    }
    
    public function update(Request $request, string $id)
    {
        //=== check permision
        if(!has_permision(['pages'=>'RW'])){ return redirect( route('dashboard') ); }

        $languages = AllFunction::get_languages(); 
        $messages = [];
        $rules = [           
            'slug'      => 'required|unique:pages,slug,'.$id.',page_id', 
            'status'    => 'required'
        ];
        foreach($languages as $val){
            $language_id = $val['language_id'];
            $name = $request['name'][$language_id] ?? '';
            if(!$name){
                $rules['name['.$language_id.']'] = 'required';
                $messages['name['.$language_id.'].required'] = 'Name is required';
            }            
        }        
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
            $file = $request->file('banner_image');
            if($file){
                $array = [
                    'file'=>$file,
                    'destination_path'=>'uploads/pages',                    
                    'width'=>$this->width,
                    'height'=>$this->height,                  
                ];
                $banner_image = AllFunction::upload_image($array);
            }
            else{
                $banner_image = $request['banner_image'] ?? '';
            }

            $table = Pages::find($id);
            $table->slug           = $request['slug'];
            $table->banner_image   = $banner_image;
            $table->status         = $request['status'];
            $table->save();  
            
            Pages_language::where('page_id', $id)->delete();
            foreach($languages as $val){
                $language_id = $val['language_id'];
                $table = new Pages_language;
                $table->page_id             = $id;
                $table->language_id         = $language_id;
                $table->name                = $request['name'][$language_id] ?? '';
                $table->content             = $request['content'][$language_id] ?? '';
                $table->meta_title          = $request['meta_title'][$language_id] ?? '';
                $table->meta_keyword        = $request['meta_keyword'][$language_id] ?? '';
                $table->meta_description    = $request['meta_description'][$language_id] ?? '';  
                $table->save();
            }  
            
            return redirect( route('pages.index') )->with('message','Page updated successfully');
        }
    }
   
    public function destroy(string $id)
    {
        //=== check permision
        if(!has_permision(['pages'=>'RW'])){ return redirect( route('dashboard') ); }

        $table = Pages::find($id); 

        //== unlink file
        $tableData = $table->toArray();
        $delArr    = array(
            'file_path'=>'uploads/pages',
            'file_name'=>$tableData['banner_image']
        );
        AllFunction::delete_file($delArr);
        //======
        $table->delete();
        Pages_language::where('page_id', $id)->delete();

        return json_encode(array(
            'status'=>'success',
            'url'=>route('pages.index')
        ));
        exit;
    }
}
