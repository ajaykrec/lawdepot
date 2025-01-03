<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Traits\AllFunction;
use App\Models\Faq;
use App\Models\Faq_language;
use Illuminate\Support\Facades\DB;


class FaqController extends Controller
{
    use AllFunction; 
    
    public function index(Request $request)
    {
        //=== check permision
        if(!has_permision(['faq'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Faq',
            'keywords'=>'',
            'description'=>'',
        ];    
        
        $filterArr               = [];
        $filterArr['question']   = $request['question'] ?? '';
        $filterArr['status']     = $request['status'] ?? '';   
        $language_id = AllFunction::default_language_id();
        //=== pagi_url
        $pagi_url = route('faq.index').'?';
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

        $q = DB::table('faqs');  
        $q = $q->leftJoin('faqs_language','faqs_language.faq_id','=','faqs.faq_id');  
        $q = $q->where('faqs_language.language_id',$language_id);         
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'question'){
                        $q->where('faqs_language.question','like','%'.$val.'%');
                    }
                    if($key == 'status'){
                        $q->where('faqs.status',$val);
                    }
                }
            }
        }            
        $q->orderBy("faqs.sort_order", "asc"); 
        $count = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 
        $results  = json_decode(json_encode($results), true); 
        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);

        $data = compact('meta','results','count','start_count','paginate'); 
        $data = array_merge($data,$filterArr);        
       
        return view('admin.faq.index')->with($data);
    }
    
    public function create()
    {
        //=== check permision
        if(!has_permision(['faq'=>'RW'])){ return redirect( route('dashboard') ); }

        $meta = [
            'title'=>'Add Faq',
            'keywords'=>'',
            'description'=>'',
        ];    
        $languages = AllFunction::get_languages();                   
        $data = compact('meta','languages'); 
        return view('admin.faq.create')->with($data);
    }
    
    public function store(Request $request)
    {
        //=== check permision
        if(!has_permision(['faq'=>'RW'])){ return redirect( route('dashboard') ); }

        //==== apply_action =====
        $apply_action = $request['apply_action'] ?? '';
        if($apply_action){
            $id_array = $request['id'] ?? [];

            if( $apply_action == 'active' && $id_array){                
                Faq::whereIn('faq_id', $id_array)->update(array('status' => '1'));
                return redirect( route('faq.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'in_active' && $id_array){                
                Faq::whereIn('faq_id', $id_array)->update(array('status' => '0'));
                return redirect( route('faq.index') )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'delete' && $id_array){                 
                Faq::whereIn('faq_id', $id_array)->delete();
                Faq_language::whereIn('faq_id', $id_array)->delete();
                return redirect( route('faq.index') )->with('message','Selected item deleted successfully');
            }  
        }

        //==== Add new data ===== 
        $languages = AllFunction::get_languages();    
        $messages = [];      
        $rules = [           
            'status'   => 'required'
        ];
        
        foreach($languages as $val){
            $language_id = $val['language_id'];
            $question = $request['question'][$language_id] ?? '';
            $answer = $request['answer'][$language_id] ?? '';

            if(!$question){
                $rules['question['.$language_id.']'] = 'required';
                $messages['question['.$language_id.'].required'] = 'Question is required';
            }   
            if(!$answer){
                $rules['answer['.$language_id.']'] = 'required';
                $messages['answer['.$language_id.'].required'] = 'Answer is required';
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
            $table = new Faq;           
            $table->sort_order  = $request['sort_order'] ?? 0;
            $table->status      = $request['status'];
            $table->save();

            $faq_id = $table->faq_id;   

            Faq_language::where('faq_id', $faq_id)->delete();
            foreach($languages as $val){
                $language_id = $val['language_id'];
                $table = new Faq_language;
                $table->faq_id        = $faq_id;
                $table->language_id   = $language_id;
                $table->question      = $request['question'][$language_id] ?? '';
                $table->answer        = $request['answer'][$language_id] ?? '';                
                $table->save();
            }              

            // redirect
            return redirect( route('faq.index') )->with('message','Faq created successfully');
        }        
    }

    public function show($id)
    {
        //====
    }
    
    public function edit($id)
    {
        //=== check permision
        if(!has_permision(['faq'=>'RW'])){ return redirect( route('dashboard') ); }

        $data = Faq::where('faq_id',$id); 
        if(!$data){
            return redirect( route('faq.index') );
        }
        $data = $data->with('faqs_language')->first()->toArray();
        $faqs_language = $data['faqs_language'] ?? [];  

        $meta = [
            'title'=>'Edit Faq',
            'keywords'=>'',
            'description'=>'',
        ];  

        $languages = AllFunction::get_languages(); 
        $lang_data = [];
        foreach($faqs_language as $val){
            $lang_data[$val['language_id']] = $val;
        }
        
        $data = compact('meta','data','lang_data','id','languages');         
        return view('admin.faq.edit')->with($data);
    }
    
    public function update(Request $request, $id)
    {
        //=== check permision
        if(!has_permision(['faq'=>'RW'])){ return redirect( route('dashboard') ); }

        $languages = AllFunction::get_languages();   

        $messages = [];      
        $rules = [           
            'status'   => 'required'
        ];        
        foreach($languages as $val){
            $language_id = $val['language_id'];
            $question = $request['question'][$language_id] ?? '';
            $answer = $request['answer'][$language_id] ?? '';

            if(!$question){
                $rules['question['.$language_id.']'] = 'required';
                $messages['question['.$language_id.'].required'] = 'Question is required';
            }   
            if(!$answer){
                $rules['answer['.$language_id.']'] = 'required';
                $messages['answer['.$language_id.'].required'] = 'Answer is required';
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
            $table = Faq::find($id);            
            $table->sort_order  = $request['sort_order'] ?? 0;
            $table->status      = $request['status'];
            $table->save();  
            
            Faq_language::where('faq_id', $id)->delete();
            foreach($languages as $val){
                $language_id = $val['language_id'];
                $table = new Faq_language;
                $table->faq_id        = $id;
                $table->language_id   = $language_id;
                $table->question      = $request['question'][$language_id] ?? '';
                $table->answer        = $request['answer'][$language_id] ?? '';                
                $table->save();
            }             

            return redirect( route('faq.index') )->with('message','Faq updated successfully');
        }
    }
   
    public function destroy($id)
    {
        //=== check permision
        if(!has_permision(['faq'=>'RW'])){ return redirect( route('dashboard') ); }

        $table = Faq::find($id);
        $table->delete();
        Faq_language::where('faq_id', $id)->delete();
        return json_encode(array(
            'status'=>'success',
            'url'=>route('faq.index')
        ));
        exit;
    }
}
