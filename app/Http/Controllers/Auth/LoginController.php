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

use App\Models\User;
use App\Models\Email_templates;
use App\Traits\AllFunction;
use Inertia\Inertia; 

class LoginController extends Controller
{
    use AllFunction; 

    public function login(Request $request){
       
        $meta = [
            'title'=>'Login',            
            'description'=>'',
        ];

        $settings = AllFunction::get_setting(['logo']);      
        $logo     = $settings['logo'];

        //=== get cookie remember me ===
        $email = Cookie::get('email') ?? '';
        $password = Cookie::get('password') ?? '';
        $remember = ( $email && $password ) ? true : false ;
        //===

        $pageData = compact( 'meta', 'logo', 'email', 'password', 'remember' );    

        return Inertia::render('frontend/Auth/Login', [            
            'pageData' => $pageData,            
        ]);
    }

    public function login_post(Request $request){        

        $rules = [
            'email'     => 'required|email',
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

            $email = $request['email'] ?? '';
            $password = $request['password'] ?? '';
            $remember = $request['remember'] ?? '';            

            if( Auth::attempt([ 'email' => $email, 'password' => $password, 'status'=>'1' ])){ 

                /*
                $id = Auth::id();
                $user = Auth::user()->toArray();
                $users_types = Auth::User()->users_types->toArray();
                echo '<pre>';
                print_r($id);
                print_r($user);
                print_r($users_types);                
                die;                
                */
                
                $id = Auth::id();
                Session::put('user_id', $id);
                Cache::pull('admin_user_data');  
                Cache::pull('admin_settings');      

                if($remember){  
                    //== set cookie
                    $minutes = 60;
                    Cookie::queue(Cookie::make('email', $email, $minutes));  
                    Cookie::queue(Cookie::make('password', $password, $minutes));                           
                }
                else{
                    //== delete cookie
                    Cookie::queue(Cookie::forget('email'));
                    Cookie::queue(Cookie::forget('password')); 
                }
                return redirect()->route('customer.dashboard');
            }
            else{
                $error = 'The provided credentials do not match our records.';
                return back()->withInput()->with('error', $error);
            } 
        }
    }

    public function forgot_password(){
        
        if( Auth::check() ){
            return redirect()->route('dashboard');
        }
        
        $meta = [
            'title'=>'Forgot password',            
            'description'=>'',
        ];        

        $settings = AllFunction::get_setting(['logo']);      
        $logo     = $settings['logo'];
        $pageData = compact( 'meta', 'logo' );  
        return Inertia::render('frontend/Auth/Forgot_password', [            
            'pageData' => $pageData,            
        ]);

    }
    public function forgot_password_post(Request $request){
        $rules = [
            'email' => 'required|email',
            
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
            $user  = User::where('email',$email)->get()->first();

            if($user){
                $token = app('auth.password.broker')->createToken($user);
                $user  = $user->toArray();
                $user_id = $user['user_id'];

                //=== update remember_token
                $table = User::find($user_id);
                $table->remember_token = $token;
                $table->save();   
                
                $reset_password_link = route('password.reset',$token.'?email='.$email); 

                //=== mail [start] ===
                $settings = AllFunction::get_setting([
                    'site_url',              
                    'logo',
                    'site_name',  
                    'from_email',
                    'from_email_name',              
                ]); 
                $email_template = Email_templates::find('2')->toArray();             
                $subject        = $email_template['subject'];            
                $body           = $email_template['body'];
                
                $body    = str_replace('{site_url}',$settings['site_url'],$body);
                $body    = str_replace('{logo}',$settings['logo'],$body);
                $body    = str_replace('{site_name}',$settings['site_name'],$body);
                $body    = str_replace('{reset_password_link}',$reset_password_link,$body);   

                AllFunction::mail_with_sendgrid([
                    'name'=>'',
                    'email'=>$email,
                    'from_email_name'=>$settings['from_email_name'],
                    'from_email'=>$settings['from_email'],
                    'subject'=>$subject,
                    'content'=>$body,
                ]);
                //=== mail [ends] ===
                return back()->with(['success'=> 'Please check your mail, your password reset link is sent to your email address.']);
            }
            else{
                return back()->
                withInput(['email'=>$email])->
                with(['error' => "We can't find a user with that email address."]);
            }        
        }
        
    }

    public function reset_password(string $token){    

        if( Auth::check() ){
            return redirect()->route('customer.dashboard');
        }
        
        $meta = [
            'title'=>'Reset password',            
            'description'=>'',
        ];        

        $settings = AllFunction::get_setting(['logo']);      
        $logo     = $settings['logo'];
        $email    = $_GET['email'] ?? ''; 
        $pageData = compact( 'meta', 'logo', 'email', 'token' ); 

        return Inertia::render('frontend/Auth/Reset_password', [            
            'pageData' => $pageData,            
        ]);
         
    }
    public function reset_password_post(Request $request){ 

        $rules = [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
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
        
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function (User $user, string $password){                    
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));     
                    $user->save();  
                    event(new PasswordReset($user));
                }
            );
     
            return $status === Password::PASSWORD_RESET ? 
            redirect()->route('customer.login')->with('success', __($status)) 
            : 
            back()->withErrors(['common_error' => __($status)]);
        }
    }  
    
    public function logout(Request $request){
        Session::flush();  
        Cache::pull('admin_user_data');  
        Cache::pull('admin_settings');      
        Auth::logout();
        return redirect()->route('customer.login');
    }
    
}
