<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\AllFunction; 
use App\Models\Pages;
use App\Models\Document;
use App\Models\Membership;
use App\Models\Orders;
use App\Models\Users_type;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia; 
use Illuminate\Support\Facades\Storage;



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
        
        $customer = (Session::has('customer_data')) ? Session::get('customer_data') : []; 
        $customer_id = $customer['customer_id'] ?? '';          
        

        $order_id = Session::has('order_id') ? Session::get('order_id') : '123456'; 
        if(!$order_id){

            // $table = new Orders;                  
            // $table->identity   = $request['identity'];                          
            // $table->status     = $request['status'];
            // $table->save();
            // $order_id = $table->order_id;  
            // Session::put('order_id', $order_id);             
            
        }
        

        $pageData = compact('page','meta','header_banner','breadcrumb','membership','all_membership','order_id'); 
        
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

        $pageData = compact('page','meta','header_banner','breadcrumb'); 

        MembershipController::callback($request);
        
        return Inertia::render('frontend/pages/checkout/Checkout_success', [            
            'pageData' => $pageData,            
        ]);               
    }

    public function callback(Request $request){  

        $membership_id = Session::has('membership_id') ? Session::get('membership_id') : ''; 
        if($membership_id){

            $membership = Membership::find($membership_id)->toArray(); 
            $membership['specification'] = (array)json_decode($membership['specification']);

            $invoice_sufix  = AllFunction::get_invoice_sufix();
            $invoice_number = AllFunction::get_invoice_number();

            $customer = (Session::has('customer_data')) ? Session::get('customer_data') : []; 
            $customer_id = $customer['customer_id'] ?? ''; 
            
            $ip = AllFunction::get_client_ip();

            $country = AllFunction::get_current_country();         
            $country_id = $country['country_id'] ?? '';
            
            //=== update order table =====
            $tableData = [
                'invoice_sufix'=>$invoice_sufix,
                'invoice_number'=>$invoice_number,
                'customer_id'=>$customer_id,
                'transaction_id'=>'',
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
                'payment_method'=>'Nochex',
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
            $end_date = date('Y-m-d',strtotime('+' . $membership['time_period'] .' '. $membership['time_period_sufix']));        
            $tableData = [
                'customer_id'=>$customer_id,
                'membership_id'=>$membership_id,
                'start_date'=>date('Y-m-d'),  
                'end_date'=>$end_date,
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
                'to_name'=>$customer['name'],
                'to_email'=>$customer['email'],
                'from_email_name'=>$settings['from_email_name'],
                'from_email'=>$settings['from_email'],
                'subject'=>$subject,
                'content'=>$body,
            ]);
            //=== mail to user [ends] ===    
            
            //==== remove session ====
            Session::forget('membership_id'); 
            //=====  

        }
       
    }    
    
}
