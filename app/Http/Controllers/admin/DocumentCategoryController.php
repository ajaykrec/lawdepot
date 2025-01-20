<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Traits\AllFunction;
use App\Models\Document_category;

class DocumentCategoryController extends Controller
{
    use AllFunction; 

    public function __construct(){
        $this->width  = 450;
        $this->height = 450;

        $this->width2  = 1920;
        $this->height2 = 650; 
    }
    
    public function index(Request $request)
    {
        //=== check permision
        if(!has_permision(['document'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Document category',
            'keywords'=>'',
            'description'=>'',
        ];    
        
        $filterArr               = [];
        $filterArr['country_id'] = $request['country_id'] ?? AllFunction::default_country_id();
        $filterArr['name']       = $request['name'] ?? '';
        $filterArr['slug']       = $request['slug'] ?? '';
        $filterArr['status']     = $request['status'] ?? '';   

        //=== pagi_url
        $pagi_url = route('document-category.index').'?';
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

        $q = Document_category::query();
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'country_id'){
                        $q->where('country_id',$val);
                    }
                    if($key == 'name'){
                        $q->where('name','like','%'.$val.'%');
                    }
                    if($key == 'slug'){
                        $q->where('slug','like','%'.$val.'%');
                    }
                    if($key == 'status'){
                        $q->where('status',$val);
                    }
                }
            }
        }    
        $q->with('country');        
        $q->orderBy("sort_order", "asc"); 
        $count = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 
        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);    

        $countries = AllFunction::get_countries();  

        $data = compact('meta','results','count','start_count','paginate','countries');        
        $data = array_merge($data,$filterArr);    
        
       
        return view('admin.document_category.index')->with($data);
    }
    
    public function create()
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Add document category',
            'keywords'=>'',
            'description'=>'',
        ];    
        $width  = $this->width; 
        $height = $this->height;    
        
        $width2  = $this->width2; 
        $height2 = $this->height2;   

        $countries = AllFunction::get_countries();  

        $data = compact('meta','width','height','width2','height2','countries'); 
        return view('admin.document_category.create')->with($data);
    }

    public function store(Request $request)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }

        //==== apply_action =====
        $apply_action = $request['apply_action'] ?? '';
        if($apply_action){
            $id_array = $request['id'] ?? [];

            if( $apply_action == 'active' && $id_array){      
                Document_category::whereIn('category_id', $id_array)->update(array('status' => '1'));
                return redirect( route('document-category.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'in_active' && $id_array){                
                Document_category::whereIn('category_id', $id_array)->update(array('status' => '0'));
                return redirect( route('document-category.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'delete' && $id_array){
                //== unlink file
                $result = Document_category::query()->whereIn('category_id', $id_array)->get()->toArray();
                if($result){
                    foreach($result as $val){

                        $delArr = array(
                            'file_path'=>'uploads/document-category',
                            'file_name'=>$val['image']
                        );
                        AllFunction::delete_file($delArr);

                        $delArr = array(
                            'file_path'=>'uploads/document-category',
                            'file_name'=>$val['banner_image']
                        );
                        AllFunction::delete_file($delArr);
                    }
                }                
                //======
                Document_category::whereIn('category_id', $id_array)->delete();
                return redirect( route('document-category.index') )->with('message','Selected item deleted successfully');
            }  
        }

        //==== Add new data =====        
        $rules = [
            'country_id' => 'required',
            'name'      => 'required',
            'slug'      => 'required', 
            'status'    => 'required'
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

            //=== upload image ===
            $file = $request->file('image');
            if($file){
                $array = [
                    'file'=>$file,
                    'destination_path'=>'uploads/document-category',                    
                    'width'=>$this->width,
                    'height'=>$this->height,                  
                ];
                $image = AllFunction::upload_image($array);
            }
            else{
                $image = $request['image'] ?? '';
            }

            //=== upload banner_image ===
            $file = $request->file('banner_image');
            if($file){
                $array = [
                    'file'=>$file,
                    'destination_path'=>'uploads/document-category',                    
                    'width'=>$this->width2,
                    'height'=>$this->height2,                  
                ];
                $banner_image = AllFunction::upload_image($array);
            }
            else{
                $banner_image = $request['banner_image'] ?? '';
            }

            // store
            $table = new Document_category;
            $table->country_id           = $request['country_id'] ?? 0;
            $table->parent_id           = $request['parent_id'] ?? 0;
            $table->name                = $request['name'];            
            $table->slug                = $request['slug'];
            $table->image               = $image;
            $table->banner_image        = $banner_image;
            $table->banner_text         = $request['banner_text'] ?? '';
            $table->content             = $request['content'] ?? '';
            $table->sort_order          = $request['sort_order'] ?? 0;
            $table->meta_title          = $request['meta_title'] ?? '';
            $table->meta_keyword        = $request['meta_keyword'] ?? '';
            $table->meta_description    = $request['meta_description'] ?? '';          
            $table->status              = $request['status'] ?? 0;
            $table->save();
            // redirect
            return redirect( route('document-category.index') )->with('message','Document category created successfully');
        }        
    }
    
    public function show(string $id)
    {
       //=====
    }
    
    public function edit(string $id)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }

        $data = Document_category::find($id); 
        if(!$data){
            return redirect( route('document-category.index') );
        }
        $data = $data->toArray();

        $meta = [
            'title'=>'Edit document category',
            'keywords'=>'',
            'description'=>'',
        ];
        
        $width  = $this->width; 
        $height = $this->height; 

        $width2  = $this->width2; 
        $height2 = $this->height2;   

        $countries = AllFunction::get_countries();  
        
        $data = compact('meta','data','id','width','height','width2','height2','countries');         
        return view('admin.document_category.edit')->with($data);
    }
    
    public function update(Request $request, string $id)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }

        $rules = [
            'country_id' => 'required',
            'name'      => 'required',
            'slug'      => 'required', 
            'status'    => 'required'
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

            //=== upload image ===
            $file = $request->file('image');
            if($file){
                $array = [
                    'file'=>$file,
                    'destination_path'=>'uploads/document-category',                    
                    'width'=>$this->width,
                    'height'=>$this->height,                  
                ];
                $image = AllFunction::upload_image($array);
            }
            else{
                $image = $request['image'] ?? '';
            }

            //=== upload banner_image ===
            $file = $request->file('banner_image');
            if($file){
                $array = [
                    'file'=>$file,
                    'destination_path'=>'uploads/document-category',                    
                    'width'=>$this->width2,
                    'height'=>$this->height2,                  
                ];
                $banner_image = AllFunction::upload_image($array);
            }
            else{
                $banner_image = $request['banner_image'] ?? '';
            }

            $table = Document_category::find($id);
            $table->country_id          = $request['country_id'] ?? 0;
            $table->parent_id           = $request['parent_id'] ?? 0;
            $table->name                = $request['name'];
            $table->slug                = $request['slug'];
            $table->image               = $image;
            $table->banner_image        = $banner_image;
            $table->banner_text         = $request['banner_text'] ?? '';
            $table->content             = $request['content'] ?? '';
            $table->sort_order          = $request['sort_order'] ?? 0;
            $table->meta_title          = $request['meta_title'] ?? '';
            $table->meta_keyword        = $request['meta_keyword'] ?? '';
            $table->meta_description    = $request['meta_description'] ?? '';          
            $table->status              = $request['status'] ?? 0;
            $table->save();           
            return redirect( route('document-category.index') )->with('message','Document category updated successfully');
        }
    }
   
    public function destroy(string $id)
    {
        //=== check permision
        if(!has_permision(['document-category'=>'RW'])){ return redirect( route('dashboard') ); }

        $table = Document_category::find($id); 
        $tableData = $table->toArray();

        //== unlink file        
        $delArr = array(
            'file_path'=>'uploads/document-category',
            'file_name'=>$tableData['image']
        );
        AllFunction::delete_file($delArr);
        
        $delArr = array(
            'file_path'=>'uploads/document-category',
            'file_name'=>$tableData['banner_image']
        );
        AllFunction::delete_file($delArr);        
        //======
        $table->delete();

        return json_encode(array(
            'status'=>'success',
            'url'=>route('document-category.index')
        ));
        exit;
    }
}
