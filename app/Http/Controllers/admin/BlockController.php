<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Traits\AllFunction;
use App\Models\Blocks;
use App\Models\Blocks_language;
use Illuminate\Support\Facades\DB;

class BlockController extends Controller
{
    use AllFunction; 
    
    public function index(Request $request)
    {
        //=== check permision
        if(!has_permision(['blocks'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Blocks',
            'keywords'=>'',
            'description'=>'',
        ];    
        
        $filterArr               = [];
        $filterArr['title']      = $request['title'] ?? '';
        $filterArr['identity']   = $request['identity'] ?? '';
        $filterArr['status']     = $request['status'] ?? '';   
        $language_id = AllFunction::default_language_id();
        //=== pagi_url
        $pagi_url = route('blocks.index').'?';
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

        $q = DB::table('blocks');  
        $q = $q->leftJoin('blocks_language','blocks_language.block_id','=','blocks.block_id');  
        $q = $q->where('blocks_language.language_id',$language_id);         
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'title'){
                        $q->where('blocks_language.title','like','%'.$val.'%');
                    }
                    if($key == 'identity'){
                        $q->where('blocks.identity','like','%'.$val.'%');
                    }
                    if($key == 'status'){
                        $q->where('blocks.status',$val);
                    }
                }
            }
        }            
        $q->orderBy("blocks_language.title", "asc"); 
        $count = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 
        $results  = json_decode(json_encode($results), true); 
        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);

        $data = compact('meta','results','count','start_count','paginate'); 
        $data = array_merge($data,$filterArr);        
       
        return view('admin.blocks.index')->with($data);
    }
    
    public function create()
    {
        //=== check permision
        if(!has_permision(['blocks'=>'RW'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Add Block',
            'keywords'=>'',
            'description'=>'',
        ];     
        $languages = AllFunction::get_languages();             
        $data = compact('meta','languages'); 
        return view('admin.blocks.create')->with($data);
    }

    public function store(Request $request)
    {
        //=== check permision
        if(!has_permision(['blocks'=>'RW'])){ return redirect( route('dashboard') ); }

        //==== apply_action =====
        $apply_action = $request['apply_action'] ?? '';
        if($apply_action){
            $id_array = $request['id'] ?? [];

            if( $apply_action == 'active' && $id_array){               
                Blocks::whereIn('block_id', $id_array)->update(array('status' => '1'));
                return redirect( route('blocks.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'in_active' && $id_array){                
                Blocks::whereIn('block_id', $id_array)->update(array('status' => '0'));
                return redirect( route('blocks.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'delete' && $id_array){               
                Blocks::whereIn('block_id', $id_array)->delete();
                Blocks_language::whereIn('block_id', $id_array)->delete();
                return redirect( route('blocks.index') )->with('message','Selected item deleted successfully');
            }  
        }

        //==== Add new data =====   
        $languages = AllFunction::get_languages();    
        $messages = [];  
        $rules = [
            'identity'  => 'required|unique:blocks', 
            'status'    => 'required'
        ];
        foreach($languages as $val){
            $language_id = $val['language_id'];
            $title = $request['title'][$language_id] ?? '';
            if(!$title){
                $rules['title['.$language_id.']'] = 'required';
                $messages['title['.$language_id.'].required'] = 'Title is required';
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
            // store
            $table = new Blocks;                  
            $table->identity   = $request['identity'];                          
            $table->status     = $request['status'];
            $table->save();

            $block_id = $table->block_id;   
            
            Blocks_language::where('block_id', $block_id)->delete();
            foreach($languages as $val){
                $language_id = $val['language_id'];
                $table = new Blocks_language;
                $table->block_id            = $block_id;
                $table->language_id         = $language_id;
                $table->title               = $request['title'][$language_id] ?? '';
                $table->description         = $request['description'][$language_id] ?? '';                
                $table->save();
            }              

            // redirect
            return redirect( route('blocks.index') )->with('message','Block created successfully');
        }        
    }
    
    public function show(string $id)
    {
        //====
    }
    
    public function edit(string $id)
    {
        //=== check permision
        if(!has_permision(['blocks'=>'RW'])){ return redirect( route('dashboard') ); }

        $data = Blocks::where('block_id',$id); 
        if(!$data){
            return redirect( route('blocks.index') );
        }
        $data = $data->with('blocks_language')->first()->toArray();
        $blocks_language = $data['blocks_language'] ?? [];        

        $meta = [
            'title'=>'Edit Block',
            'keywords'=>'',
            'description'=>'',
        ]; 

        $languages = AllFunction::get_languages(); 
        $lang_data = [];
        foreach($blocks_language as $val){
            $lang_data[$val['language_id']] = $val;
        }
        
        $data = compact('meta','data','lang_data','id','languages');         
        return view('admin.blocks.edit')->with($data);
    }
    
    public function update(Request $request, string $id)
    {
        //=== check permision
        if(!has_permision(['blocks'=>'RW'])){ return redirect( route('dashboard') ); }

        $languages = AllFunction::get_languages();    
        $messages = [];  
        $rules = [
            'identity'  => 'required|unique:blocks,identity,'.$id.',block_id', 
            'status'    => 'required'
        ];
        foreach($languages as $val){
            $language_id = $val['language_id'];
            $title = $request['title'][$language_id] ?? '';
            if(!$title){
                $rules['title['.$language_id.']'] = 'required';
                $messages['title['.$language_id.'].required'] = 'Title is required';
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

            $table = Blocks::find($id);
            $table->identity  = $request['identity'];
            $table->status    = $request['status'];
            $table->save();  
            
            Blocks_language::where('block_id', $id)->delete();
            foreach($languages as $val){
                $language_id = $val['language_id'];
                $table = new Blocks_language;
                $table->block_id            = $id;
                $table->language_id         = $language_id;
                $table->title               = $request['title'][$language_id] ?? '';
                $table->description         = $request['description'][$language_id] ?? '';                
                $table->save();
            }  

            return redirect( route('blocks.index') )->with('message','Block updated successfully');
        }
    }
   
    public function destroy(string $id)
    {
        //=== check permision
        if(!has_permision(['blocks'=>'RW'])){ return redirect( route('dashboard') ); }

        $table = Blocks::find($id);
        $table->delete();
        Blocks_language::where('block_id', $id)->delete();
        return json_encode(array(
            'status'=>'success',
            'url'=>route('blocks.index')
        ));
        exit;
    }
}
