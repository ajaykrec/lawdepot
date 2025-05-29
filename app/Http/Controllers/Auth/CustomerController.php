<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;

use App\Models\Pages;
use App\Models\Customers;
use App\Models\Email_templates;
use App\Traits\AllFunction;
use Inertia\Inertia; 
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    use AllFunction;

    public function register(Request $request){

        $language_id = AllFunction::get_current_language(); 
        $q = DB::table('pages');  
        $q = $q->leftJoin('pages_language','pages_language.page_id','=','pages.page_id'); 
        $q = $q->where('pages_language.language_id',$language_id);   
        $q = $q->where('pages.slug','register'); 
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

        //==== set return_url
        $return_url = $request['return_url'] ?? '';            
        if($return_url){
            Session::put('return_url', $return_url);        
        } 
        //====       
        
        $pageData = compact('page','meta','header_banner','breadcrumb'); 
        return Inertia::render('frontend/Auth/Register', [            
            'pageData' => $pageData,            
        ]);
    }

    public function register_post(Request $request){
        $data = [];  

        $rules = [
            'name'      => 'required',
            'email'     => 'required|unique:customers', 
            'phone'     => 'required|unique:customers', 
            'password'  => 'required|min:6',  
            'confirm_password'=> 'required|same:password',  
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
            
            //==== add customer into Stripe ====
            $stripe = new \Stripe\StripeClient(env('STRIPE_Secret_key'));
            $stripe_response = $stripe->customers->create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone'=> $request['phone'],
            ]);
            //=====

            $table = new Customers;   
            $table->stripe_customer_id = $stripe_response->id ?? '';                     
            $table->name        = $request['name'];            
            $table->email       = $request['email'];
            $table->phone       = $request['phone'];
            $table->password    = Hash::make($request['password']);                                     
            $table->status      = 1;
            $table->save();
            $customer_id = $table->customer_id; 

            if( Auth::guard('customer')->attempt([ 'email' => $request['email'], 'password' => $request['password'], 'status'=>'1' ])){ 

                $customer_id = Auth::guard('customer')->id();
                $customer  = Auth::guard('customer')->user()->toArray();
                Session::put('customer_data', $customer);                   

                if(Session::has('return_url')){           
                    return redirect(Session::get('return_url'));
                }
                else{
                    return redirect()->route('customer.account')->with('success','You are successfully created your account!');
                }
            }
            else{
                return redirect()->route('customer.login');
            }            
        }  
    }

    public function login(Request $request){

        if(Session::has('customer_data')){           
            return redirect()->route('customer.account');
        }
        
        $language_id = AllFunction::get_current_language(); 
        $q = DB::table('pages');  
        $q = $q->leftJoin('pages_language','pages_language.page_id','=','pages.page_id'); 
        $q = $q->where('pages_language.language_id',$language_id);   
        $q = $q->where('pages.slug','login'); 
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

        //=== get cookie remember me ===
        $email    = Cookie::get('customer_email') ?? '';
        $password = Cookie::get('customer_password') ?? '';
        $remember = ( $email && $password ) ? true : false ;
        //===     
        
        //==== set return_url
        $return_url = $request['return_url'] ?? '';  
        if($return_url){
            Session::put('return_url', $return_url);        
        } 
        //====       

        $pageData = compact( 'page', 'meta', 'header_banner', 'breadcrumb', 'email', 'password', 'remember' );    

        return Inertia::render('frontend/Auth/Login', [            
            'pageData' => $pageData,            
        ]);
    }
    public function login_post(Request $request){
        $data = [];
        $rules = [
            'email'     => 'required', 
            'password'  => 'required',             
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
            if( Auth::guard('customer')->attempt([ 'email' => $request['email'], 'password' => $request['password'], 'status'=>'1' ])){ 
                
                $customer_id = Auth::guard('customer')->id();
                $customer  = Auth::guard('customer')->user()->toArray();
                Session::put('customer_data', $customer);                 

                $remember  = $request['remember'] ?? ''; 
                if($remember){                   
                    //== set cookie
                    $minutes = 60;
                    Cookie::queue(Cookie::make('customer_email', $request['email'], $minutes));  
                    Cookie::queue(Cookie::make('customer_password', $request['password'], $minutes));                           
                }
                else{
                    //== delete cookie
                    Cookie::queue(Cookie::forget('customer_email'));
                    Cookie::queue(Cookie::forget('customer_password')); 
                }

                
                if(Session::has('return_url')){           
                    return redirect(Session::get('return_url'));
                }
                else{
                    return redirect()->route('customer.account')->with('success','You are successfully login!');
                }
                
            }
            else{                
                return back()->withInput()->with('error','The provided credentials do not match any record.');         
            } 
        }
    }

    public function forgot_password(){

        $language_id = AllFunction::get_current_language(); 
        $q = DB::table('pages');  
        $q = $q->leftJoin('pages_language','pages_language.page_id','=','pages.page_id'); 
        $q = $q->where('pages_language.language_id',$language_id);   
        $q = $q->where('pages.slug','forgot-password'); 
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

        $pageData = compact('page', 'meta','header_banner', 'breadcrumb');   
        return Inertia::render('frontend/Auth/Forgot_password', [            
            'pageData' => $pageData,            
        ]);
    }

    public function forgot_password_post(Request $request){

        $email = $request['email'] ?? '';        
        $rules = [
            'email' => 'required',             
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
            $customer = Customers::where('email',$email)->get()->first();
            if($customer){

                $token = app('auth.password.broker')->createToken($customer);
                $customer  = $customer->toArray();
                $customer_id = $customer['customer_id'];

                //=== update remember_token
                $table = Customers::find($customer_id);
                $table->remember_token = $token;
                $table->save();   
                
                $reset_password_link = route('customer.password.reset', $token.'?email='.$email); 

                //=== mail [start] ===
                $common = AllFunction::get_common_data();

                $email_template = Email_templates::find('2')->toArray();             
                $subject        = $email_template['subject'];            
                $body           = $email_template['body'];
                
                $body    = str_replace('{site_url}',$common['settings']['site_url'],$body);
                $body    = str_replace('{logo}',$common['settings']['logo'],$body);
                $body    = str_replace('{site_name}',$common['settings']['site_name'],$body);
                $body    = str_replace('{reset_password_link}',$reset_password_link,$body);   

                // AllFunction::mail_with_sendgrid([
                //     'name'=>'',
                //     'email'=>$email,
                //     'from_email_name'=>$common['settings']['from_email_name'],
                //     'from_email'=>$common['settings']['from_email'],
                //     'subject'=>$subject,
                //     'content'=>$body,
                // ]);

                AllFunction::send_mail([
                    'name'=>'',
                    'email'=>$email,
                    'from_email_name'=>$common['settings']['from_email_name'],
                    'from_email'=>$common['settings']['from_email'],
                    'subject'=>$subject,
                    'content'=>$body,
                ]);
                //=== mail [ends] ===
                return back()->with('success','Please check your mail, your password reset link is sent to your email address.');
            }
            else{
                return back()->withInput()->with('error','We can not find a user with this email address.');   
            }       
        }         
    }
    public function reset_password(string $token){    

        $data   = [];
        $email  = $_GET['email'] ?? '';         
        $customer = Customers::where('email',$email)->where('remember_token',$token)->get()->first();  
       
        if(!$customer){
            return redirect()->route('home');
        }        
        
        $language_id = AllFunction::get_current_language(); 
        $q = DB::table('pages');  
        $q = $q->leftJoin('pages_language','pages_language.page_id','=','pages.page_id'); 
        $q = $q->where('pages_language.language_id',$language_id);   
        $q = $q->where('pages.slug','reset-password'); 
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
        
        $pageData = compact('page','meta','email','token','header_banner', 'breadcrumb'); 
        return Inertia::render('frontend/Auth/Reset_password', [            
            'pageData' => $pageData,            
        ]);
    }
    public function reset_password_post(Request $request){
        $data = [];  
        $rules = [         
            'password'  => 'required|min:6',  
            'confirm_password'=> 'required|same:password',  
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
            $email = $request['email'] ?? '';      
            $token = $request['token'] ?? '';     
            $password = $request['password'] ?? '';      
            $customer = Customers::where('email',$email)->where('remember_token',$token)->get()->first();
            if($customer){               
                $customer = $customer->toArray();
                $customer_id = $customer['customer_id'];
                //=== update remember_token
                $table = Customers::find($customer_id);
                $table->password = Hash::make($password);
                $table->remember_token = '';
                $table->save();                
                
                return redirect()->route('customer.login')->with('success','You are successfully Updated your password!');
            }
            else{
                return back()->withInput()->with('error','Invalid token or email address.');   
            }       
            
        }

    }
    public function logout(Request $request){
        //Session::flush();  
        Session::forget('customer_data');   
        Auth::guard('customer')->logout(); 
        
        return redirect()->route('customer.login');
    }    
}
