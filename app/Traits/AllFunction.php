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
use Intervention\Image\Facades\Image as ResizeImage;

use App\Models\Settings;
use App\Models\Language;
use App\Models\Country;

trait AllFunction {    

      static function admin_limit($number=0){
        return $number ? $number : 25;
      }

      static function limit($number=0){
        return $number ? $number : 25;
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
    static function upload_image($data) {
        
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
        
        if($width && $height){
            
            $destination_path = 'storage/'.$destination_path;            
            !is_dir($destination_path) &&
            mkdir($destination_path, 0777, true);

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

    static function get_common_data(){ 
        //Cache::pull('data');
        if(Cache::has('data')){
            $data = Cache::get('data');
        }
        else{
            $settings = AllFunction::get_setting([
                'logo',
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

            $data  = compact('settings'); 

            //== put data into cache
            Cache::put('data', $data, now()->addMinutes(60)); 

            //== get data from cache
            //Cache::get('data');

            //== remove data from cache
            //Cache::pull('data');
        }
        return $data;
    }

    //=== set language ====
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
}