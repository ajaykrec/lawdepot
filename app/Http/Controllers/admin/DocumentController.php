<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Traits\AllFunction;
use App\Models\Document;
use App\Models\Document_category;

class DocumentController extends Controller
{
    use AllFunction; 

    public function __construct(){
        $this->width  = 450;
        $this->height = 450;
    }
    
    public function index(Request $request)
    {
        //=== check permision
        if(!has_permision(['document'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Document',
            'keywords'=>'',
            'description'=>'',
        ];    
        
        $filterArr                  = [];
        $filterArr['country_id']    = $request['country_id'] ?? AllFunction::default_country_id();
        $filterArr['category_id']   = $request['category_id'] ?? '';
        $filterArr['name']          = $request['name'] ?? '';
        $filterArr['slug']          = $request['slug'] ?? '';
        $filterArr['status']        = $request['status'] ?? '';   

        //=== pagi_url
        $pagi_url = route('document.index').'?';
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

        $q = Document::query();
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'country_id'){
                        $q->where('country_id',$val);
                    }
                    if($key == 'category_id'){
                        $q->where('category_id',$val);
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
        $q->with(['country','category','steps']);         
        $q->orderBy("sort_order", "asc"); 
        $count    = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 
        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);

        $countries = AllFunction::get_countries();  
        $categories = DocumentController::get_categories($filterArr['country_id']);          

        $data = compact('meta','results','count','start_count','paginate','countries','categories'); 
        $data = array_merge($data,$filterArr);        
       
        return view('admin.document.index')->with($data);
    }
    
    public function create()
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Add Document',
            'keywords'=>'',
            'description'=>'',
        ];    
        $width  = $this->width; 
        $height = $this->height;  

        $countries = AllFunction::get_countries(); 
        $categories = DocumentController::get_categories(old('country_id'));         
        $data = compact('meta','width','height','countries','categories'); 
        return view('admin.document.create')->with($data);
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
                Document::whereIn('document_id', $id_array)->update(array('status' => '1'));
                return redirect( route('document.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'in_active' && $id_array){
                Document::whereIn('document_id', $id_array)->update(array('status' => '0'));
                return redirect( route('document.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'delete' && $id_array){
                //== unlink file
                $result = Document::query()->whereIn('document_id', $id_array)->get()->toArray();
                if($result){
                    foreach($result as $val){

                        $delArr = array(
                            'file_path'=>'uploads/document',
                            'file_name'=>$val['image']
                        );
                        AllFunction::delete_file($delArr);
                    }
                }                
                //======
                Document::whereIn('document_id', $id_array)->delete();
                return redirect( route('document.index') )->with('message','Selected item deleted successfully');
            }  
        }

        //==== Add new data =====        
        $rules = [
            'country_id'        => 'required',
            'category_id'       => 'required',  
            'name'              => 'required',
            'slug'              => 'required',  
            'short_description' => 'required',
            'template'          => 'required',  
            'image'             => 'mimes:png,jpeg,gif,webp,svg|image|max:2048', // size : 1024*2 = 2048 = 2MB 
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
                    'destination_path'=>'uploads/document',                    
                    'width'=>$this->width,
                    'height'=>$this->height,                  
                ];
                $image = AllFunction::upload_image($array);
            }
            else{
                $image = $request['image'] ?? '';
            }            
            //======
            
            $table = new Document;            
            $table->country_id          = $request['country_id'] ?? 0;
            $table->category_id         = $request['category_id'] ?? 0;
            $table->name                = $request['name'];
            $table->slug                = $request['slug'] ?? '';
            $table->short_description   = $request['short_description'] ?? '';
            $table->description         = $request['description'] ?? '';
            $table->template            = $request['template'] ?? '';            
            $table->image               = $image;           
            $table->sort_order          = $request['sort_order'] ?? 0;
            $table->status              = $request['status'] ?? 0;
            $table->meta_title          = $request['meta_title'];
            $table->meta_keyword        = $request['meta_keyword'];
            $table->meta_description    = $request['meta_description'];
            $table->save();
            // redirect
            return redirect( route('document.index') )->with('message','Document created successfully');
        }        
    }
    
    public function show(string $id){
        
    }
    
    public function edit(Request $request,string $id)
    {        
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }

        $data = Document::find($id); 
        if(!$data){
            return redirect( route('document.index') );
        }
        $data = $data->toArray();

        $meta = [
            'title'=>'Edit Document',
            'keywords'=>'',
            'description'=>'',
        ];
        
        $width  = $this->width; 
        $height = $this->height; 

        $countries = AllFunction::get_countries(); 
        $categories = DocumentController::get_categories(old('country_id') ?? $data['country_id'] ?? '');         
        
        $data = compact('meta','data','id','width','height','countries','categories');         
        return view('admin.document.edit')->with($data);
    }
    
    public function update(Request $request, string $id)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }

        $rules = [
            'country_id'        => 'required',
            'category_id'       => 'required',  
            'name'              => 'required',
            'slug'              => 'required',  
            'short_description' => 'required',
            'template'          => 'required', 
        ];
        if($request->file('image')){
            $rules['image'] = 'mimes:png,jpeg,gif,webp,svg|image|max:2048'; // size : 1024*2 = 2048 = 2MB 
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
                     'destination_path'=>'uploads/document',                    
                     'width'=>$this->width,
                     'height'=>$this->height,                  
                 ];
                 $image = AllFunction::upload_image($array);
             }
             else{
                 $image = $request['image'] ?? '';
             }             
            //======

            $table = Document::find($id);
            $table->country_id          = $request['country_id'] ?? 0;
            $table->category_id         = $request['category_id'] ?? 0;
            $table->name                = $request['name'];
            $table->slug                = $request['slug'] ?? '';
            $table->short_description   = $request['short_description'] ?? '';
            $table->description         = $request['description'] ?? '';
            $table->template            = $request['template'] ?? '';            
            $table->image               = $image;           
            $table->sort_order          = $request['sort_order'] ?? 0;
            $table->status              = $request['status'] ?? 0;
            $table->meta_title          = $request['meta_title'];
            $table->meta_keyword        = $request['meta_keyword'];
            $table->meta_description    = $request['meta_description'];
            $table->save();           
            return redirect( route('document.index') )->with('message','Document updated successfully');
        }
    }
   
    public function destroy(string $id)
    {
        //=== check permision
        if(!has_permision(['document'=>'RW'])){ return redirect( route('dashboard') ); }

        $table = Document::find($id); 
        $tableData = $table->toArray();

        //== unlink file        
        $delArr = array(
            'file_path'=>'uploads/document',
            'file_name'=>$tableData['image']
        );
        AllFunction::delete_file($delArr);
        //======

        $table->delete();

        return json_encode(array(
            'status'=>'success',
            'url'=>route('document.index')
        ));
        exit;
    }

    public function get_categories($country_id='')
    {
        $categories = [];
        if($country_id){
            $categories = Document_category::query()->where('country_id',$country_id)->orderBy("name","asc")->get()->toArray();
        }        
        return $categories;
    }
}
