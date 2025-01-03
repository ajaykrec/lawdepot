<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Traits\AllFunction;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    use AllFunction; 

    public function __construct(){
        $this->width  = 180;
        $this->height = 180;
    }
    
    public function index(Request $request)
    {
        //=== check permision
        if(!has_permision(['testimonial'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Testimonial',
            'keywords'=>'',
            'description'=>'',
        ];    
        
        $filterArr                      = [];
        $filterArr['name']              = $request['name'] ?? '';
        $filterArr['designation']       = $request['designation'] ?? '';
        $filterArr['status']            = $request['status'] ?? '';   

        //=== pagi_url
        $pagi_url = route('testimonial.index').'?';
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

        $q = Testimonial::query();
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'name'){
                        $q->where('name','like','%'.$val.'%');
                    }
                    if($key == 'designation'){
                        $q->where('designation','like','%'.$val.'%');
                    }
                    if($key == 'status'){
                        $q->where('status',$val);
                    }
                }
            }
        }            
        $q->orderBy("name", "asc"); 
        $count    = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 
        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);

        $data = compact('meta','results','count','start_count','paginate'); 
        $data = array_merge($data,$filterArr);        
       
        return view('admin.testimonial.index')->with($data);
    }
    
    public function create()
    {
        //=== check permision
        if(!has_permision(['testimonial'=>'RW'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Add Testimonial',
            'keywords'=>'',
            'description'=>'',
        ];    
        $width  = $this->width; 
        $height = $this->height;           
        $data = compact('meta','width','height'); 
        return view('admin.testimonial.create')->with($data);
    }

    public function store(Request $request)
    {
        //=== check permision
        if(!has_permision(['testimonial'=>'RW'])){ return redirect( route('dashboard') ); }

        //==== apply_action =====
        $apply_action = $request['apply_action'] ?? '';
        if($apply_action){
            $id_array = $request['id'] ?? [];

            if( $apply_action == 'active' && $id_array){
                Testimonial::whereIn('testimonial_id', $id_array)->update(array('status' => '1'));
                return redirect( route('testimonial.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'in_active' && $id_array){                
                Testimonial::whereIn('testimonial_id', $id_array)->update(array('status' => '0'));
                return redirect( route('testimonial.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'delete' && $id_array){                
                //== unlink file
                $result = Testimonial::query()->whereIn('testimonial_id', $id_array)->get()->toArray();
                if($result){
                    foreach($result as $val){
                        $delArr = array(
                            'file_path'=>'uploads/testimonial',
                            'file_name'=>$val['profile_image']
                        );
                        AllFunction::delete_file($delArr);
                    }
                }                
                //======
                Testimonial::whereIn('testimonial_id', $id_array)->delete();
                return redirect( route('testimonial.index') )->with('message','Selected item deleted successfully');
            }  
        }

        //==== Add new data =====        
        $rules = [
            'name'          => 'required',
            'designation'   => 'required', 
            'description'   => 'required', 
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

            //=== upload file
            $file = $request->file('profile_image');
            if($file){
                $array = [
                    'file'=>$file,
                    'destination_path'=>'uploads/testimonial',                    
                    'width'=>$this->width,
                    'height'=>$this->height,                  
                ];
                $profile_image = AllFunction::upload_image($array);
            }
            else{
                $profile_image = $request['profile_image'] ?? '';
            }

            // store
            $table = new Testimonial;
            $table->name                = $request['name'];
            $table->designation         = $request['designation'] ?? '';
            $table->profile_image       = $profile_image;
            $table->description         = $request['description'];
            $table->sort_order          = $request['sort_order'] ?? 0;
            $table->status              = $request['status'];
            $table->save();
            // redirect
            return redirect( route('testimonial.index') )->with('message','Testimonial created successfully');
        }        
    }
    
    public function show(string $id)
    {
        //=== check permision
        if(!has_permision(['testimonial'])){ return redirect( route('dashboard') ); }

        $data = Testimonial::find($id); 
        if(!$data){
            return redirect( route('testimonial.index') );
        }
        $data = $data->toArray();

        $meta = [
            'title'=>'View Testimonial',
            'keywords'=>'',
            'description'=>'',
        ];  
        
        $data = compact('meta','data'); 
        return view('admin.testimonial.show')->with($data);
    }
    
    public function edit(string $id)
    {
        //=== check permision
        if(!has_permision(['testimonial'=>'RW'])){ return redirect( route('dashboard') ); }

        $data = Testimonial::find($id); 
        if(!$data){
            return redirect( route('testimonial.index') );
        }
        $data = $data->toArray();

        $meta = [
            'title'=>'Edit Testimonial',
            'keywords'=>'',
            'description'=>'',
        ];
        
        $width  = $this->width; 
        $height = $this->height; 
        
        $data = compact('meta','data','id','width','height');         
        return view('admin.testimonial.edit')->with($data);
    }
    
    public function update(Request $request, string $id)
    {
        //=== check permision
        if(!has_permision(['testimonial'=>'RW'])){ return redirect( route('dashboard') ); }

        $rules = [
            'name'          => 'required',
            'designation'   => 'required', 
            'description'   => 'required', 
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

            //=== upload file
            $file = $request->file('profile_image');
            if($file){
                $array = [
                    'file'=>$file,
                    'destination_path'=>'uploads/testimonial',                    
                    'width'=>$this->width,
                    'height'=>$this->height,                  
                ];
                $profile_image = AllFunction::upload_image($array);
            }
            else{
                $profile_image = $request['profile_image'] ?? '';
            }

            $table = Testimonial::find($id);
            $table->name                = $request['name'];
            $table->designation         = $request['designation'] ?? '';
            $table->profile_image       = $profile_image;
            $table->description         = $request['description'];
            $table->sort_order          = $request['sort_order'] ?? '';
            $table->status              = $request['status'];
            $table->save();           
            return redirect( route('testimonial.index') )->with('message','Testimonial updated successfully');
        }
    }
   
    public function destroy(string $id)
    {
        //=== check permision
        if(!has_permision(['testimonial'=>'RW'])){ return redirect( route('dashboard') ); }

        $table = Testimonial::find($id); 

        //== unlink file
        $tableData = $table->toArray();
        $delArr    = array(
            'file_path'=>'uploads/testimonial',
            'file_name'=>$tableData['profile_image']
        );
        AllFunction::delete_file($delArr);
        //======

        $table->delete();

        return json_encode(array(
            'status'=>'success',
            'url'=>route('testimonial.index')
        ));
        exit;
    }
}
