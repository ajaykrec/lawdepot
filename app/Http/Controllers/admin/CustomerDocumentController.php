<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Traits\AllFunction;
use App\Models\Customers;
use App\Models\Customers_document;

class CustomerDocumentController extends Controller
{
    use AllFunction; 
    
    public function index($customer_id,Request $request)
    {       
        //=== check permision
        if(!has_permision(['customers'])){ return redirect( route('dashboard') ); }

        $customer = Customers::find($customer_id)->toArray();        

        $meta = [
            'title'=>'Documents for : '.$customer['name'] ?? '',
            'keywords'=>'',
            'description'=>'',
        ];   

        $filterArr                 = [];
        $filterArr['customer_id']  = $customer_id;
        $filterArr['file_name']    = $request['file_name'] ?? '';   

        //=== pagi_url
        $pagi_url = route('customers.cusdocument.index',$customer_id).'?';
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

        $q = Customers_document::query();
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'customer_id'){
                        $q->where('customer_id',$val);
                    }       
                    if($key == 'file_name'){
                        $q->where('file_name','like','%'.$val.'%');
                    }
                }
            }
        }     
        $q->with(['document']);     
        $q->orderBy("created_at", "DESC");   
        $count    = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 
        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);

        $data = compact('meta','results','count','start_count','paginate','customer_id'); 
        $data = array_merge($data,$filterArr);        
       
        return view('admin.customers_document.index')->with($data);
    }
    
    public function create($customer_id)
    {
        //==
    }

    public function store($customer_id,Request $request)
    {
        //=== check permision
        if(!has_permision(['customers'=>'RW'])){ return redirect( route('dashboard') ); }

        //==== apply_action =====
        $apply_action = $request['apply_action'] ?? '';
        if($apply_action){
            $id_array = $request['id'] ?? [];

            if( $apply_action == 'active' && $id_array){
                Customers_document::whereIn('cus_document_id', $id_array)->update(array('status' => '1'));
                return redirect( route('customers.cusdocument.index',$customer_id) )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'in_active' && $id_array){                
                Customers_document::whereIn('cus_document_id', $id_array)->update(array('status' => '0'));
                return redirect( route('customers.cusdocument.index',$customer_id) )->with('message','Selected item Updated successfully');
            }
            else if( $apply_action == 'delete' && $id_array){     
                Customers_document::whereIn('cus_document_id', $id_array)->delete();
                return redirect( route('customers.cusdocument.index',$customer_id) )->with('message','Selected item deleted successfully');
            }  
        }

    }
    
    public function show($cus_document_id)
    {
        $meta = [
            'title'=>'View Documents',
            'keywords'=>'',
            'description'=>'',
        ];   
        
        $document = Customers_document::where('cus_document_id',$cus_document_id)->with(['document'])->first()->toArray();  
        $customer_id = $document['customer_id'] ?? '';

        // $filter_values = $document['filter_values'] ?? '';
        // $template = $document['document']['template'] ?? '';
        // $template = AllFunction::replace_template([
        //     'template' => $template,
        //     'question_value' => (array)json_decode($filter_values),
        // ]); 
        // $document['document']['template'] = $template;    
        $document['document']['template'] = $document['openai_document'] ?? '';    

        $data = compact('meta','document','customer_id','cus_document_id');        
        return view('admin.customers_document.show')->with($data);
    }
    
    public function edit($cus_document_id)
    {
        //===
    }
    
    public function update(Request $request, string $cus_document_id)
    {
        //===
    }
   
    public function destroy(string $cus_document_id)
    {
        //=== check permision
        if(!has_permision(['customers'=>'RW'])){ return redirect( route('dashboard') ); }

        $table = Customers_document::find($cus_document_id); 
        $customer_id =  $table->customer_id ?? '';  
        $table->delete();

        return json_encode(array(
            'status'=>'success',
            'url'=>route('customers.cusdocument.index',$customer_id)
        ));
        exit;
    }
}
