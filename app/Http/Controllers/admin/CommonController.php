<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\AllFunction;

class CommonController extends Controller
{
    use AllFunction; 

    public function index(){          
        
        $settings = AllFunction::get_setting([
            'copyrights',
            'designed_by',
            'logo',           
            'site_name',
        ]);            
        $data  = compact( 'settings');        
        echo json_encode(
            array(
            'status'  => 'success',                 
            'message' => $data,							
        ));		
        exit;
    }    
}
