<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Email_templates;
use App\Traits\AllFunction;

class LoginController extends Controller
{
    use AllFunction; 

    public function login(Request $request){

        if( Auth::check() ){
         return redirect()->route('dashboard');
        }

        $meta = [
            'title'=>'Login',
            'keywords'=>'',
            'description'=>'',
        ];
        
        $error     = '';
        $post_data = $request->all(); 

        //=== get cookie remember me         
        $cookie_email = Cookie::get('email');
        $cookie_pass  = Cookie::get('password');
        $is_checked   = ( $cookie_email && $cookie_pass ) ? "checked='checked'" : '';

        $action    = $post_data['action'] ?? '';
        $email     = $post_data['email'] ?? $cookie_email;
        $password  = $post_data['password'] ?? $cookie_pass;
        $remember  = $post_data['remember'] ?? ''; 

        $settings = AllFunction::get_setting(['logo']);      
        $logo     = $settings['logo'];
        
        if( $action == 'ok_submit' ){             
            
            //$password = Hash::make('123456'); // $2y$10$mBCoirn5/B7NHUa4CSRl3erqUR9e/ztlOblTvYSgmm0NnOnKyaIeG
            //$password = md5('123456'); // e10adc3949ba59abbe56e057f20f883e

            $is_checked   = ( $remember ) ? "checked='checked'" : '';
            
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if( Auth::attempt([ 'email' => $email, 'password' => $password, 'status'=>'1' ])){
                
                // $id = Auth::id();
                // $user = Auth::user()->toArray();
                // $users_types = Auth::User()->users_types->toArray();
                // p($id);
                // p($user);
                // p($users_types);
                // die;

                Session::put('email', $email);
                
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
                return redirect()->route('dashboard');
            }
            else{
                $error = 'The provided credentials do not match our records.';
            } 
            
        }

        $data = compact( 'meta', 'error', 'email', 'password', 'is_checked','logo' );        
        return view('admin.auth.login')->with($data);        
    }    

    public function forgot_password(){       
        $meta = [
            'title'=>'Forgot password',
            'keywords'=>'',
            'description'=>'',
        ];       
        $settings = AllFunction::get_setting(['logo']);      
        $logo     = $settings['logo'];
        $data     = compact( 'meta','logo' );        
        return view('admin.auth.forgot_password')->with($data);   
    }

    /*
    public function forgot_password_post(Request $request){
        $email = $request->post('email');
        $request->validate(['email' => 'required|email']);
 
        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        return $status === Password::RESET_LINK_SENT ? 
        back()->
        with(['success'=> __($status)]) 
        : 
        back()->
        withInput(['email'=>$email])->
        withErrors(['common_error' => __($status)]);
    }
    */

    public function forgot_password_post(Request $request){
        $email = $request->post('email');
        $request->validate(['email' => 'required|email']);

        $user = User::where('email',$request['email'])->get()->first();
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
            withErrors(['common_error' => "We can't find a user with that email address."]);
        }        
    }
    
    public function reset_password(string $token){       
        $meta = [
            'title'=>'Reset password',
            'keywords'=>'',
            'description'=>'',
        ];
        
        $email = $_GET['email'] ?? ''; 
        $settings = AllFunction::get_setting(['logo']);      
        $logo     = $settings['logo'];
        $data  = compact( 'meta', 'email', 'token','logo' );        
        return view('admin.auth.reset_password')->with($data);   
    }

    public function reset_password_post(Request $request){ 
        
        $post_data = $request->all(); 

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);        
     
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));     
                $user->save();                
     
                event(new PasswordReset($user));
            }
        );
     
        return $status === Password::PASSWORD_RESET ? 
        redirect()->route('login')->with('success', 'Password reset successfully')        
        : 
        back()->withErrors(['common_error' => __($status)]);
    }    
    
    public function logout(Request $request){
        Session::flush();        
        Auth::logout();
        return redirect()->route('login');
    }

    public function notfound(){       
        $meta = [
            'title'=>'404 page not found',
            'keywords'=>'',
            'description'=>'',
        ];       
       
        $data  = compact( 'meta');        
        return view('errors.404')->with($data);   
    }
    
}
