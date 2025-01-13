<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\AllFunction; //<= calling traits
use App\Models\Pages;
use App\Models\Services;
use App\Models\Banners;
use Inertia\Inertia; 
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    use AllFunction; 

    public function about(){
        $common = AllFunction::get_common_data();
        $page   = Pages::select('page_id','slug','name','content','meta_title','meta_keyword','meta_description')->where('page_id','2')->first()->toArray();  
        $meta = [
            'title'=>$page['meta_title'] ?? '',
            'keywords'=>$page['meta_keyword'] ?? '',
            'description'=>$page['meta_description'] ?? '',
        ];        
        $services = Services::select('*')->where('status',1)->orderBy('name','asc')->get()->toArray(); 
        $galleries = Banners::select('*')
        ->where(function($query){
            $query->where('bannercat_id','2')
            ->where('status','1');
        })        
        ->orderBy('sort_order','asc')->limit(4)->get()->toArray();         
        $pageData = compact('common','page','meta','services','galleries'); 

        return Inertia::render('frontend/about/About', [            
            'pageData' => $pageData,            
        ]);
        
    }

    public function feature(){
        $common = AllFunction::get_common_data();
        $page   = Pages::select('page_id','slug','name','content','meta_title','meta_keyword','meta_description')->where('page_id','6')->first()->toArray();  
        $meta = [
            'title'=>$page['meta_title'] ?? '',
            'keywords'=>$page['meta_keyword'] ?? '',
            'description'=>$page['meta_description'] ?? '',
        ];        
        $services = Services::select('*')->where('status',1)->orderBy('name','asc')->get()->toArray(); 
        $galleries = Banners::select('*')
        ->where(function($query){
            $query->where('bannercat_id','2')
            ->where('status','1');
        })        
        ->orderBy('sort_order','asc')->limit(4)->get()->toArray();    

        $pageData = compact('common','page','meta','services','galleries'); 
        return Inertia::render('frontend/about/Feature', [            
            'pageData' => $pageData,            
        ]);
        
    }
    public function teams(){
        $common = AllFunction::get_common_data();
        $page   = Pages::select('page_id','slug','name','content','meta_title','meta_keyword','meta_description')->where('page_id','7')->first()->toArray();  
        $meta = [
            'title'=>$page['meta_title'] ?? '',
            'keywords'=>$page['meta_keyword'] ?? '',
            'description'=>$page['meta_description'] ?? '',
        ];        
        $services = Services::select('*')->where('status',1)->orderBy('name','asc')->get()->toArray(); 
        $galleries = Banners::select('*')
        ->where(function($query){
            $query->where('bannercat_id','2')
            ->where('status','1');
        })        
        ->orderBy('sort_order','asc')->limit(4)->get()->toArray();       
          
        $pageData = compact('common','page','meta','services','galleries'); 
        return Inertia::render('frontend/about/Teams', [            
            'pageData' => $pageData,            
        ]);
        
    }    

    public function terms_condition(){

        $common = AllFunction::get_common_data();
        $page   = Pages::select('page_id','slug','name','content','meta_title','meta_keyword','meta_description')->where('page_id','10')->first()->toArray();
        
        $meta = [
            'title'=>$page['meta_title'] ?? '',
            'keywords'=>$page['meta_keyword'] ?? '',
            'description'=>$page['meta_description'] ?? '',
        ];        
        
        $pageData = compact('common','page','meta'); 
        return Inertia::render('frontend/about/Terms_condition', [            
            'pageData' => $pageData,            
        ]);
       
    }

    public function coming_soon(){

        $language_id = AllFunction::default_language_id();

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
        
        $pageData = compact('page','meta'); 
        return Inertia::render('frontend/pages/coming_soon/Coming_soon', [            
            'pageData' => $pageData,            
        ]);
    }

    public function notfound(){       

        $language_id = AllFunction::default_language_id();

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
        
        $pageData = compact('page','meta'); 
        return Inertia::render('frontend/pages/page_not_found/Page_not_found', [            
            'pageData' => $pageData,            
        ]);
    }
    
}
