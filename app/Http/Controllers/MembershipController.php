<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\AllFunction; 
use App\Models\Pages;
use App\Models\Document;
use App\Models\Membership;
use App\Models\Customers;
use App\Models\Orders;
use App\Models\Country;
use App\Models\Users_type;
use App\Models\Customers_membership;


use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia; 
use Illuminate\Support\Facades\Storage;
use Redirect;


class MembershipController extends Controller
{
    use AllFunction; 

    public function index(Request $request){  

        $customer = (Session::has('customer_data')) ? Session::get('customer_data') : []; 
        $customer_id = $customer['customer_id'] ?? '';        
        if(!$customer){
            return redirect( route('customer.login') );
        }        

        $customers_membership = Customers_membership::query()
        ->where('customer_id',$customer_id)  
        ->where('status',1)    
        ->where('end_date','>=',date('Y-m-d'))      
        ->with(['membership'])     
        ->orderBy('cus_membership_id','desc')   
        ->get()->toArray(); 
        $cusMembershipID = [];
        foreach($customers_membership as $val){
            $cusMembershipID[] = $val['membership_id'];
        }

        //==== if customer hase '1 Year Pro Subscription' redirect to Dashboard
        if(in_array('1',$cusMembershipID)){
             return redirect( route('customer.account') );
        }
        //======
       
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

            if(!in_array($val['membership_id'],$cusMembershipID)){
                $val['specification'] = (array)json_decode($val['specification']);
                $membership[] = $val;
            }            
        }  
        //P($membership);           

        $pageData = compact('page','meta','header_banner','breadcrumb','membership'); 
        return Inertia::render('frontend/pages/membership/Membership', [            
            'pageData' => $pageData,            
        ]);               
    }  
    
    // public function select_membership(Request $request){  
    //     $membership_id = $request['membership_id'] ?? '';
    //     Session::put('membership_id', $membership_id);  
    //     return redirect( route('membership.checkout') )->with(['success'=>'']);          
    // }    

    public function select_membership(Request $request){  

        $membership_id = $request['membership_id'] ?? '';
        Session::put('membership_id', $membership_id);  
        
        $membership = Membership::find($membership_id)->toArray(); 
        $membership_name = $membership['name'] ?? '';
        $membership_description = $membership['description'] ?? '';
        $membership_price = $membership['price'] ?? 0;
        $time_period = $membership['time_period'] ?? 0;
        $time_period_sufix = $membership['time_period_sufix'] ?? '';
        $trial_period_days = $membership['trial_period_days'] ?? 0;

        $subscription_data = [];
        if($trial_period_days > 0){
            $subscription_data = [
                'trial_period_days' => $trial_period_days,
                'trial_settings' => ['end_behavior' => ['missing_payment_method' => 'cancel']],
            ];
        }

        $currency = AllFunction::get_setting(['currency_code'])['currency_code'] ?? '';

        $customer = (Session::has('customer_data')) ? Session::get('customer_data') : []; 
        $customer_id = $customer['customer_id'] ?? ''; 
        $email = $customer['email'] ?? ''; 
        $stripe_customer_id = $customer['stripe_customer_id'] ?? ''; 

        $country = AllFunction::get_current_country();         
        $country_id = $country['country_id'] ?? '';

        $stripe = new \Stripe\StripeClient(env('STRIPE_Secret_key'));
        $response = $stripe->checkout->sessions->create([           
            'success_url' => route('membership.checkout.success'),
            'line_items' => [
                [
                    'price_data' => [
                        'currency'=>'GBP',
                        'product_data'=>[
                            'name'=>$membership_name,
                            //'description'=>$membership_description
                        ],
                        'currency'=>$currency,
                        'unit_amount'=> $membership_price*100,
                        'recurring'=>[
                            'interval'=>$time_period_sufix,
                            'interval_count'=>$time_period,                            
                        ]
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'subscription',
            'subscription_data' => $subscription_data,
            'customer'=>$stripe_customer_id,
            //'customer_email'=>$email,
            'metadata'=> [
                'membership_id' => $membership_id,
                'customer_id' => $customer_id,
                'country_id'=> $country_id,
            ]
        ]);        
        
        return Inertia::location($response->url);
        
    }    

    public function checkout(Request $request){  

        $membership_id = Session::has('membership_id') ? Session::get('membership_id') : ''; 
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
        
        $customer = (Session::has('customer_data')) ? Session::get('customer_data') : []; 
        $customer_id = $customer['customer_id'] ?? '';  
       
        $stripe_publishable_key = env('STRIPE_Publishable_key');

        $pageData = compact('page','meta','header_banner','breadcrumb','membership','all_membership','stripe_publishable_key'); 
        
        return Inertia::render('frontend/pages/checkout/Checkout', [            
            'pageData' => $pageData,            
        ]);               
    } 
    
    public function success(Request $request){

        $language_id = AllFunction::get_current_language();         
         
        $q = DB::table('pages');  
        $q = $q->leftJoin('pages_language','pages_language.page_id','=','pages.page_id'); 
        $q = $q->where('pages_language.language_id',$language_id);   
        $q = $q->where('pages.slug','checkout-success'); 
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
        
        $document = [];
        $document_id = (Session::has('document_id')) ? Session::get('document_id') : ''; 
        if($document_id){
            $document = Document::find($document_id)->toArray();      
            $template = (Session::has('openai_document')) ? Session::get('openai_document') : '';         
            $document['template'] = $template;        
        }
        //=====  
        $pageData = compact('page','meta','header_banner','breadcrumb','document_id','document'); 
        return Inertia::render('frontend/pages/checkout/Checkout_success', [            
            'pageData' => $pageData,            
        ]);               
    }  
       

    public function callback(Request $request){
        //\Stripe\Stripe::setApiKey(env('STRIPE_Secret_key'));
        $endpoint_secret = env('STRIPE_Endpoint_Secret_key');
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try{
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        }catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        }catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

        if( $event->type == 'checkout.session.completed' || $event->type == 'checkout.session.async_payment_succeeded' ){
            $session_id = $event->data->object->id;
            MembershipController::fulfill_checkout($session_id);
        }
        http_response_code(200);        
    }
    public function fulfill_checkout($session_id){
        
        $stripe = new \Stripe\StripeClient(env('STRIPE_Secret_key'));
        $checkout_session = $stripe->checkout->sessions->retrieve($session_id, [
            'expand' => ['line_items'],
        ]);     

        if($checkout_session->payment_status != 'unpaid'){
            // $table = new Users_type;
            // $table->user_type  = 'callback';            
            // $table->modules    = $checkout_session;   
            // $table->save();  
            MembershipController::save_order_data($checkout_session);
        }
    }
    public function save_order_data($data){  

        $transaction_id = $data->id ?? '';
        $invoice = $data->invoice ?? '';
        $country_id = $data->metadata->country_id ?? '';
        $customer_id = $data->metadata->customer_id ?? '';
        $membership_id = $data->metadata->membership_id ?? '';       
        
        if($membership_id){            

            $invoice_sufix = AllFunction::get_invoice_sufix();
            $invoice_number = AllFunction::get_invoice_number();
            $ip = AllFunction::get_client_ip();

            $customer = Customers::find($customer_id)->toArray();    
            $country = Country::find($country_id)->toArray();   
            
            $membership = Membership::find($membership_id)->toArray(); 
            $trial_period_days = $membership['trial_period_days'] ?? 0;       
            $membership['specification'] = (array)json_decode($membership['specification']);        
            
            //=== insert order table =====
            $tableData = [
                'invoice_sufix'=>$invoice_sufix,
                'invoice_number'=>$invoice_number,
                'stripe_invoice'=>$invoice,
                'customer_id'=>$customer_id,
                'transaction_id'=>$transaction_id,
                'name'=>$customer['name'] ?? '',
                'email'=>$customer['email'] ?? '',
                'phone'=>$customer['phone'] ?? '',

                'billing_name'=> '',
                'billing_address'=> '',
                'billing_country_id'=>$country_id ?? '',
                'billing_country'=>$country['name'] ?? '',
                'billing_zone_id'=>'0',
                'billing_zone'=>'',
                'billing_city'=>'',
                'billing_postcode'=>'',                    
                'shipping_name'=> '',
                'shipping_address'=> '',
                'shipping_country_id'=>$country_id ?? '',
                'shipping_country'=>$country['name'] ?? '',
                'shipping_zone_id'=>'0',
                'shipping_zone'=>'',
                'shipping_city'=>'',
                'shipping_postcode'=>'',                      
                'comment'=>'',             
                'payment_method'=>'Stripe',
                'shipping_method'=>'',
                'ip'=>$ip,
                'currency_code'=>$country['currency_code'] ?? '',
                'total'=>$membership['price'] ?? '0.00',
                'sub_total'=>$membership['price'] ?? '0.00',
                
                'discount'=>0.00,
                'tax'=>0.00,
                'delivery_charge'=>0.00,
                'commission'=>0.00,

                'order_status'=>'1',
                'payment_status'=>'1',
                'delivery_status'=>'2',  
                'created_at'=>date('Y-m-d H:i:s'),  
                'updated_at'=>date('Y-m-d H:i:s'),   
            ];        
            $order_id = DB::table('orders')->insertGetId($tableData);
            $tableData = [
                'order_id'=>$order_id,
                'customer_id'=>$customer_id,
                'item_id'=>$membership_id,
                'item_name'=>$membership['name'] ?? '',
                'item_type'=>'0',
                'image'=>'',
                'options'=>'',
                'currency_code'=>$country['currency_code'] ?? '',
                'price'=>$membership['price'] ?? '0.00',
                'quantity'=>1,
                'created_at'=>date('Y-m-d H:i:s'),  
                'updated_at'=>date('Y-m-d H:i:s'),   
            ];        
            DB::table('orders_items')->insert($tableData);

            //=== update customers_membership table =====
            $end_date = date('Y-m-d',strtotime('+ ' . $membership['time_period'] .' '. $membership['time_period_sufix']));   
            if($trial_period_days > 0){
                $end_date = date('Y-m-d', strtotime('+ ' . $trial_period_days .' day', strtotime($end_date))  );   
            }     
            $tableData = [
                'customer_id'=>$customer_id,
                'membership_id'=>$membership_id,
                'order_id'=>$order_id,
                'start_date'=>date('Y-m-d'),  
                'end_date'=>$end_date,
                'document_id'=>0,
                'status'=>1,
                'created_at'=>date('Y-m-d H:i:s'),  
                'updated_at'=>date('Y-m-d H:i:s'),   
            ];        
            DB::table('customers_membership')->insert($tableData);           

            //=== mail to user [start] ===            
            $settings = AllFunction::get_setting([
                'site_url',              
                'logo',
                'site_name',  
                'from_email',
                'from_email_name',   
                'contact_phone',
                'contact_email',
                'contact_address',           
            ]);                 
            $subject          = 'New order from '.$settings['site_name']; 
            $data             = Orders::with('orderitems')->find($order_id)->toArray();  
            $data['setting']  = $settings;
            $data['show_tag'] = '';

            $data             = compact('data');
            $body             = view('mail.order')->with($data)->render(); 
            AllFunction::send_mail([
                'name'=>$customer['name'],
                'email'=>$customer['email'],
                'from_email_name'=>$settings['from_email_name'],
                'from_email'=>$settings['from_email'],
                'subject'=>$subject,
                'content'=>$body,
            ]);           
            //=== mail to user [ends] ===              
        }            
    }  
    
}
