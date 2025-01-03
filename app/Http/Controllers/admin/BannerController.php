<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Traits\AllFunction;
use App\Models\Banners;
use App\Models\Banners_category;
use App\Models\Banners_language;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    use AllFunction; 

    public function index($bannercat_id, Request $request){

       //=== check permision
       if(!has_permision(['banners'])){ return redirect( route('dashboard') ); }
       $bcategory = Banners_category::find($bannercat_id); 
       if(!$bcategory){
           return redirect( route('banner-category.index') ); 
       }
       $bcategory = $bcategory->toArray();

       $meta = [
           'title'=>$bcategory['name'] ?? '',
           'keywords'=>'',
           'description'=>'',
       ];    
       
       $filterArr                  = [];
       $filterArr['bannercat_id']  = $bannercat_id ?? '';     
       $filterArr['url']           = $request['url'] ?? '';       
       $filterArr['status']        = $request['status'] ?? '';    
       $language_id = AllFunction::default_language_id();
       //=== pagi_url
       $pagi_url = route('banner-category.banners.index',$bannercat_id).'?';
       if($filterArr){
           $count = 0;
           foreach($filterArr as $key=>$val){
               if($val!='' && $key!='bannercat_id'){
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

       $q = DB::table('banners');  
       $q = $q->leftJoin('banners_language','banners_language.banner_id','=','banners.banner_id');  
       $q = $q->leftJoin('banners_categories','banners_categories.bannercat_id','=','banners.bannercat_id');  
       $q = $q->where('banners_language.language_id',$language_id);   
       $q = $q->where('banners.bannercat_id',$bannercat_id); 

       if($filterArr){
           foreach($filterArr as $key=>$val){
               if($val!=''){
                   if($key == 'bannercat_id'){
                       $q->where('banners.bannercat_id',$val);
                   }   
                   if($key == 'url'){
                       $q->where('banners_language.url','like','%'.$val.'%');
                   }                   
                   if($key == 'status'){
                       $q->where('banners.status',$val);
                   }
               }
           }
       }            
       $q->orderBy("banners.sort_order", "asc"); 
       $count    = $q->count();     
       $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 
       $results = json_decode(json_encode($results), true); 
       
       $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);      

       $data = compact('meta','results','count','start_count','paginate','bannercat_id'); 
       $data = array_merge($data,$filterArr);  
      
       return view('admin.banner.index')->with($data);
    }
    
    public function create($bannercat_id){
       //=== check permision
       if(!has_permision(['banners'=>'RW'])){ return redirect( route('dashboard') ); }

       $bcategory = Banners_category::find($bannercat_id); 
       if(!$bcategory){
           return redirect( route('banner-category.index') );
       }
       $bcategory = $bcategory->toArray();

       $meta = [
           'title'=>'Add Banner',
           'keywords'=>'',
           'description'=>'',
       ];      
       $languages = AllFunction::get_languages();            
       $data = compact('meta','bannercat_id','bcategory','languages'); 
       return view('admin.banner.create')->with($data);
    }
    
    public function store($bannercat_id, Request $request){     
        
        //=== check permision
        if(!has_permision(['banners'=>'RW'])){ return redirect( route('dashboard') ); }

        //==== apply_action =====
        $apply_action = $request['apply_action'] ?? '';
        if($apply_action){
            $id_array = $request['id'] ?? [];

            if( $apply_action == 'active' && $id_array){               
                Banners::whereIn('banner_id', $id_array)->update(array('status' => '1'));
                return redirect( route('banner-category.banners.index',$bannercat_id) )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'in_active' && $id_array){                
                Banners::whereIn('banner_id', $id_array)->update(array('status' => '0'));
                return redirect( route('banner-category.banners.index',$bannercat_id) )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'delete' && $id_array){               
                //== unlink file
                $result = Banners::query()->whereIn('banner_id', $id_array)->get()->toArray();
                if($result){
                    foreach($result as $val){
                        $delArr = array(
                            'file_path'=>'uploads/banners',
                            'file_name'=>$val['banner_image']
                        );
                        AllFunction::delete_file($delArr);
                    }
                }                
                //======
                Banners::whereIn('banner_id', $id_array)->delete();
                Banners_language::whereIn('banner_id', $id_array)->delete();
                return redirect( route('banner-category.banners.index',$bannercat_id) )->with('message','Selected item deleted successfully');
            }  
        }

        //==== Add new data =====       
        $languages = AllFunction::get_languages();  
        $bcategory = Banners_category::find($bannercat_id); 
        if(!$bcategory){
            return redirect( route('banner-category.index') );
        }
        $bcategory = $bcategory->toArray();        

        $rules = [
            'banner_image' => 'required|mimes:png,jpeg,gif,webp|image|max:2048', // size : 1024*2 = 2048 = 2MB
            'status' => 'required',             
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
            $file = $request->file('banner_image');
            if($file){
                $array = [
                    'file'=>$file,
                    'destination_path'=>'uploads/banners',                    
                    'width'=>$bcategory['width'] ?? '',
                    'height'=>$bcategory['height'] ?? '',                  
                ];
                $banner_image = AllFunction::upload_image($array);
            }
            else{
                $banner_image = $request['banner_image'] ?? '';
            }

            //== store
            $table = new Banners;
            $table->bannercat_id      = $bannercat_id;  
            $table->banner_image      = $banner_image;  
            $table->sort_order        = $request['sort_order'] ?? 0;                        
            $table->status            = $request['status'] ?? 0;
            $table->save();

            $banner_id = $table->banner_id;              
           
            Banners_language::where('banner_id', $banner_id)->delete();
            foreach($languages as $val){
                $language_id = $val['language_id'];
                $table = new Banners_language;
                $table->banner_id     = $banner_id;
                $table->language_id   = $language_id;
                $table->banner_text   = $request['banner_text'][$language_id] ?? '';
                $table->url           = $request['url'][$language_id] ?? '';                
                $table->save();
            }              

            // redirect
            return redirect( route('banner-category.banners.index',$bannercat_id) )->with('message','Banner created successfully');
        }        
    }
   
    public function show($banner_id){
        //====
    }
   
    public function edit(string $banner_id){
        
        //=== check permision
        if(!has_permision(['banners'=>'RW'])){ return redirect( route('dashboard') ); }  
       
        $data = Banners::query()
        ->with(['bannercat','banners_language'])
        ->where('banner_id',$banner_id)
        ->first()->toArray(); 

        if(!$data){
            return redirect( route('banner-category.index') ); 
        }  
                  
        $bannercat_id   = $data['bannercat_id'] ?? ''; 
        $bcategory      = $data['bannercat'] ?? '';
        $banners_language = $data['banners_language'] ?? [];

        $meta = [
            'title'=>'Edit Banner',
            'keywords'=>'',
            'description'=>'',
        ];  

        $languages = AllFunction::get_languages(); 
        $lang_data = [];
        foreach($banners_language as $val){
            $lang_data[$val['language_id']] = $val;
        }
        
        $data = compact('meta','data','lang_data','banner_id','bannercat_id','bcategory','languages');         
        return view('admin.banner.edit')->with($data);
    }
    
    public function update(Request $request, string $banner_id){
        //=== check permision
        if(!has_permision(['banners'=>'RW'])){ return redirect( route('dashboard') ); }
        
        $languages = AllFunction::get_languages(); 
        $banner_image = $request['banner_image'] ?? '';
        if(!$banner_image){
            $rules = [
                'banner_image' => 'required|mimes:png,jpeg,gif,webp|image|max:2048', // size : 1024*2 = 2048 = 2MB 
                'status'       => 'required',             
            ];
        }
        else{
            $rules = [                
                'status'       => 'required',             
            ];
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

            $banner_data = Banners::query()
            ->with('bannercat')
            ->where('banner_id',$banner_id)
            ->first()->toArray(); 
           
            $bannercat_id   = $banner_data['bannercat_id'] ?? '';
            $bcategory      = $banner_data['bannercat'] ?? '';
            $width          = $bcategory['width'] ?? '';
            $height         = $bcategory['height'] ?? '';

             //=== upload file
             $file = $request->file('banner_image');
             if($file){
                 $array = [
                     'file'=>$file,
                     'destination_path'=>'uploads/banners',                     
                     'width'=>$width ?? '',
                     'height'=>$height ?? '',                  
                 ];
                 $banner_image = AllFunction::upload_image($array);
             }
             else{
                 $banner_image = $request['banner_image'] ?? '';
             }

            
            $table = Banners::find($banner_id);
            $table->bannercat_id      = $bannercat_id;  
            $table->banner_image      = $banner_image;  
            $table->sort_order        = $request['sort_order'] ?? 0;                        
            $table->status            = $request['status'] ?? 0;
            $table->save();    
            
            Banners_language::where('banner_id', $banner_id)->delete();
            foreach($languages as $val){
                $language_id = $val['language_id'];
                $table = new Banners_language;
                $table->banner_id     = $banner_id;
                $table->language_id   = $language_id;
                $table->banner_text   = $request['banner_text'][$language_id] ?? '';
                $table->url           = $request['url'][$language_id] ?? '';                
                $table->save();
            } 

            return redirect( route('banner-category.banners.index',$bannercat_id) )->with('message','Banner updated successfully');
        }
    }
    
    public function destroy(string $banner_id){
       //=== check permision
       if(!has_permision(['banners'=>'RW'])){ return redirect( route('dashboard') ); }

       $table = Banners::find($banner_id);
       $tableData      = $table->toArray();
       $bannercat_id   = $tableData['bannercat_id'] ?? ''; 

       //== unlink file       
       $delArr = array(
           'file_path'=>'uploads/banners',
           'file_name'=>$tableData['banner_image']
       );
       AllFunction::delete_file($delArr);
       //======
       $table->delete();
       Banners_language::where('banner_id', $banner_id)->delete();

       return json_encode(array(
           'status'=>'success',
           'url'=>route('banner-category.banners.index',$bannercat_id)
       ));
       exit;
    }
}
