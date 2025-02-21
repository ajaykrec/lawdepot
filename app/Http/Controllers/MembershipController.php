<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\AllFunction; 
use App\Models\Pages;
use App\Models\Document;
use App\Models\Membership;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia; 

class MembershipController extends Controller
{
    use AllFunction; 

    public function index(Request $request){  
       
        $language_id = AllFunction::get_current_language();    
        $country     = AllFunction::get_current_country();         
        $country_id  = $country['country_id'] ?? '';

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

        $q = DB::table('membership')->select('*')
        ->where('country_id',$country_id)
        ->where('status',1)
        ->orderBy('sort_order','asc')->get()->toArray(); 
        $results = json_decode(json_encode($q), true); 
        $membership = [];
        foreach( $results as $val ){
            $val['specification'] = (array)json_decode($val['specification']);
            $membership[] = $val;
        }        

        $pageData = compact('page','meta','header_banner','breadcrumb','membership'); 
        return Inertia::render('frontend/pages/membership/Membership', [            
            'pageData' => $pageData,            
        ]);               
    }    

    public function select_membership(Request $request){  
        $membership_id = $request['membership_id'] ?? '';
        Session::put('membership_id', $membership_id);  
        return redirect( route('membership.checkout') )->with(['success'=>'']);   
    }    

    public function checkout(Request $request){  

        $membership_id =  Session::has('membership_id') ? Session::get('membership_id') : ''; 
        if(!$membership_id){
            return redirect( route('membership.index') );   
        }

        //==== remove return_url session ====
        Session::forget('return_url'); 
        //=====  

        $language_id = AllFunction::get_current_language();    
        $country     = AllFunction::get_current_country();         
        $country_id  = $country['country_id'] ?? '';

        $q = DB::table('pages');  
        $q = $q->leftJoin('pages_language','pages_language.page_id','=','pages.page_id'); 
        $q = $q->where('pages_language.language_id',$language_id);   
        $q = $q->where('pages.slug','checkout'); 
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
            ['name'=>'Membership', 'url'=>route('membership.index')],
            ['name'=>$page['name'], 'url'=>''],
        ];

        $membership = Membership::find($membership_id)->toArray(); 
        $membership['specification'] = (array)json_decode($membership['specification']);

        $q = DB::table('membership')->select('*')
        ->where('country_id',$country_id)
        ->where('status',1)
        ->orderBy('sort_order','asc')->get()->toArray(); 
        $results = json_decode(json_encode($q), true); 
        $all_membership = [];
        foreach( $results as $val ){
            $val['specification'] = (array)json_decode($val['specification']);
            $all_membership[] = $val;
        }        

        $pageData = compact('page','meta','header_banner','breadcrumb','membership','all_membership'); 
        
        return Inertia::render('frontend/pages/checkout/Checkout', [            
            'pageData' => $pageData,            
        ]);               
    }    
    
    
}
