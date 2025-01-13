<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\AllFunction; 
use App\Models\Pages;
use App\Models\Contacts;
use App\Models\Email_templates;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Inertia\Inertia; 

class ContactController extends Controller
{
    use AllFunction; 

    public function index(){

        $common = AllFunction::get_common_data();
        $page   = Pages::select('page_id','slug','name','content','meta_title','meta_keyword','meta_description')->where('page_id','5')->first()->toArray();
        
        $meta = [
            'title'=>$page['meta_title'] ?? '',
            'keywords'=>$page['meta_keyword'] ?? '',
            'description'=>$page['meta_description'] ?? '',
        ];
        
        $pageData = compact('common','page','meta'); 

        return Inertia::render('frontend/contact/Contact', [            
            'pageData' => $pageData,            
        ]);
       
    }
    
    public function post_contact(Request $request){

        $rules = [
            'name'      => 'required',
            'email'     => 'required|email', 
            'phone'     => 'required',
            'message'   => 'required',            
        ];
        $messages = [];
        $validation = Validator::make( 
            $request->toArray(), 
            $rules, 
            $messages
        );        
        if($validation->fails()){   
            echo json_encode(
                array(
                'status'  => 'error',                 
                'message' => $validation->messages()->toArray(),							
            ));		
            exit;
        }
        else{           
            // store
            $table = new Contacts;
            $table->name            = $request['name'] ?? '';           
            $table->email           = $request['email'] ?? '';
            $table->phone           = $request['phone'] ?? '';   
            $table->message         = $request['message'] ?? '';                 
            $table->status          = $request['status'] ?? 0;
            $table->save();

            //=== mail [start] ===
            $common = AllFunction::get_common_data();
            
            $email_template = Email_templates::find('1')->toArray();             
            $subject        = $email_template['subject'];            
            $body           = $email_template['body'];
            
            $body    = str_replace('{site_url}',$common['settings']['site_url'],$body);
            $body    = str_replace('{logo}',$common['settings']['logo'],$body);
            $body    = str_replace('{site_name}',$common['settings']['site_name'],$body);
            $body    = str_replace('{name}',$request['name'],$body);
            $body    = str_replace('{email}',$request['email'],$body);
            $body    = str_replace('{phone}',$request['phone'],$body);
            $body    = str_replace('{message}',$request['message'],$body);
            
            AllFunction::mail_with_sendgrid([
                'name'=>$request['name'],
                'email'=>$request['email'],
                'from_email_name'=>$common['settings']['from_email_name'],
                'from_email'=>$common['settings']['from_email'],
                'subject'=>$subject,
                'content'=>$body,
            ]);
            //=== mail [ends] ===

            return redirect( route('contact') )->with(['success'=>'We received your information. We will get back to you soon.']);
        }        
    }
    public function reloadCaptcha()    {
        return response()->json(['captcha'=> captcha_img()]);        
    }    
}
