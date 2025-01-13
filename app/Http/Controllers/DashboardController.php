<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\AllFunction; 
use App\Models\Pages;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia; 

class DashboardController extends Controller
{
    use AllFunction; 

    public function index(){   
        
        $language_id = AllFunction::get_current_language();       

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
        return Inertia::render('frontend/pages/dashboard/Dashboard', [            
            'pageData' => $pageData,            
        ]);
    }
    
}
