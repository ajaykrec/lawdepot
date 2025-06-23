<?php
namespace App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

//=== for image resize : composer require intervention/image
// use "intervention/image": "^2.7" in composer.json "require"
// run comand : composer update
// use Intervention\Image\Facades\Image as ResizeImage;
use Intervention\Image\Facades\Image as ResizeImage;

use App\Models\Settings;
use App\Models\Language;
use App\Models\Country;

use App\Models\Document_category;
use App\Models\Document;
use App\Models\Documents_step;
use App\Models\Documents_question; 
use App\Models\Customers_document;
use App\Models\Customers_guest_document;
use App\Models\Documents_question_option;
use App\Models\Orders;
use App\Models\Customers_membership;

//==== Mail ====
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;

//==== PHPMailer ====
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Parsedown;
//composer require erusev/parsedown

trait AllFunction {  
    
      static function construct_value($index){
        $inFieldGroup = ['text','textarea','dropdown','date']; 
        $blankVal = [
            'radio'         =>'_________________________',
            'radio_group'   =>'_________________________',
            'checkbox'      =>'_________________________',
            'dropdown'      =>'_________________________',
            'text'          =>'________________________________________________________',
            'textarea'      =>'_____________________________________________________________________',            
            'date'          =>'_________________________'
        ]; 

        $data = compact('inFieldGroup','blankVal');  
        return $data[$index] ?? '';
      }

      static function admin_limit($number=0){
        return $number ? $number : 25;
      }

      static function limit($number=0){
        return $number ? $number : 25;
      }

      static function get_invoice_sufix() {
        $max = Orders::max('invoice_sufix');         	
        return $max + 1;
      }	
      static function get_invoice_number(){		
        $invoice_prefix = 'INST1000'; 
        $invoice_sufix  = AllFunction::get_invoice_sufix();		
        $invoice_number = $invoice_prefix.$invoice_sufix;		
        return $invoice_number;	
      }
      static function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

      static function paginate($total_items, $item_per_page, $current_page, $adjacents, $url = NULL){

        if ($url === NULL) {
            $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        }        
		
        $total_pages = $total_items;
        $limit       = $item_per_page; 
        $page        = $current_page; 		
        
        if ($page == 0){
            $page = 1; 
        }
        $prev       = $page - 1; 
        $next       = $page + 1; 
        $lastpage   = ceil($total_pages / $limit); 
        $lpm1       = $lastpage - 1;         
			
        $pagination = "";

        if ($lastpage > 1) {
            $pagination .= '<ul class="pagination">';
            if ($page > 1) {                
                $pagination .= '<li class="page-item"><a href="'.$url.'&_p='.$prev.'" class="page-link">&laquo;</a></li>';                
            } else {
                $pagination .= '<li class="page-item disabled"><a href="javascript:void(0)" class="page-link">&laquo;</a></li>';
               
            }            
            if ($lastpage < 7 + ($adjacents * 2)) { 
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination .= '<li class="page-item active"><a href="'.$url.'&_p='.$counter.'" class="page-link">'.$counter.'</a></li>';                    
                    else
                        $pagination .= '<li class="page-item"><a href="'.$url.'&_p='.$counter.'" class="page-link" >'.$counter.'</a></li>';
                }
            } elseif ($lastpage > 5 + ($adjacents * 2)) { 
               
                if ($page <= 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page)
                            $pagination .= '<li class="page-item active"><a href="'.$url.'&_p='.$counter.'" class="page-link">'.$counter.'</a></li>';
                        else
                            $pagination .= '<li class="page-item"><a href="'.$url.'&_p='.$counter.'" class="page-link">'.$counter.'</a></li>';                        
                    }
                    $pagination .= '<li class="page-item"><a href="javascript:void(0)" class="page-link">...</a></li>';
                    $pagination .= '<li class="page-item"><a href="'.$url.'&_p='.$lpm1.'" class="page-link">'.$lpm1.'</a></li>';
                    $pagination .= '<li class="page-item"><a href="'.$url.'&_p='.$lastpage.'" class="page-link">'.$lastpage.'</a></li>';
                }
                elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $pagination .= '<li class="page-item"><a href="'.$url.'&_p=1" class="page-link">1</a></li>';                   
                    $pagination .= '<li class="page-item"><a href="'.$url.'&_p=2" class="page-link">2</a></li>';
                    $pagination .= '<li class="page-item"><a href="javascript:void(0)" class="page-link">...</a></li>';
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $pagination .= '<li class="page-item active"><a href="'.$url.'&_p='.$counter.'" class="page-link">'.$counter.'</a></li>';
                       
                        else
                            $pagination .= '<li class="page-item"><a href="'.$url.'&_p='.$counter.'" class="page-link">'.$counter.'</a></li>';
                        
                    }
                    $pagination .= '<li class="page-item"><a href="javascript:void(0)" class="page-link">...</a></li>';
                    $pagination .= '<li class="page-item"><a href="'.$url.'&_p='.$lpm1.'" class="page-link">'.$lpm1.'</a></li>';
                    $pagination .= '<li class="page-item"><a href="'.$url.'&_p='.$lastpage.'" class="page-link">'.$lastpage.'</a></li>';
                   
                }
                else {
                    $pagination .= '<li class="page-item"><a href="'.$url.'&_p=1" class="page-link">1</a></li>';
                    $pagination .= '<li class="page-item"><a href="'.$url.'&_p=2" class="page-link">2</a></li>';
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page)
                            $pagination .= '<li class="page-item active"><a href="'.$url.'&_p='.$counter.'" class="page-link">'.$counter.'</a></li>';
                       
                        else
                            $pagination .= '<li class="page-item"><a href="'.$url.'&_p='.$counter.'" class="page-link">'.$counter.'</a></li>';
                        
                    }
                }
            }
            //next button
            if ($page < $counter - 1) {
                $pagination .= '<li class="page-item"><a href="'.$url.'&_p='.$next.'" class="page-link">&raquo;</a></li>';
               
            } else {
                $pagination .= '<li class="page-item disabled"><a href="javascript:void(0)" class="page-link">&raquo;</a></li>';
                
            }
            $pagination .= "</ul>";
			
			$pagination_row = $pagination;	

            $start_text   = ($total_pages) ? (($page - 1) * $limit) + 1 : 0;
            $end_text     = ((($page - 1) * $limit) > ($total_pages - $limit)) ? $total_pages : ((($page - 1) * $limit) + $limit);
            $display_text = 'Showing ' . $start_text . ' to ' . $end_text . ' of <b>' . $total_pages . '</b> results';			
			$text_row     = $display_text;	

            $pagination = '<div class="py-2 px-3">'.$text_row.'</div><div>'.$pagination_row.'</div>';
        }		
       return $pagination;
    }
    static function is_json_data($data){
        if(!empty($data)){
            @json_decode($data);
            return (json_last_error() === JSON_ERROR_NONE);
        }
        return false;
    }
    static function get_setting($keyArray){
        $result = Settings::select('field_type','key','value')->whereIn('key',$keyArray)->get()->toArray();           
        $data   = [];
        if($result){
            foreach($result as $val){

                if($val['field_type'] == 'Image'){                    
                    $imgPath = 'uploads/settings/'.$val['value'];
                    if( Storage::disk('public')->exists($imgPath) && $val['value']!='' ){
                        $val2 = env('FILE_STORAGE_URL').'/'.$imgPath;
                    } 
                    else{
                        $val2 = '';
                    }
                }
                else if($val['field_type'] == 'File'){
                    $val2 = $val['value'];
                }
                else{
                    $val2 = $val['value'];
                } 
                $data[$val['key']] = $val2; 
            }
        }
        return $data;        
    }
    
    static function get_social_media(){

        $social_media               = [];
        $social_media['twitter']    = ['name'=>'twitter','icon'=>'bi bi-twitter'];
        $social_media['facebook']   = ['name'=>'facebook','icon'=>'bi bi-facebook'];
        $social_media['instagram']  = ['name'=>'instagram','icon'=>'bi bi-instagram'];
        $social_media['linkedin']   = ['name'=>'linkedin','icon'=>'bi bi-linkedin']; 
        return $social_media;
        
    }
 
    static function upload_image($data){        
        $file               = $data['file'] ?? '';
        $destination_path   = $data['destination_path'] ?? '';        
        $width              = $data['width'] ?? '';
        $height             = $data['height'] ?? '';

        //Display File Name
        $file_name = str_replace(' ', '-', microtime()) . '-vs-' . $file->getClientOriginalName();  
        //Display File Extension
        $file_extension = $file->getClientOriginalExtension();   
        
        //Display File Real Path       
        $file_real_path = $file->getRealPath();
        //Display File Size
        $file_size = $file->getSize();   
        //Display File Mime Type
        $file_mime_type = $file->getMimeType(); 

        if( $file_mime_type == 'image/svg+xml' ){
            $file->storeAs($destination_path,$file_name);
        }        
        else if($width && $height){

            $destination_path   = storage_path('app/public/'.$destination_path);
            if( !is_dir($destination_path) ){
                mkdir($destination_path, 0777, true);
            }    
            else{
                chmod($destination_path,0777);
            }                  

            ResizeImage::make($file)
            ->resize($width,$height, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($destination_path .'/'. $file_name);           
        }
        else{
            //Move Uploaded File       
            $file->storeAs($destination_path,$file_name);
        }
        return $file_name;
       
     }    
    
     static function upload_file($data) {        
        $file               = $data['file'] ?? '';
        $destination_path   = $data['destination_path'] ?? '';   
        //Display File Name
        $file_name = microtime(). '-' .$file->getClientOriginalName();       
     
        //Display File Extension
        $file_extension = $file->getClientOriginalExtension();        
     
        //Display File Real Path       
        $file_real_path = $file->getRealPath();
     
        //Display File Size
        $file_size = $file->getSize();       
     
        //Display File Mime Type
        $file_mime_type = $file->getMimeType();  
        
        //Move Uploaded File       
        $file->storeAs($destination_path,$file_name);
        return $file_name;
       
     }
     static function delete_file($data) {
        $table          = $data['table'] ?? '';
        $table_id       = $data['table_id'] ?? '';
        $table_id_value = $data['table_id_value'] ?? '';
        $table_field    = $data['table_field'] ?? '';
        $file_name      = $data['file_name'] ?? '';
        $file_path      = $data['file_path'] ?? '';
        $file_full_path = $file_path.'/'.$file_name;

        //=== delete file
        if(Storage::disk('public')->exists($file_full_path)){ 
            Storage::delete($file_full_path);     
        }        
        //=== update table
        if($table && $table_id && $table_id_value && $table_field){ 
            $tableRow = DB::table($table)->where($table_id, '=', $table_id_value)->get();
            if($tableRow){
                $affected = DB::table($table)
                ->where($table_id, $table_id_value)
                ->update([$table_field => '']);         
            }          
        }
     }
    static function send_mail($data){  
        //AllFunction::mail_with_sendgrid($data);	
        //AllFunction::mail_with_smtp($data);	
        AllFunction::mail_with_PHPMailer($data);	
    }
    static function mail_with_PHPMailer($data){  

        require public_path('phpmailer/phpmailer/src/Exception.php');
        require public_path('phpmailer/phpmailer/src/PHPMailer.php');
        require public_path('phpmailer/phpmailer/src/SMTP.php');
       

        $email              = isset($data['email']) ? $data['email'] : '';  
        $name               = isset($data['name']) ? $data['name'] : '';     
        $from_email         = isset($data['from_email']) ? $data['from_email'] : '';     
        $from_email_name    = isset($data['from_email_name']) ? $data['from_email_name'] : '';
        $subject            = isset($data['subject']) ? $data['subject'] : '';        
        $content            = isset($data['content']) ? $data['content'] : '';

        $mail = new PHPMailer;
        try {           
            //$mail->SMTPDebug = 2; //SMTP::DEBUG_SERVER;                
            //$mail->isSMTP();                                      
            $mail->Host       = env('MAIL_HOST');    
            $mail->SMTPAuth   = true;   
            $mail->Username   = env('MAIL_USERNAME');            
            $mail->Password   = env('MAIL_PASSWORD');            
            $mail->SMTPSecure = env('MAIL_ENCRYPTION');    
            $mail->Port       = env('MAIL_PORT'); // 465, 587;  

            // $mail->SMTPOptions = array(
            //     'ssl' => array(
            //         'verify_peer' => false,
            //         'verify_peer_name' => false,
            //         'allow_self_signed' => true
            //     )
            // );
           
            //$mail->setFrom($from_email, $from_email_name);
            $mail->From = 'info@instantly.legal';
            $mail->FromName = 'instantly.legal';

            $mail->addAddress($email, $name);   
            //$mail->addAddress('ellen@example.com'); //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');
        
            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');   
        
            //Content
            $mail->WordWrap = 50;    
            $mail->CharSet = 'UTF-8';                  
            $mail->isHTML(true);                                 
            $mail->Subject = $subject;
            $mail->Body    = $content;
            $mail->AltBody = '';     
            
            if(!$mail->send()){
                //echo 'Message could not be sent';   
            }else{
                //echo "Mail has been sent to your e-mail address";
            }           
        }
        catch(Exception $e){
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    static function mail_with_smtp($data){  

        $email              = isset($data['email']) ? $data['email'] : '';  
        $name               = isset($data['name']) ? $data['name'] : '';     
        $from_email         = isset($data['from_email']) ? $data['from_email'] : '';     
        $from_email_name    = isset($data['from_email_name']) ? $data['from_email_name'] : '';
        $subject            = isset($data['subject']) ? $data['subject'] : '';        
        $content            = isset($data['content']) ? $data['content'] : '';

        Mail::to($email)->send(new TestEmail([
            'subject'=>$subject,
            'content'=>$content,
        ]));

    }
    static function mail_with_sendgrid($data){  
        
        $email      = isset($data['email']) ? $data['email'] : '';  
        $name       = isset($data['name']) ? $data['name'] : '';     
        $from_email = isset($data['from_email']) ? $data['from_email'] : '';     
        $from_email_name  = isset($data['from_email_name']) ? $data['from_email_name'] : '';
        $subject    = isset($data['subject']) ? $data['subject'] : '';        
        $content    = isset($data['content']) ? $data['content'] : '';     

        $url = 'https://api.sendgrid.com/v3/mail/send';        
        $ch  = curl_init($url);

        // Setup request to send json via POST        
        $array_data = array(
            'personalizations' => [[
                'to'=> array(
                    ['name'=>$name,'email'=>$email]            
                )
            ]],
            'from' => ['name'=>$from_email_name,'email'=>$from_email],
            'subject' => $subject,
            'content' => [['type'=>'text/html','value'=>$content]]
        );
        //$payload = json_encode($array_data,JSON_UNESCAPED_SLASHES);
        $payload = json_encode($array_data);
        // Attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        // Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            'Authorization: Bearer '.env('SENDGRID_API_KEY').''
        ));

        // Return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the POST request
        $result = curl_exec($ch);

        // Close cURL resource
        curl_close($ch);
    }

    static function replace_null($array) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = AllFunction::replace_null($value);
            } else {
                if (is_null($value)) {
                    $array[$key] = "";
                }
            }
        }
        return $array;
    }
    static function get_customer_data(){         
        $data = '';
        if(Session::has('customer_data')){           
            $data = Session::get('customer_data');           
        }
        return $data;
    }
    static function get_active_membership(){  

        $customer = (Session::has('customer_data')) ? Session::get('customer_data') : []; 
        $customer_id = $customer['customer_id'] ?? '';        
        
        $data = Customers_membership::query()
        ->where('customer_id',$customer_id)  
        ->whereIn('status',[1,3])    
        ->where('end_date','>=',date('Y-m-d'))      
        ->with(['membership'])     
        ->orderBy('membership_id','asc')   
        ->get()->toArray(); 
        $data = $data[0] ?? [];

        if($data){
            $membership = $data['membership'] ?? [];
            if( $membership['is_per_document'] == 1 ){
                $count = DB::table('customers_document')
                ->where('customer_id',$customer_id) 
                ->where('created_at','>=',$data['start_date'])        
                ->count();  
                
                return ($count > 0) ? false : true;
                
            }
            else{
                return true;
            }
            
        }
        else{
            return false;
        }        
    }
    static function get_common_data(){ 
        Cache::pull('data');
        if(Cache::has('data')){
            $data = Cache::get('data');
        }
        else{
            $settings = AllFunction::get_setting([
                'logo',    
                'header_top_text',          
                'contact_address',
                'contact_email',
                'contact_phone',
                'copyrights',
                'designed_by',

                'facebook_url',
                'linkedIn_url',
                'twitter_url',
                'instagram_url',              
                'pinterest_url',  

                'domain',
                'site_name',
                'site_url',
                'timing',  
                
                'from_email',
                'from_email_name',
                'to_email',
                'to_email_name',                
                
                'footer_logo',
                'footer_about_us_text',                 
                       
            ]);  

            $country = AllFunction::get_current_country(); 
            $country_id = $country['country_id'] ?? '';
            
            $countries = DB::table('country')->where('country_id','!=',$country_id)->where('status',1)->orderBy("default","desc")->orderBy("name","asc")->get()->toArray(); 
            $countries = json_decode(json_encode($countries), true); 

            $categories = Document_category::select('category_id','name','slug')
            ->where('country_id',$country_id)
            ->where('status',1)
            //->with(['document'])
            ->with([
                'document' => function($q){
                    $q->where('status', '=', 1);
                    $q->orderBy('sort_order','asc');
                    $q->limit(5);
                }
            ])
            ->orderBy('sort_order','asc')           
            ->get()->toArray();   

            $data  = compact('settings','country','countries','categories'); 

            //== put data into cache
            Cache::put('data', $data, now()->addMinutes(15)); 

            //== get data from cache
            //Cache::get('data');

            //== remove data from cache
            //Cache::pull('data');
        }
        return $data;
    }

    //=== set language ====
    static function get_current_country(){  
        if( Session::has('country') ){  
            $country = Session::get('country');
        }
        else{           
            $country = Country::select('*')->where('default',1)->first()->toArray();              
            Session::put('country', $country);            
        }  
        return $country;
    }   
    static function get_current_language(){  
        $country = AllFunction::get_current_country(); 
        $language_id = $country['language_id'] ?? '';
        return $language_id;
    } 
    static function set_country($code){ 
        $country = Country::select('*')->where('code',$code)->where('status',1)->first();   
        if($country){
            $country = $country->toArray();   
            Session::put('country', $country);
            return true;            
        } 
        return false;              
    }  
    static function set_language($language='de'){         
        Session::put('language', $language);
        // note: set language in 'SetLang' custome middleware and call middleware in each router
        // in view : {{ __('auth.throttle') }}
    }
    static function default_language_id(){         
        $row = Language::select('*')->where('default',1)->first()->toArray();
        return $row['language_id'] ?? 1;
    }   
    static function get_languages(){         
        $results = DB::table('language')->where('status',1)->orderBy("sort_order", "asc")->get()->toArray(); 
        $results = json_decode(json_encode($results), true); 
        return $results;
    }   
    static function default_country_id(){         
        $row = Country::select('*')->where('default',1)->first()->toArray();
        return $row['country_id'] ?? 0;
    }   
    static function get_countries(){         
        $results = DB::table('country')->where('status',1)->orderBy("default","desc")->orderBy("name","asc")->get()->toArray(); 
        $results = json_decode(json_encode($results), true); 
        return $results;
    }      
    static function get_questions_breadcrumb($data){ 
        $breadcrumb  = $data['breadcrumb'] ?? [];
        $text        = $data['text'] ?? '';   
        $position    = $data['position'] ?? '';    
        $option_id   = $data['option_id'] ?? '';
        $question_id = $data['question_id'] ?? '';   
        $step_id     = $data['step_id'] ?? '';           

        if($option_id){  
            
            $row = Documents_question_option::query()->where('option_id',$option_id)    
            ->with(['questions'])        
            ->first()->toArray(); 
            
            if($position !='edit'){
                $breadcrumb[] = [
                    'name'=>$row['title'],
                    'url'=>route('questions.index').'?option_id='.$option_id
                ];     
            }
           
            $breadcrumb = AllFunction::get_questions_breadcrumb([
                'step_id'=>'',
                'question_id'=>$row['question_id'] ?? '',
                'option_id'=>'',
                'text'=>$text ?? 'Question',
                'breadcrumb'=> $breadcrumb]
            );

        }
        elseif($question_id){
            
            $row = Documents_question::query()->where('question_id',$question_id)  
            ->with(['option'])                  
            ->first()->toArray(); 

            $step_id = $row['step_id'] ?? '';
            $option_id = $row['option_id'] ?? '';

            $breadcrumb[] = [
                'name'=>$row['question'],
                'url'=>route('document.options.index',$question_id)
            ];  
            
            if($option_id){
                $breadcrumb = AllFunction::get_questions_breadcrumb([
                    'step_id'=>'',
                    'question_id'=>'',
                    'option_id'=>$option_id,
                    'text'=>$text ?? 'Options',
                    'breadcrumb'=> $breadcrumb]
                );
            }
            else{
                $breadcrumb = AllFunction::get_questions_breadcrumb([
                    'step_id'=>$step_id,
                    'question_id'=>'',
                    'option_id'=>'',
                    'text'=>$text ?? 'Options',
                    'breadcrumb'=> $breadcrumb]
                );
            }            
            
        }
        else{
            $row = Documents_step::query()->where('step_id',$step_id)
            ->with(['document'])
            ->first()->toArray(); 

            $breadcrumb[] = [
                'name'=>$row['name'],
                'url'=>route('questions.index').'?step_id='.$step_id
            ];
            $breadcrumb[] = [
                'name'=>$row['document']['name'],
                'url'=>route('document.steps.index',$row['document_id'])
            ];     
            
            $breadcrumb[] = [
                'name'=>'Document',
                'url'=>route('document.index')
            ];

            $breadcrumb[] = [
                'name'=>'Home',
                'url'=>route('dashboard')
            ];

            if($text){
                $breadcrumb[-1] = [
                    'name'=>$text,
                    'url'=>''
                ]; 
            }            
        }  
        krsort($breadcrumb);       
        //p($breadcrumb);        
        return $breadcrumb;
    }  

    //==========
    // documents
    //==========  
    static function show_add_another($step_id){         
        return $step_id ? true : false;
    }
    static function get_add_another_max($question_id){ 
        $return_value = 0;
        $q_row = Documents_question::find($question_id); 
        if($q_row){
            $option_id = $q_row->option_id; 
            if($q_row->is_add_another == 1){
                $return_value = ($q_row->add_another_max > 0) ? $q_row->add_another_max : 1;
            }
            elseif($option_id > 0){
                $o_row = Documents_question_option::find($option_id); 
                $return_value = AllFunction::get_add_another_max($o_row->question_id);
            }                
            else{
                $return_value = 0;
            }
        }    
        else{
            $return_value = 0;
        }
        //p($return_value);
        return $return_value;
    }    
    static function generate_field_name($question_id){ 
        return 'q'.$question_id;
    }  
    static function get_questions($data){  
        $questions = [];
        $option_id = $data['option_id'] ?? ''; 

        $result = DB::table('documents_question')->select('*')
        ->where('option_id',$option_id)
        ->orderBy('sort_order','asc')
        ->orderBy('label','desc')
        ->get()->toArray(); 
        $result = json_decode(json_encode($result), true);
        foreach($result as $val){
            $val['options'] = AllFunction::get_options([
                'question_id'=>$val['question_id'],  
            ]);
            $questions[$val['question_id']] = $val;
        }
        $questions = array_values($questions);
        return $questions;
    }  
    static function get_options($data){  
        $options = [];
        $question_id = $data['question_id'] ?? ''; 

        $result = DB::table('documents_question_option')->select('*')->where('question_id',$question_id)->orderBy('option_id','asc')->get()->toArray(); 
        $result = json_decode(json_encode($result), true);
        foreach($result as $val){
            $is_table_value = $val['is_table_value'] ?? '';
            if($is_table_value == 1){
                $table       = $val['value'] ?? '';                
                $document_id = $val['document_id'] ?? '';
                $country     = Document::find($document_id)->toArray(); 
                $country_id  = $country['country_id'] ?? '';
                $table_result= DB::table($table)->select('zone_id as id','zone_name as title','zone_name as value')->where('country_id',$country_id)->where('status','1')->orderBy('zone_name','asc')->get()->toArray(); 
                $table_result= json_decode(json_encode($table_result), true);
                foreach($table_result as $tval){
                    $options[$tval['id']] = $tval;
                }   
            }
            else{
                $val['questions'] = AllFunction::get_questions([
                    'option_id'=>$val['option_id'],  
                ]);
                $val['quick_info'] = trim($val['quick_info']);
                $options[$val['option_id']] = $val;
            }
            
        }
        $options = array_values($options);
        return $options;
    }  
    static function get_document_fields($array, $key) {
        $results = [];        
        if( is_array($array) ){            
            if ( isset($array[$key]) ) {
                $results[$array[$key]] = '';
            }
            foreach ($array as $subarray) {
                $results = array_merge($results,
                AllFunction::get_document_fields($subarray, $key));
            }
        }    
        return $results;
    }
    static function get_next_previous_url($data){ 
        $previous_url = '';
        $next_url = '';        
       
        $document_id = $data['document_id'] ?? ''; 
        $step_id = $data['step_id'] ?? ''; 
        $group = $data['group'] ?? 1; 
        //=======

        $document = DB::table('documents')->select('slug')->where('document_id',$document_id)->first(); 
        $document = json_decode(json_encode($document), true); 
        $slug = $document['slug'] ?? ''; 
        
        $DOC_URL = route('doc.index',$slug);

        $step_row = DB::table('documents_step')->select('*')->where('step_id',$step_id)->first();
        $step_row = json_decode(json_encode($step_row), true); 
        $group_count = $step_row['group_count'] ?? 1;        

        $steps = DB::table('documents_step')->select('*')->where('document_id',$document_id)->where('status',1)->orderBy('sort_order','asc')->get()->toArray(); 
        $steps = json_decode(json_encode($steps), true);

        $step_index = 0;
        foreach($steps as $key=>$val){
            if($val['step_id'] == $step_id){
                $step_index = $key;
            }
        }
        //$step_index = array_search($step_row,$steps,true);

        if($group_count > $group){
            $stepArr = $steps[$step_index-1] ?? [];
            if( $stepArr && $group == 1 ){
                $previous_url = $DOC_URL.'?step_id='.$stepArr['step_id'].'&group='.$stepArr['group_count'];
                $next_url     = $DOC_URL.'?step_id='.$step_id.'&group='.( $group + 1 );            
            }
            else{
                $previous_url = $DOC_URL.'?step_id='.$step_id.'&group='.( $group - 1 );
                $next_url     = $DOC_URL.'?step_id='.$step_id.'&group='.( $group + 1 );            
            }           
        }
        elseif($group_count==$group){
            
            $stepArrNxt  = $steps[$step_index+1] ?? [];
            $stepArrPrev = $steps[$step_index-1] ?? [];

            if($stepArrNxt){
                
                if( $step_index > 1 ){    
                    
                    if( $group_count > 1){
                        $previous_url = $DOC_URL.'?step_id='.$step_id.'&group='.( $group_count > 1 ? $group - 1 : 1);
                    }       
                    else{
                        $previous_url = $DOC_URL.'?step_id='.$stepArrPrev['step_id'].'&group='.$stepArrPrev['group_count'];
                    }                      
                }
                else{
                    $previous_url = $DOC_URL.'?step_id='.$step_id.'&group='.( $group - 1 ); 
                }                
                $next_url =$DOC_URL.'?step_id='.$stepArrNxt['step_id'].'&group=1';
            }
            else{

                if( $step_index > 1 ){
                    $previous_url = $DOC_URL.'?step_id='.$stepArrPrev['step_id'].'&group='.$stepArrPrev['group_count'];
                }
                else{
                    $previous_url = $DOC_URL.'?step_id='.$step_id.'&group='.( $group - 1 ); 
                }       
                //$previous_url = $DOC_URL.'?step_id='.$step_id.'&group='.( $group - 1);
                $next_url=route('doc.download',$slug);
            }            
        }
        if($step_index == 0 && $group == 1){
            $previous_url = '';
        }

        return [
            'previous_url'=>$previous_url,
            'next_url'=>$next_url,
        ];
    } 

    static function filter_question_value($data){ 

        $document_id = $data['document_id'] ?? ''; 
        $step_id = $data['step_id'] ?? ''; 
        $group = $data['group'] ?? ''; 

        $questions = [];        
        $q = DB::table('documents_question')->select('*');  
        if($document_id){
            $q = $q->where('document_id',$document_id);
        }
        if($step_id){
            $q = $q->where('step_id',$step_id);
        }
        if($group){
            $q = $q->where('label_group',$group);
        }  
        $q = $q->orderBy('question_id','asc')->get()->toArray(); 
        $result = json_decode(json_encode($q), true);        
        if($result){
            foreach($result as $val){
                $val['options'] = AllFunction::get_options([
                    'question_id'=>$val['question_id'],  
                ]);
                $questions[$val['question_id']] = $val;
            }
        }  
        $questions = array_values($questions);  
        $fields = AllFunction::get_document_fields($questions,'field_name');    
                
        $session_fields = [];
        if( Session::has('fields') ){ 
            $session_fields = (array)json_decode(Session::get('fields')); 
        } 
                       
        $inFieldGroup = AllFunction::construct_value('inFieldGroup');        
        $returnArr = [];    
        $qv = [];    
        foreach($questions as $key=>$val){

            $answer_type    = $val['answer_type'] ?? ''; 
            $field_name     = $val['field_name'] ?? ''; 
            $options        = $val['options'] ?? []; 
            $is_add_another = $val['is_add_another'] ?? 0; 
            $row_element    = $session_fields[$field_name] ?? ''; 
            
            if( $is_add_another == 1 && in_array($answer_type, $inFieldGroup) ){   
                $cc_count = $session_fields[$field_name.'_count'] ?? 1; 
                for($i=1; $i<=$cc_count; $i++){
                    $row_element_another = $session_fields[$field_name.'_'.$i] ?? ''; 
                    $returnArr[$field_name.'_'.$i] = AllFunction::get_value([
                        'value'=>$row_element_another,
                        'type'=>$answer_type
                    ]);   
                }
            }
            elseif( $is_add_another == 1 && !in_array($answer_type, $inFieldGroup)){   

                $cc_count  = $session_fields[$field_name.'_count'] ?? 1; 

                for($i=1; $i<=$cc_count; $i++){  

                    $row_element_another = $session_fields[$field_name.'_'.$i] ?? '';  
                    foreach($options as $key2=>$val2){    

                        $value       = $val2['value'] ?? ''; 
                        $questions_2 = $val2['questions'] ?? []; 

                        if( $row_element_another == $value && $questions_2 ){ 
                            $returnArr = AllFunction::loop_add_another_questions_value($questions_2, $session_fields, $returnArr, $field_name, $i);   
                        } 
                        elseif( $row_element_another == $value && !$questions_2){  
                            $returnArr[$field_name.'_'.$i] = AllFunction::get_value([
                                'value'=>$row_element_another,
                                'type'=>$answer_type
                            ]);  
                        }
                        else{  
                            
                            if( !isset($returnArr[$field_name.'_'.$i]) ){
                                $returnArr[$field_name.'_'.$i] = AllFunction::get_value([
                                    'value'=>$row_element_another,
                                    'type'=>$answer_type
                                ]);  
                            } 
                        }
                    }
                    
                }
                
            }
            elseif( in_array($answer_type, $inFieldGroup) ){ 
                $returnArr[$field_name] = AllFunction::get_value([
                    'value'=>$row_element,
                    'type'=>$answer_type
                ]);                  
            }
            else{
                                     
                foreach($options as $key2=>$val2){                   
                    
                    $value = $val2['value'] ?? ''; 
                    $questions_2 = $val2['questions'] ?? []; 
                    
                    if( $row_element == $value && $questions_2 ){                         
                        $returnArr = AllFunction::loop_questions_value($questions_2, $session_fields, $returnArr, $field_name);
                    }
                    elseif( $row_element == $value && !$questions_2){                        
                        $returnArr[$field_name] = AllFunction::get_value([
                            'value'=>$row_element,
                            'type'=>$answer_type
                        ]);                                         
                    }
                    else{  
                        
                        if( !isset($returnArr[$field_name]) ){
                            $returnArr[$field_name] = AllFunction::get_value([
                                'value'=>$row_element,
                                'type'=>$answer_type
                            ]);                  
                        } 
                    }
                }
                
            }  
        
        } 
        return $returnArr; 
    }
    static function loop_add_another_questions_value($questions, $session_fields, $returnArr, $parent_field_name, $i){ 
        $inFieldGroup = AllFunction::construct_value('inFieldGroup'); 
        $qv = [];
        foreach($questions as $key=>$val){ 
            $answer_type    = $val['answer_type'] ?? ''; 
            $field_name     = $val['field_name'] ?? ''; 
            $options        = $val['options'] ?? [];  
            $row_element_another = $session_fields[$field_name.'_'.$i] ?? '';  
            $return_field_name = $parent_field_name ? $parent_field_name.'_'.$i : $field_name.'_'.$i;           
           
           if( in_array($answer_type, $inFieldGroup) ){ 
            
                if( count($questions) > 1 ){
                    $qv[] = AllFunction::get_value([
                        'value'=>$row_element_another,
                        'type'=>$answer_type
                    ]); 
                    $returnArr[$return_field_name] = $qv;         
                }
                else{
                    $returnArr[$return_field_name] = AllFunction::get_value([
                        'value'=>$row_element_another,
                        'type'=>$answer_type
                    ]); 
                }                
            }
            else{
                
                foreach($options as $key2=>$val2){
                    $value = $val2['value'] ?? ''; 
                    $questions_2 = $val2['questions'] ?? [];
                    
                    if( $row_element_another == $value && $questions_2 ){
                        $returnArr = AllFunction::loop_add_another_questions_value($questions_2, $session_fields, $returnArr, $field_name, $i);
                    }
                    elseif( $row_element_another == $value && !$questions_2 ){ 
                        $returnArr[$return_field_name] = AllFunction::get_value([
                            'value'=>$row_element_another,
                            'type'=>$answer_type
                        ]); 
                    }
                    else{ 
                        if( !isset($returnArr[$return_field_name]) ){
                            $returnArr[$return_field_name] = AllFunction::get_value([
                                'value'=>$row_element_another,
                                'type'=>$answer_type
                            ]); 
                        }
                        
                    }
                }
            }          
        }
        return $returnArr;
    }
    static function loop_questions_value($questions, $session_fields, $returnArr, $parent_field_name){ 

        $inFieldGroup = AllFunction::construct_value('inFieldGroup'); 

        $qv = [];
        foreach($questions as $key=>$val){            

            $answer_type    = $val['answer_type'] ?? ''; 
            $field_name     = $val['field_name'] ?? ''; 
            $options        = $val['options'] ?? [];             
            $row_element    = $session_fields[$field_name] ?? '';
            $return_field_name = $parent_field_name ? $parent_field_name : $field_name;           
           
            if( in_array($answer_type, $inFieldGroup) ){ 
            
                if( count($questions) > 1 ){
                    $qv[] = AllFunction::get_value([
                        'value'=>$row_element,
                        'type'=>$answer_type
                    ]);                  
                    $returnArr[$return_field_name] = $qv;         
                }
                else{
                    $returnArr[$return_field_name] = AllFunction::get_value([
                        'value'=>$row_element,
                        'type'=>$answer_type
                    ]);                            
                }                
            }
            else{
                
                foreach($options as $key2=>$val2){
                    
                    $value = $val2['value'] ?? ''; 
                    $questions_2 = $val2['questions'] ?? [];
                    
                    if( $row_element == $value && $questions_2 ){
                        $returnArr = AllFunction::loop_questions_value($questions_2, $session_fields, $returnArr, $field_name);
                    }
                    elseif( $row_element == $value && !$questions_2 ){ 

                        if( $answer_type == 'radio_group' ){                            
                            $returnArr[$return_field_name] = AllFunction::get_value([
                                'value'=>$session_fields[$return_field_name] ?? '', 
                                'type'=>$answer_type
                            ]);             
                        }

                        if( !isset($returnArr[$return_field_name]) ){
                            $returnArr[$return_field_name] = AllFunction::get_value([
                                'value'=>$row_element,
                                'type'=>$answer_type
                            ]);            
                        }
                              
                    }
                    else{ 
                        if( !isset($returnArr[$return_field_name]) ){
                            $returnArr[$return_field_name] = AllFunction::get_value([
                                'value'=>$row_element,
                                'type'=>$answer_type
                            ]);                  
                        }
                        
                    }
                }
            }          
        }
        return $returnArr;
    }    
    static function format_date($date){ 
        return date('j F, Y',strtotime($date));
    }
    static function get_value($data){ 

        $type  = $data['type'] ?? ''; 
        $value = $data['value'] ?? ''; 

        $blankVal = AllFunction::construct_value('blankVal');   
        $blankVal = $blankVal[$type] ?? ''; 

        $date_pattern = '/^\d{4}-\d{2}-\d{2}$/';   
        
        $return_value = $value;
        if($value == ''){
            $return_value = $blankVal;
        }  
        elseif( preg_match($date_pattern, $value) ){
            $return_value = AllFunction::format_date($value);
        }   
        return $return_value;
    }
    //====
    static function replace_template($data){         
        
        $question_value = $data['question_value'] ?? []; 
        //p($question_value);
        $template = $data['template'] ?? '';   
        $template = str_replace( '{{current_date}}', AllFunction::format_date(date('Y-m-d')), $template);
        foreach($question_value as $key=>$val){   

           
            if( is_array($val) ){
                $i = 0;
                $html = '';
                foreach($val as $k=>$v){
                    $i++;
                    $html.= $v;
                    if($i < count($val) ){
                        $html.= '<br />';
                    }
                }
                
            }     
            elseif( AllFunction::is_json_data($val) ){
                $val = (array)json_decode($val);
                $i = 0;
                $html = '';
                foreach($val as $k=>$v){
                    $i++;
                    $html.= $v;
                    if($i < count($val) ){
                        $html.= ',';
                    }
                }
            }  
            else{
                $html = $val;
            }

            $template = str_replace( '{{'.$key.'}}', $html, $template);
        }  
        return $template;
    }
        
    //==== Added by A. Roy [start] =====//
    static function get_templateApiJsonData($data){         
        $document_id = $data['document_id'] ?? ''; 
        $session_fields = $data['session_fields'] ?? '';
        $session_fields = (array)json_decode($session_fields);
        $document = Document::find($document_id)->toArray(); 
        $country_id = $document['country_id'] ?? '';
        $country = Country::find($country_id)->toArray(); 

        $nested = AllFunction::buildNestedAnswers($session_fields);
       
        AllFunction::cleanNestedStructure($nested);
        AllFunction::mapFieldKeysToLabels($nested);        

        $return_array = [
            'document_name'=>$document['name'] ?? '',
            'country'=>$country['name'] ?? '',
            'question'=>$nested ?? '',
        ];
        return $return_array; 
    }      
    public static function cleanNestedStructure(array &$array): void {
        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                // Recursively clean children                
                AllFunction::cleanNestedStructure($value);

                // Remove this item if it's an empty array after cleanup
                if(empty($value)){
                    unset($array[$key]);
                }

                // Optional: flatten one-keyed arrays like [q90 => [q90 => "X"]]
                elseif (count($value) === 1 && isset($value[$key]) && is_scalar($value[$key])) {
                    $value = $value[$key];
                }
            }
        }
    }
	
	public static function build_nested_answers(array $fields): array{
        // Load all questions and options in memory
        $questions = \DB::table('documents_question')->get()->keyBy('field_name');
        $options = \DB::table('documents_question_option')->get()->groupBy('question_id');

        $result = [];

        foreach ($fields as $key => $value) {
            // Skip count fields for now
            if (str_ends_with($key, '_count')) continue;

            // Match keys like q93, q93_1, q2296_1_1, etc.
            preg_match('/^(q\d+)(?:_(\d+))?(?:_(\d+))?$/', $key, $matches);
            $base_field = $matches[1] ?? null;
            $first = $matches[2] ?? null;
            $second = $matches[3] ?? null;

            if (!isset($questions[$base_field])) continue;

            if ($first !== null && $second !== null) {
                $result[$base_field][$first][$second][$base_field] = $value;
            } elseif ($first !== null) {
                $result[$base_field][$first][$base_field] = $value;
            } else {
                $result[$base_field] = $value;
            }
        }

        // Recursively organize nested children
        foreach ($questions as $q) {
            $q = (array) $q;
            $field_name = $q['field_name'];
            if (!isset($result[$field_name])) continue;

            $has_children = isset($q['id']) && isset($options[$q['id']]);

            if (!$has_children) continue;

            if ($q['is_add_another']) {
                foreach ($result[$field_name] as $idx => &$entry) {
                    $entry = array_merge($entry, self::inject_child_fields($q['id'], $idx, $fields));
                }
            } else {
                $nested = self::inject_child_fields($q['id'], null, $fields);
                $result[$field_name] = array_merge(
                    is_array($result[$field_name]) ? $result[$field_name] : [$field_name => $result[$field_name]],
                    $nested
                );
            }
        }
        return $result;
    }

    private static function inject_child_fields(int $parent_question_id, $repeat_index, array $fields): array{
        $output = [];
        $options = \DB::table('documents_question_option')->where('question_id', $parent_question_id)->pluck('id');
        $child_questions = \DB::table('documents_question')
            ->whereIn('parent_option_id', $options)
            ->get();

        foreach ($child_questions as $child) {
            $field = $child->field_name;
            $is_repeat = $child->is_add_another;

            if($is_repeat){
                $count_key = $field . '_count';
                $count = $fields[$count_key] ?? 0;

                for ($i = 1; $i <= $count; $i++) {
                    $child_data = [];
                    foreach ($fields as $fkey => $fval) {
                        if (preg_match("/^" . preg_quote($field) . "_{$repeat_index}_{$i}$/", $fkey)) {
                            $child_data[$field] = $fval;
                        }
                    }
                    if (!empty($child_data)) {
                        $output[$field][] = $child_data;
                    }
                }
            } else {
                $key = $repeat_index !== null ? "{$field}_{$repeat_index}" : $field;
                if (isset($fields[$key])) {
                    $nested = self::inject_child_fields($child->id, $repeat_index, $fields);
                    $output[$field] = array_merge([$field => $fields[$key]], $nested);
                }
            }
        }
        return $output;
    }

    public static function convertFieldsToNestedArray($fields){
        $result = [];

        foreach ($fields as $key => $value) {
            // Skip count keys
            if (str_ends_with($key, '_count')) {
                continue;
            }

            // Split the key by underscore
            $parts = explode('_', $key);
            $base = array_shift($parts); // e.g., q87

            // No nesting needed
            if (empty($parts)) {
                if ($value !== '') {
                    $result[$base] = $value;
                }
                continue;
            }

            // Assign to nested structure
            $ref = &$result[$base];
            foreach ($parts as $part) {
                if (!isset($ref[$part])) {
                    $ref[$part] = [];
                }
                $ref = &$ref[$part];
            }

            // Set the value at the deepest level
            $ref[$base] = $value;
        }

        return $result;
    }

    public static function buildNestedAnswers(array $flatFields): array{
        $structured = [];
        $parentMap = self::buildFieldParentMap();

        foreach ($flatFields as $fullKey => $value) {
            if (str_ends_with($fullKey, '_count')) continue;
            if ($value === '' || $value === null) continue;

            preg_match('/^(q\d+)(?:_(\d+))?(?:_(\d+))?$/', $fullKey, $matches);
            $baseField = $matches[1] ?? null;
            $index1 = $matches[2] ?? null;
            $index2 = $matches[3] ?? null;

            if (!$baseField) continue;

            // Walk up the parent chain
            $path = [$baseField];
            while (isset($parentMap[end($path)])) {
                $path[] = $parentMap[end($path)];
            }
            $path = array_reverse($path); // root to leaf

            // Insert into nested array
            $ref = &$structured;
            foreach ($path as $depth => $field) {
                if ($depth === 0) {
                    if ($index1 !== null) {
                        if (!isset($ref[$field][$index1])) $ref[$field][$index1] = [];
                        $ref = &$ref[$field][$index1];
                    } else {
                        if (!isset($ref[$field])) $ref[$field] = [];
                        $ref = &$ref[$field];
                    }
                } elseif ($depth === 1 && $index2 !== null) {
                    if (!isset($ref[$field][$index2])) $ref[$field][$index2] = [];
                    $ref = &$ref[$field][$index2];
                } else {
                    if (!isset($ref[$field])) $ref[$field] = [];
                    $ref = &$ref[$field];
                }
            }

            // Finally set value directly under the last field, not as $ref[$baseField][$baseField]
            if (!isset($ref[$baseField])) {
                $ref[$baseField] = $value;
            }
        }
        return $structured;
    }

    public static function buildFieldParentMap(): array{
        $parentMap = [];
        // Load all questions
        $questions = Documents_question::all()->keyBy('question_id');
        $fieldToQuestion = Documents_question::all()->keyBy('field_name');
        $optionToQuestion = Documents_question_option::pluck('question_id', 'option_id');

        foreach ($questions as $q) {
            $field = $q->field_name;
            $optionId = $q->option_id;

            // Follow option to parent question
            if ($optionId && isset($optionToQuestion[$optionId])) {
                $parentQId = $optionToQuestion[$optionId];
                if (isset($questions[$parentQId])) {
                    $parentMap[$field] = $questions[$parentQId]->field_name;
                }
            }
        }
        return $parentMap;
    }

    public static function mapFieldKeysToLabels(array &$array): void{
        // Step 1: Build the map of field_name => label
        $labelMap = Documents_question::all()->mapWithKeys(function ($q) {
            return [$q->field_name => $q->short_question ?: $q->question];
        })->toArray();

        // Step 2: Recursive helper
        $renameKeys = function (&$arr) use (&$renameKeys, $labelMap) {
            foreach ($arr as $key => &$value) {
                if (is_array($value)) {
                    $renameKeys($value);
                }

                $newKey = $labelMap[$key] ?? $key;
                if ($newKey !== $key) {
                    $arr[$newKey] = $value;
                    unset($arr[$key]);
                }
            }
        };
        // Step 3: Apply to the top-level array
        $renameKeys($array);
    }

    static function convertMarkdownToHtml(string $markdown): string{
        $parsedown = new Parsedown();
        $htmlContent = $parsedown->text($markdown);
        // Wrap the HTML in a styled container div
        return '
        <div class="markdown-preview">
            ' . $htmlContent . '
        </div>';
    }

    static function removeEmptyFields(array $data): array{
        return array_filter($data, function($value) {
            return trim($value) !== '';
        });
    }

    static function blurRandomElements_old(string $content, int $count = 3): string{
        // Match <p> and <h1> to <h6> tags
        preg_match_all('/<(p|h[1-6])\b[^>]*>(.*?)<\/\1>/is', $content, $matches);

        $elements = $matches[0];
        $total = count($elements);

        if ($total === 0 || $count <= 0) {
            return $content;
        }

        // Pick random unique indices to blur
        $keysToBlur = array_rand($elements, min($count, $total));
        if (!is_array($keysToBlur)) {
            $keysToBlur = [$keysToBlur];
        }

        foreach ($keysToBlur as $key) {
            $original = $elements[$key];
            $tag = $matches[1][$key]; // 'p' or 'h1'... 'h6'
            $innerContent = $matches[2][$key];

            $blurred = "<$tag><span class=\"docblurred\">" . strip_tags($innerContent, '<strong><em><a>') . "</span></$tag>";
            $content = str_replace($original, $blurred, $content);
        }
        return $content;
    }

    static function blurRandomElements(string $content, int $count = 3): string{
        // Match all paragraphs and heading tags (h1–h6)
        preg_match_all('/<(p|h[1-6])\b[^>]*>(.*?)<\/\1>/is', $content, $matches);

        $elements = $matches[0];
        $total = count($elements);

        // Determine exclusion count (first 2 + last 2)
        $excludeCount = 2;
        if ($total <= $excludeCount * 2) {
            return $content; // Not enough elements to blur
        }

        // Collect index range that is eligible for blurring
        $eligibleKeys = range($excludeCount, $total - $excludeCount - 1);

        // Shuffle and pick N keys to blur
        shuffle($eligibleKeys);
        $keysToBlur = array_slice($eligibleKeys, 0, min($count, count($eligibleKeys)));

        // Build replacements
        foreach ($keysToBlur as $key) {
            $original = $elements[$key];
            $tag = $matches[1][$key];
            $innerContent = $matches[2][$key];

            $blurred = "<$tag><span class=\"docblurred\">" . strip_tags($innerContent, '<strong><em><a>') . "</span></$tag>";
            $content = str_replace($original, $blurred, $content);
        }
        return $content;
    }
    //==== Added by A. Roy [ends] =====//

    static function percentage_of_answer($document_id, $session_fields){   
        $total_question = DB::table('documents_question')->where('document_id',$document_id)->where('option_id','0')->count(); 
        $total_question = ( $total_question > 0 ) ? $total_question : 1;
        $session_fields = (array)json_decode($session_fields); 
        
        $answer = [];
        foreach($session_fields as $key=>$val){
            if($val){
                $answer[] = $val;
            }
        }
        $total_answer = count($answer);       
        $percent = ($total_answer/$total_question)*100;        

        //if( $percent >= 50 ){
        if( $total_answer >= $total_question ){
            return true;
        }
        else{
            return false;
        }        
    }

    static function guest_document_count($document_id){   
        $date_before = date('Y-m-d H:i:s',strtotime('-6 hour')); // 2025-05-05 11:00:00 , 2025-05-05 05:00:00 , 2025-05-05 11:30:00
        
        $count = DB::table('customers_guest_document')
        ->where('document_id',$document_id) 
        ->where('ip_address',$_SERVER['REMOTE_ADDR'])
        ->where('created_at','>=',$date_before)        
        ->count();        
        return $count;         
    }
    
    static function save_document($data){  
        
        $customer_id = $data['customer_id'] ?? ''; 
        $guest_document_id = $data['guest_document_id'] ?? ''; 
        $guest_document = Customers_guest_document::where('guest_document_id',$guest_document_id)->with(['document'])->first()->toArray();         

        $document_id        = $guest_document['document_id'] ?? '';  
        $session_fields     = $guest_document['session_fields'] ?? '';
        $filter_values      = $guest_document['filter_values'] ?? '';
        $openai_document    = $guest_document['openai_document'] ?? '';
        $document           = $guest_document['document'] ?? [];

        //===save ==
        $table = new Customers_document;
        $table->customer_id     = $customer_id;
        $table->document_id     = $document_id;            
        $table->session_fields  = $session_fields;
        $table->filter_values   = json_encode($filter_values);
        $table->file_name       = $document['name'] ?? '';
        $table->ip_address      = $_SERVER['REMOTE_ADDR'] ;
        $table->openai_document = $openai_document;
        $table->save(); 
        
        //==== remove session ====
        Session::forget('document_id'); 
        Session::forget('fields'); 
        Session::forget('openai_document'); 
        Session::forget('guest_document_id');         
        //=====  
    }

    static function text_to_html($text){   
        $text = str_replace( ':**','</b>', $text);
        $text = AllFunction::replace_all_text_between($text, '---', '---', '');
        $text = AllFunction::replace_all_text_between($text, '**', '**', '');
        $text = str_replace( '**','<b>', $text);
        $text = str_replace( ':*','</b>', $text);
        $text = str_replace( '*','<b>', $text);
        $text = str_replace( '<b><b>','', $text);
        $text = nl2br($text);
        return $text;
    }
    static function replace_all_text_between($str, $start, $end, $replacement){
        $replacement = $start . $replacement . $end;
        $start = preg_quote($start, '/');
        $end = preg_quote($end, '/');
        $regex = "/({$start})(.*?)({$end})/";
        return preg_replace($regex,$replacement,$str);
    }  
    static function reset_session_document_id($document_id){        
        if( Session::has('document_id') ){  
            if($document_id!=Session::get('document_id')){
                Session::forget('document_id');  
                Session::forget('fields');  
            }                
        }        
    }      
    
}