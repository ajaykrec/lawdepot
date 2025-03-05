<?php
use App\Traits\AllFunction;
use App\Models\Settings;

if(!function_exists('p')){
    function p($data){
        echo'<pre>';
        print_r($data);
        echo'</pre>';
        die;
    }
}

if(!function_exists('first_letter')){
    function first_letter($data){
        $array  = explode(' ',$data);
        $output = [];
        if($array){
            foreach( $array as $val){
                $output[] = substr($val, 0, 1);
            }
        }        
        $output = implode('',$output);
        $output = strtoupper($output);
        return $output;       
    }
}

function currency($amount, $currency_code){ 

    // $row = AllFunction::get_setting(['currency']);
    // $currency = $row['currency'] ?? '';  
    // return $currency.$amount;    

    $codes = [
        'INR'=>'₹',
        'GBP'=>'£',
        'USD'=>'$',
        'AUD'=>'A$'
    ];   
    $amount = str_replace('.00','',$amount);
    return $codes[$currency_code] . $amount;     
}

function full_date_format($date){  
    return date('j F, Y, g:i a');
}

function short_date_format($date){  
    return date('j M, Y');
}

if(!function_exists('has_permision')){
    function has_permision($data){
        $users_types = Auth::user()->users_types->toArray();
        $usertype_id = $users_types['usertype_id'] ?? '';        

        if($usertype_id == '1'){
            return true;
        }
        $modulesArr  = (array)json_decode($users_types['modules'] ?? '');         
        if($data){
            $count = 0;            
            foreach($data as $key=>$val){
                if( is_numeric($key) ){                    
                    $rowCount = isset($modulesArr[$val]) ? 1 : 0;                     
                    $count = $count + $rowCount;
                }
                else{
                    $array  = $modulesArr[$key] ?? [];
                    $valArr = explode(',',$val);                    
                    foreach($valArr as $val2){
                        if(in_array($val2,$array)){
                            $count = $count + 1;
                        }
                    }                    
                }
            }
            if($count > 0 ){ return true; }
            else{ return false;}
        }
        else{
            return false;
        }        
    }
}

function get_resource($resource = null){
    $files = '';    
    if(is_array($resource)){           
        foreach($resource as $file){
            $files .= load_file($file);
        }           
    }   
    return $files;
}

function load_file($file){
    if($file['type'] == 'javascript'){
        return '<script src="' . $file['url'] . '"></script>';
    }
    else if ($file['type'] == 'module'){
        return '<script type="module" src="' . $file['url'] . '"></script>';
    } 
    else if ($file['type'] == 'css'){
        return '<link rel="stylesheet" href="' . $file['url'] . '">';
    }
}

function get_common_data(){  
    return AllFunction::get_common_data();
}

function ellipsis($text, $max = 100, $append = '&hellip;'){
    if (strlen($text) <= $max)
        return $text;
    $replacements = array(
        '|<br /><br />|' => ' ',
        '|&nbsp;|' => ' ',
        '|&rsquo;|' => '\'',
        '|&lsquo;|' => '\'',
        '|&ldquo;|' => '"',
        '|&rdquo;|' => '"'
    );
    $patterns     = array_keys($replacements);
    $replacements = array_values($replacements);
    $text         = preg_replace($patterns, $replacements, $text);
    $text         = strip_tags($text);
    $out          = substr($text, 0, $max);
    if (strpos($text, ' ') === false)
        return $out . $append;
    return preg_replace('/(\W)&(\W)/', '$1&amp;$2', (preg_replace('/\W+$/', ' ', preg_replace('/\w+$/', '', $out)))) . $append;
}



