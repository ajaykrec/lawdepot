<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request){
                
        $table_count = (array) DB::select("SELECT 
        (SELECT COUNT(*) FROM banners) as banners_count, 
        (SELECT COUNT(*) FROM banners_categories) as banners_categories_count, 
        (SELECT COUNT(*) FROM blocks) as blocks_count, 
        (SELECT COUNT(*) FROM contacts) as contacts_count, 
        (SELECT COUNT(*) FROM email_templates) as email_templates_count, 
        (SELECT COUNT(*) FROM faqs) as faqs_count, 
        (SELECT COUNT(*) FROM pages) as pages_count, 
        (SELECT COUNT(*) FROM settings) as settings_count, 
        (SELECT COUNT(*) FROM users_types) as users_types_count,  
        (SELECT COUNT(*) FROM users ) as users_count,

        (SELECT COUNT(*) FROM country) as country_count,  
        (SELECT COUNT(*) FROM zones ) as zones_count,

        (SELECT COUNT(*) FROM documents) as document_count,  
        (SELECT COUNT(*) FROM documents_category ) as document_category_count,

        (SELECT COUNT(*) FROM language ) as language_count,

        (SELECT COUNT(*) FROM membership ) as membership_count
        
        ");
        $table_count = array_map(function ($value) {
            return (array) $value;
        }, $table_count);
        $table_count = $table_count[0] ?? [] ;   

        $meta = [
            'title'=>'Dashboard',
            'keywords'=>'',
            'description'=>'',
        ];

        $data = compact('meta','table_count'); 
        return view('admin.dashboard')->with($data);
    }
}
