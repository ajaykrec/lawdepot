<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\AllFunction; 
use App\Models\Pages;
use App\Models\Document_category;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia; 

class DocumentCategoryController extends Controller
{
    use AllFunction; 

    public function index($slug, Request $request){          

        $country = AllFunction::get_current_country(); 
        $country_id = $country['country_id'] ?? '';        

        $q = DB::table('documents_category');  
        $q = $q->where('documents_category.country_id',$country_id);   
        $q = $q->where('documents_category.slug',$slug); 
        $category = $q->first(); 
        //dd($category);
        $category = json_decode(json_encode($category), true);         

        $category_id = $category['category_id'] ?? ''; 
        
        $q = DB::table('documents');  
        $q = $q->select('documents.document_id','documents.category_id','documents.name','documents.slug','documents.short_description','documents.image');   
        $q = $q->where('documents.category_id',$category_id);   
        $q = $q->where('documents.status',1); 
        $q = $q->orderby('documents.sort_order','asc'); 
        $q = $q->orderby('documents.name','asc'); 
        $documents = $q->get()->toArray(); 
        $documents = json_decode(json_encode($documents), true);         
              
        $meta = [
            'title'=>$category['meta_title'] ?? '',
            'keywords'=>$category['meta_keyword'] ?? '',
            'description'=>$category['meta_description'] ?? '',
        ];

        $header_banner = [
            'title'=>$category['name'],
            'banner_image'=>$category['banner_image'],
            'banner_text'=>$category['banner_text'],
        ];
        $breadcrumb = [
            ['name'=>'Home', 'url'=>route('home')],
            ['name'=>$category['name'], 'url'=>''],
        ];
                
        $pageData = compact('category','meta','header_banner','breadcrumb','documents'); 
        return Inertia::render('frontend/pages/category/Category', [            
            'pageData' => $pageData,            
        ]);
    }

    public function all_documents(Request $request){          

        $country = AllFunction::get_current_country(); 
        $country_id = $country['country_id'] ?? '';  
        $language_id = AllFunction::get_current_language();    

        $q = DB::table('pages');  
        $q = $q->leftJoin('pages_language','pages_language.page_id','=','pages.page_id'); 
        $q = $q->where('pages_language.language_id',$language_id);   
        $q = $q->where('pages.slug','all-documents'); 
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
            ['name'=>$page['name'], 'url'=>''],
        ];
        
        //====
        $filterArr          = [];
        $filterArr['name']  = $name = $request['name'] ?? ''; 

        $q = DB::table('documents');  
        $q = $q->select('documents.document_id','documents.category_id','documents.name','documents.slug','documents.short_description','documents.image');   
        $q = $q->where('documents.status',1); 
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'name'){
                        $q->where('documents.name','like','%'.$val.'%');
                    }                   
                }
            }
        }            
        $q = $q->orderby('documents.sort_order','asc'); 
        $q = $q->orderby('documents.name','asc'); 
        $count = $q->count();     
        $results = $q->get()->toArray(); 
        $document_results = json_decode(json_encode($results), true);     

        $documents = [];
        $azRange = range('A','Z');
        foreach($azRange as $letter){

            $docs = [];
            foreach($document_results as $val){
                $name = $val['name'] ?? '';  
                $first_character = $name[0] ?? '';
                if( ucfirst($first_character) == $letter){
                    $docs[] = $val;
                }                
            }

            if($docs){
                $documents[] = [
                    'letter'=>$letter,
                    'docs'=>$docs,
                ];           
            }
            
        }
        //p($documents);  

        $pageData = compact('page','meta','header_banner','breadcrumb','azRange','name','documents'); 
        return Inertia::render('frontend/pages/category/All_documents', [            
            'pageData' => $pageData,            
        ]);
    }

    
    
}
