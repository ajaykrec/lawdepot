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

class MyMembershipController extends Controller
{
    use AllFunction; 

    public function index(Request $request){   
        
        $language_id = AllFunction::get_current_language();       

        $q = DB::table('pages');  
        $q = $q->leftJoin('pages_language','pages_language.page_id','=','pages.page_id'); 
        $q = $q->where('pages_language.language_id',$language_id);   
        $q = $q->where('pages.slug','my-membership'); 
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

        //=== membership list
        $filterArr            = [];
        $filterArr['status']  = $request['status'] ?? ''; 
        
        $pagi_url = route('customer.membership').'?';
        if($filterArr){
            $count = 0;
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    $count++;
                    if($count == 1){
                        $pagi_url.=$key.'='.$val;
                    }
                    else{
                        $pagi_url.='&'.$key.'='.$val;
                    }      
                }       
            }
        }

        $limit  = AllFunction::admin_limit();
        $page   = $request['_p'] ?? 1;
        $offset = ($page - 1)*$limit;
        $start_count  = ($page * $limit - $limit + 1);

        $q = Customers_membership::query();
        $q = $q->where('customer_id',$customer_id);         
        if($filterArr){
            foreach($filterArr as $key=>$val){
                if($val!=''){
                    if($key == 'status'){
                        $q->where('status',$val);
                    }
                }
            }
        }            
        $q->with(['membership']); 
        $q->orderBy('cus_membership_id','desc'); 
        $count = $q->count();     
        $results  = $q->limit($limit)->offset($offset)->get()->toArray(); 
        $results  = json_decode(json_encode($results), true); 
        $returnArr = [];
        if($results){
            foreach($results as $val){
                $order = Orders::query()->where('order_id',$val['order_id'])->with(['orderitems'])->get()->toArray(); 
                $val['order'] = $order[0];
                $returnArr[] = $val;
            }
        }
        $results  = $returnArr;
        $paginate = AllFunction::paginate($count, $limit, $page, 3, $pagi_url);        
        //=====
        
        $pageData = compact('page','meta','header_banner','breadcrumb','results','paginate','start_count'); 
        return Inertia::render('frontend/pages/my_membership/My_membership', [            
            'pageData' => $pageData,            
        ]);
    }

    
    public function cancel_membership($cus_membership_id, Request $request){   

        $cus_membership = Customers_membership::where('cus_membership_id',$cus_membership_id)->first()->toArray();  
        $stripe_subscription_id = $cus_membership['stripe_subscription_id'] ?? '';        
        
        $stripe = new \Stripe\StripeClient(env('STRIPE_Secret_key'));
        $response = $stripe->subscriptions->cancel($stripe_subscription_id, []);

        //p($response); 
        if($response->status == 'canceled'){

            $table = Customers_membership::find($cus_membership_id);
            $table->status = 3; 
            $table->save(); 

            return redirect( route('customer.membership') )->with(['success'=>'Subscription has been Canceled successfully']);
        }
        
    }
    
}
