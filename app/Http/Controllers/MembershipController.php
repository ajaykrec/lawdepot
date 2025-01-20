<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\AllFunction; 
use App\Models\Pages;
use App\Models\Document_category;
use App\Models\Document;
use App\Models\Documents_step;
use App\Models\Documents_question;
use App\Models\Documents_question_option;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia; 

class MembershipController extends Controller
{
    use AllFunction; 

    public function index(Request $request){  
       
        $language_id = AllFunction::get_current_language();    

        $q = DB::table('pages');  
        $q = $q->leftJoin('pages_language','pages_language.page_id','=','pages.page_id'); 
        $q = $q->where('pages_language.language_id',$language_id);   
        $q = $q->where('pages.slug','membership'); 
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

        $pageData = compact('page','meta','header_banner','breadcrumb'); 
        return Inertia::render('frontend/pages/membership/Membership', [            
            'pageData' => $pageData,            
        ]);               
    }    
    
}
