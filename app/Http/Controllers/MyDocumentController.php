<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\AllFunction; 
use App\Models\Pages;
use App\Models\Customers_document;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia; 

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Cache;

class MyDocumentController extends Controller
{
    use AllFunction; 

    public function index(Request $request){   
        
        $language_id = AllFunction::get_current_language();       

        $q = DB::table('pages');  
        $q = $q->leftJoin('pages_language','pages_language.page_id','=','pages.page_id'); 
        $q = $q->where('pages_language.language_id',$language_id);   
        $q = $q->where('pages.slug','my-documents'); 
        $page = $q->first(); 
        $page = json_decode(json_encode($page), true); 
       
        $meta = [
            'title'=>$page['meta_title'] ?? '',
            'keywords'=>$page['meta_keyword'] ?? '',
            'description'=>$page['meta_description'] ?? '',
        ];   

        $header_banner = [
            'title'=>$page['name'],
            'banner_image'=>$page['banner_image'],
            'banner_text'=>$page['banner_text'],
        ];
        $breadcrumb = [
            ['name'=>'Home', 'url'=>route('home')],
            ['name'=>'My Account', 'url'=>route('customer.account')],
            ['name'=>$page['name'], 'url'=>''],
        ];

        $customer = (Session::has('customer_data')) ? Session::get('customer_data') : []; 
        $customer_id = $customer['customer_id'] ?? '';        

        //=== document list
        $filterArr               = [];
        $filterArr['file_name']  = $request['file_name'] ?? ''; 
        
        $pagi_url = route('customer.documents').'?';
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
        $q = $q->where('customer_id',$customer_id);         
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'file_name'){
                        $q->where('file_name',$val);
                    }
                }
            }
        }            
        $q->with(['document']); 
        $q->orderBy('cus_document_id','desc'); 
        $count = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 
        $results  = json_decode(json_encode($results), true); 
        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);
        //p($results);
        //=====
        
        $pageData = compact('page','meta','header_banner','breadcrumb','results','paginate','start_count'); 
        return Inertia::render('frontend/pages/my_documents/My_documents', [            
            'pageData' => $pageData,            
        ]);
    }

    public function view($cus_document_id, Request $request){   
       
        $language_id = AllFunction::get_current_language();       

        $q = DB::table('pages');  
        $q = $q->leftJoin('pages_language','pages_language.page_id','=','pages.page_id'); 
        $q = $q->where('pages_language.language_id',$language_id);   
        $q = $q->where('pages.slug','my-documents'); 
        $page = $q->first(); 
        $page = json_decode(json_encode($page), true); 
       
        $meta = [
            'title'=>$page['meta_title'] ?? '',
            'keywords'=>$page['meta_keyword'] ?? '',
            'description'=>$page['meta_description'] ?? '',
        ];   

        $header_banner = [
            'title'=>$page['name'],
            'banner_image'=>$page['banner_image'],
            'banner_text'=>$page['banner_text'],
        ];
        $breadcrumb = [
            ['name'=>'Home', 'url'=>route('home')],
            ['name'=>'My Account', 'url'=>route('customer.account')],
            ['name'=>'My Documents', 'url'=>route('customer.documents')],
            ['name'=>'View Document', 'url'=>''],
        ];

        $document = Customers_document::find($cus_document_id)->with(['document'])->get()->toArray();         
        $document = $document[0] ?? [];

        $filter_values = $document['filter_values'] ?? '';
        $template = $document['document']['template'] ?? '';
        $template = AllFunction::replace_template([
            'template' => $template,
            'question_value' => (array)json_decode($filter_values),
        ]); 
        $document['document']['template'] = $template;

        $pageData = compact('page','meta','header_banner','breadcrumb','document'); 
        return Inertia::render('frontend/pages/my_documents/View_document', [            
            'pageData' => $pageData,            
        ]);
    }
    
}
