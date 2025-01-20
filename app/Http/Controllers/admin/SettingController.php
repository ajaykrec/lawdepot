<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Traits\AllFunction;
use App\Models\Settings;
use Artisan;
class SettingController extends Controller
{
    use AllFunction; 
   
    public function index(Request $request)
    {
        //=== check permision
        if(!has_permision(['settings'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Settings',
            'keywords'=>'',
            'description'=>'',
        ];    
        
        $filterArr               = [];
        $filterArr['title']      = $request['title'] ?? '';
        $filterArr['key']        = $request['key'] ?? '';   
        $filterArr['value']      = $request['value'] ?? ''; 

        //=== pagi_url
        $pagi_url = route('settings.index').'?';
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

        $q = Settings::query();
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'title'){
                        $q->where('title','like','%'.$val.'%');
                    }
                    if($key == 'key'){
                        $q->where('key',$val);
                    }
                    if($key == 'value'){
                        $q->where('value','like','%'.$val.'%');
                    }
                }
            }
        }            
        $q->orderBy("sort_order", "asc"); 
        $count = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 
        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);

        $data = compact('meta','results','count','start_count','paginate'); 
        $data = array_merge($data,$filterArr);        
       
        return view('admin.settings.index')->with($data);
    }
   
    public function create()
    {
        //
    }
    
    public function store(Request $request)
    {
        //
    }
    
    public function show($id)
    {
        //
    }
    
    public function edit($id)
    {
        //=== check permision
        if(!has_permision(['settings'=>'RW'])){ return redirect( route('dashboard') ); }

        $data = Settings::find($id); 
        if(!$data){
            return redirect( route('settings.index') );
        }
        $data = $data->toArray();

        $meta = [
            'title'=>'Edit Settings',
            'keywords'=>'',
            'description'=>'',
        ];  
        
        $data = compact('meta','data','id');         
        return view('admin.settings.edit')->with($data);
    }
    
    public function update(Request $request, $id)
    {
        //=== check permision
        if(!has_permision(['settings'=>'RW'])){ return redirect( route('dashboard') ); }

        $rules = [
            //'value' => 'required',            
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

            $data = Settings::find($id)->toArray();
            $field_type = isset($data['field_type']) ? $data['field_type'] : '';
            $key = isset($data['key']) ? $data['key'] : '';
                
            if($field_type == 'Image'){
                //=== upload file
                $file = $request->file('value');
                if($file){
                    $array = [
                        'file'=>$file,
                        'destination_path'=>'uploads/settings', 
                    ];
                    $value = AllFunction::upload_image($array);
                }
                else{
                    $value = $request['value'] ?? '';
                }
            }
            else if($field_type == 'File'){
                //=== upload file
                $file = $request->file('value');
                if($file){
                    $array = [
                        'file'=>$file,
                        'destination_path'=>'uploads/settings', 
                    ];
                    $value = AllFunction::upload_file($array);
                }
                else{
                    $value = $request['value'] ?? '';
                }
            }
            else{
                $value = $request['value'] ?? '';
            }

            //==== maintenance commant ====
            if( $key=='under_construction' && $value==1){
                Artisan::call('down');
            }
            elseif( $key=='under_construction' && $value==0){
                Artisan::call('up');
            }
            //=============================
            
            $table = Settings::find($id);
            $table->value = $value;          
            $table->save();           
            return redirect( route('settings.index') )->with('message','Setting updated successfully');
        }
    }
    
    public function destroy($id)
    {
        //
    }
}
