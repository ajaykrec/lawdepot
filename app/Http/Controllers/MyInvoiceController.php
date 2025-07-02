<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\AllFunction; 
use App\Models\Pages;
use App\Models\Customers_membership; 
use App\Models\Orders;
use App\Models\Orders_item;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia; 
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Cache;

class MyInvoiceController extends Controller
{
    use AllFunction; 

    public function index(Request $request){   
        
        $language_id = AllFunction::get_current_language();       

        $q = DB::table('pages');  
        $q = $q->leftJoin('pages_language','pages_language.page_id','=','pages.page_id'); 
        $q = $q->where('pages_language.language_id',$language_id);   
        $q = $q->where('pages.slug','my-invoices'); 
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

        $customer = (Session::has('customer_data')) ? Session::get('customer_data') : []; 
        $customer_id = $customer['customer_id'] ?? ''; 
        $stripe_customer_id = $customer['stripe_customer_id'] ?? ''; 
       
        // https://docs.stripe.com/api/invoices/list       
        $stripe = new \Stripe\StripeClient(env('STRIPE_Secret_key'));
        $results = $stripe->invoices->all([
            'customer' => $stripe_customer_id, // cus_Sa1ZjYyLEHNBkS
            'limit' => 25,
            //'status'=>'', //draft, open, paid, uncollectible, void
            //'starting_after'=>'sub_1RQmbHRu7kEVO5cCP3Z9WAEf', // for next request
            //'ending_before'=>'sub_1RQmbHRu7kEVO5cCP3Z9WAEf' // for previous request
        ]);   
        $results = $results->data ?? [];
        //p($results);       
        
        $pageData = compact('page','meta','header_banner','breadcrumb','results'); 
        return Inertia::render('frontend/pages/my_invoice/My_invoice', [            
            'pageData' => $pageData,            
        ]);
    }    
    
}
