<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\AllFunction; 
use App\Models\Pages;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia; 

class SearchController extends Controller
{
    use AllFunction; 

    public function index(Request $request){  
        
        //==== set country ===
        $s = $request['s'] ?? '';        
        $language_id = AllFunction::get_current_language();          
        $country     = AllFunction::get_current_country(); 
        $country_id  = $country['country_id'] ?? ''; 

        $q = DB::table('pages');  
        $q = $q->leftJoin('pages_language','pages_language.page_id','=','pages.page_id'); 
        $q = $q->where('pages_language.language_id',$language_id);   
        $q = $q->where('pages.slug','/'); 
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

        $q = DB::table('documents');  
        $q = $q->select('documents.document_id','documents.category_id','documents.name','documents.slug','documents.short_description','documents.image');
        $q = $q->where('documents.status',1); 
        $q = $q->where('documents.country_id',$country_id);   
        $q = $q->where('documents.name','like','%'.$s.'%');       
        $q = $q->orderby('documents.sort_order','asc'); 
        $q = $q->orderby('documents.name','asc'); 
        $documents = $q->get()->toArray(); 
        $documents = json_decode(json_encode($documents), true);        
        
        $pageData = compact('page','meta','header_banner','breadcrumb','documents','s'); 
        return Inertia::render('frontend/pages/search/Search_result', [            
            'pageData' => $pageData,            
        ]);
    }
    
}
