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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    use AllFunction; 

    public function index(Request $request){   
        
        $language_id = AllFunction::get_current_language();       

        $q = DB::table('pages');  
        $q = $q->leftJoin('pages_language','pages_language.page_id','=','pages.page_id'); 
        $q = $q->where('pages_language.language_id',$language_id);   
        $q = $q->where('pages.slug','change-password'); 
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
        return Inertia::render('frontend/pages/change_password/Change_password', [            
            'pageData' => $pageData,            
        ]);
    }

    public function password_post(Request $request){ 

        $customer_id = Auth::guard('customer')->id();      
        $customer = Auth::guard('customer')->user();
        
        $rules = [
            'password' => ['required', function($attribute, $value, $fail) use($request, $customer){               
                $password = $customer->password;               
                if( !Hash::check($value, $password) ){                        
                    return $fail('The current password is incorrect.');
                }
            }],
            'new_password'   => 'required|min:6',
            'renew_password' => 'required|same:new_password'		
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
            $customer = Customers::find($customer_id);
            if($customer){
                $customer->password = Hash::make($request['new_password']);               
                $customer->save();
            }             
            return redirect()->route('customer.changepassword')->with('success','Password updated successfully!');
        }
    }    
}
