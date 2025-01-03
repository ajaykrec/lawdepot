<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Traits\AllFunction;
use App\Models\Banners_category;
use DB;

class BannerCategoryController extends Controller
{
    use AllFunction; 
    
    public function index(Request $request)
    {
        //=== check permision
        if(!has_permision(['banners'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Banners Category',
            'keywords'=>'',
            'description'=>'',
        ];    
        
        $filterArr               = [];
        $filterArr['name']       = $request['name'] ?? '';       
        $filterArr['status']     = $request['status'] ?? '';    

        //=== pagi_url
        $pagi_url = route('banner-category.index').'?';
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

        $q = Banners_category::query(); 
        $q->with('banners');        
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'name'){
                        $q->where('name','like','%'.$val.'%');
                    }                   
                    if($key == 'status'){
                        $q->where('status',$val);
                    }
                }
            }
        }            
        $q->orderBy("banners_categories.name", "asc"); 
        $count = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 
        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);

       //p($results);

        $data = compact('meta','results','count','start_count','paginate'); 
        $data = array_merge($data,$filterArr);        
       
        return view('admin.banner_category.index')->with($data);
    }
    
    public function create()
    {
        //=== check permision
        if(!has_permision(['banners'=>'RW'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Add Banner Category',
            'keywords'=>'',
            'description'=>'',
        ];          
        $data = compact('meta'); 
        return view('admin.banner_category.create')->with($data);
    }

    public function store(Request $request)
    {
        //=== check permision
        if(!has_permision(['banners'=>'RW'])){ return redirect( route('dashboard') ); }


        //==== apply_action =====
        $apply_action = $request['apply_action'] ?? '';
        if($apply_action){
            $id_array = $request['id'] ?? [];

            if( $apply_action == 'active' && $id_array){               
                Banners_category::whereIn('bannercat_id', $id_array)->update(array('status' => '1'));
                return redirect( route('banner-category.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'in_active' && $id_array){               
                Banners_category::whereIn('bannercat_id', $id_array)->update(array('status' => '0'));
                return redirect( route('banner-category.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'delete' && $id_array){               
                Banners_category::whereIn('bannercat_id', $id_array)->delete();
                return redirect( route('banner-category.index') )->with('message','Selected item deleted successfully');
            }  
        }

        //==== Add new data =====   
        $rules = [
            'name'      => 'required',
            'width'     => 'required', 
            'height'    => 'required', 
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
            // store
            $table = new Banners_category;
            $table->name                = $request['name'];            
            $table->width               = $request['width'];
            $table->height              = $request['height'];                   
            $table->status              = $request['status'] ?? 0;
            $table->save();
            // redirect
            return redirect( route('banner-category.index') )->with('message','Banner Category created successfully');
        }        
    }
    
    public function show(string $id)
    {
        //=== check permision
        if(!has_permision(['banners'])){ return redirect( route('dashboard') ); }

        $data = Banners_category::find($id); 
        if(!$data){
            return redirect( route('banner-category.index') );
        }
        $data = $data->toArray();

        $meta = [
            'title'=>'View Banner Category',
            'keywords'=>'',
            'description'=>'',
        ];  
        
        $data = compact('meta','data'); 
        return view('admin.banner_category.show')->with($data);
    }
    
    public function edit(string $id)
    {
        //=== check permision
        if(!has_permision(['banners'=>'RW'])){ return redirect( route('dashboard') ); }        
        
        $data = Banners_category::find($id); 
        
        if(!$data){
            return redirect( route('banner-category.index') );
        }
        $data = $data->toArray();

        $meta = [
            'title'=>'Edit Banner Category',
            'keywords'=>'',
            'description'=>'',
        ];  
        
        $data = compact('meta','data','id');         
        return view('admin.banner_category.edit')->with($data);
    }
    
    public function update(Request $request, string $id)
    {
        //=== check permision
        if(!has_permision(['banners'=>'RW'])){ return redirect( route('dashboard') ); }

        $rules = [
            'name'      => 'required',
            'width'     => 'required', 
            'height'    => 'required', 
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
            $table = Banners_category::find($id);
            $table->name                = $request['name'];            
            $table->width               = $request['width'];
            $table->height              = $request['height'];                   
            $table->status              = $request['status'] ?? 0;
            $table->save();           
            return redirect( route('banner-category.index') )->with('message','Banner Category updated successfully');
        }
    }
   
    public function destroy(string $id)
    {
        //=== check permision
        if(!has_permision(['banners'=>'RW'])){ return redirect( route('dashboard') ); }

        $table = Banners_category::find($id);
        $table->delete();

        return json_encode(array(
            'status'=>'success',
            'url'=>route('banner-category.index')
        ));
        exit;
    }
}
