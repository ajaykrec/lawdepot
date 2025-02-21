<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\AllFunction; 
use App\Models\Pages;
use App\Models\Customers;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia; 

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class MySettingsController extends Controller
{
    use AllFunction; 

    public function index(Request $request){   
        
        $language_id = AllFunction::get_current_language();       

        $q = DB::table('pages');  
        $q = $q->leftJoin('pages_language','pages_language.page_id','=','pages.page_id'); 
        $q = $q->where('pages_language.language_id',$language_id);   
        $q = $q->where('pages.slug','my-settings'); 
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
        
        $pageData = compact('page','meta','header_banner','breadcrumb'); 
        return Inertia::render('frontend/pages/my_settings/My_settings', [            
            'pageData' => $pageData,            
        ]);
    }

    public function account_post(Request $request){  

        $customer_id = Auth::guard('customer')->id();

        $data = []; 
        $rules = [
            'name'   => 'required',
            'email'  => 'required|unique:customers,email,'.$customer_id.',customer_id',  
            'phone'  => 'required|unique:customers,phone,'.$customer_id.',customer_id',            
        ];
        $messages = [];
        $validation = Validator::make( 
            $request->toArray(), 
            $rules, 
            $messages
        );        
        if($validation->fails()) {            
            return back()->withInput()->withErrors($validation->messages());            
        }
        else{     
            $dob = $request['dob'] ?? '';     
            if($dob==''){
                $dob = null;
            }    
            
            $table = Customers::find($customer_id);        
            $table->name    = $request['name'] ?? '';            
            $table->email   = $request['email'] ?? '';            
            $table->phone   = $request['phone'] ?? '';            
            $table->dob     = $dob;  
            $table->save();
           
            Session::put('customer_data', $table->toArray());  
            return redirect()->route('customer.settings')->with('success','Account Updated successfully!');
        }
    }
    
    
}
