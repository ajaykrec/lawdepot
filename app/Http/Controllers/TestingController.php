<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\AllFunction; 
use App\Models\Pages;
use App\Models\Contacts;
use App\Models\Email_templates;

//=== extra ===
use App\Models\Customers_membership;
use App\Models\Membership;
use App\Models\Customers;
use App\Models\Orders;
use App\Models\Country;
//====

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Inertia\Inertia; 

class TestingController extends Controller
{
    use AllFunction; 

    public function index(){          
        
        //=== extra ===
        $q = DB::table('test_callback_url');          
        $q = $q->where('id',6); 
        $data = $q->first(); 
        $data = json_decode(json_encode($data), true); 
        $data = $data['response'] ?? '';
        $data = json_decode($data);
        //======

        $stripe_invoice = $data->id ?? '';
        $stripe_subscription_id = $data->parent->subscription_details->subscription ?? '';
        $amount_paid = $data->amount_paid ?? 0;
        $amount_paid = ($amount_paid/100);
        $stripe_customer_id = $data->customer ?? '';

        $start_date = $data->lines->data[0]->period->start ?? '';
        $start_date = date('Y-m-d', $start_date);
        $end_date = $data->lines->data[0]->period->end ?? '';
        $end_date = date('Y-m-d', $end_date);
        $status = $data->status ?? '';  //paid

        $q = Customers_membership::query();          
        $q = $q->where('stripe_subscription_id',$stripe_subscription_id);    
        $q = $q->with(['membership']);      
        $q = $q->first(); 
        $cus_membership = json_decode(json_encode($q), true); 

        $cus_membership_id = $cus_membership['cus_membership_id'] ?? '';
        $customer_id = $cus_membership['customer_id'] ?? '';
        $membership_id = $cus_membership['membership_id'] ?? '';
        $country_id = $cus_membership['membership']['country_id'] ?? '';

        $invoice_sufix = AllFunction::get_invoice_sufix();
        $invoice_number = AllFunction::get_invoice_number();
        $ip = AllFunction::get_client_ip();

        $customer = Customers::find($customer_id)->toArray();    
        $country = Country::find($country_id)->toArray();   
        
        $membership = Membership::find($membership_id)->toArray(); 
        $code = $membership['code'] ?? '';       
        $trial_period_days = $membership['trial_period_days'] ?? 0;       
        $membership['specification'] = (array)json_decode($membership['specification']);        

        //=== insert order table =====
        $tableData = [
            'invoice_sufix'=>$invoice_sufix,
            'invoice_number'=>$invoice_number,
            'stripe_invoice'=>$stripe_invoice,
            'customer_id'=>$customer_id,
            'transaction_id'=>$stripe_subscription_id,
            'stripe_session_id'=>'',
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
        
        //=== update Customers_membership
        $table = Customers_membership::find($cus_membership_id);
        $table->order_id = $order_id;
        $table->start_date = $start_date;
        $table->end_date = $end_date; 
        $table->status = 1; 
        $table->save(); 

        p('success!!');
              
    }
    
      
}
