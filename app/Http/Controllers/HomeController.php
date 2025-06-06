<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\AllFunction; 
use App\Models\Pages;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia; 

class HomeController extends Controller
{
    use AllFunction; 

    public function index(Request $request){  
        
        //==== set country ===
        $loc = $request['loc'] ?? '';  
        if($loc){            
            $resp = AllFunction::set_country($loc); 
            if($resp){
                return redirect()->route('home');
            }
        }
        //=======
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

        $q = DB::table('banners');  
        $q = $q->leftJoin('banners_language','banners_language.banner_id','=','banners.banner_id'); 
        $q = $q->where('banners_language.language_id',$language_id);   
        $q = $q->where('banners.bannercat_id','1'); 
        $q = $q->where('banners.status','1'); 
        $q = $q->orderBy("banners.sort_order", "asc"); 
        $banners = $q->get()->toArray(); 
        $banners = json_decode(json_encode($banners), true);   
        $banners = $banners[0] ?? [];

        $q = DB::table('documents');  
        $q = $q->select('documents.document_id','documents.category_id','documents.name','documents.slug','documents.short_description','documents.image');
        $q = $q->where('documents.status',1); 
        $q = $q->where('documents.country_id',$country_id);   
        $q = $q->limit(10); 
        $q = $q->orderby('documents.sort_order','asc'); 
        $q = $q->orderby('documents.name','asc'); 
        $documents = $q->get()->toArray(); 
        $documents = json_decode(json_encode($documents), true);        
        
        $pageData = compact('page','meta','banners','documents'); 
        return Inertia::render('frontend/pages/home/Home', [            
            'pageData' => $pageData,            
        ]);
    }
    
}
