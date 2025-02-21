<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\AllFunction; 
use App\Models\Pages;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia; 

class MyAccountController extends Controller
{
    use AllFunction; 

    public function index(){   
        
        $language_id = AllFunction::get_current_language();       

        $q = DB::table('pages');  
        $q = $q->leftJoin('pages_language','pages_language.page_id','=','pages.page_id'); 
        $q = $q->where('pages_language.language_id',$language_id);   
        $q = $q->where('pages.slug','my-account'); 
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

        $active_membership = AllFunction::get_active_membership();  
        
        $pageData = compact('page','meta','header_banner','breadcrumb','active_membership'); 
        return Inertia::render('frontend/pages/my_account/My_account', [            
            'pageData' => $pageData,            
        ]);
    }
    
}
