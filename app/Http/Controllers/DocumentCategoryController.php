<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\AllFunction; 
use App\Models\Pages;
use App\Models\Document_category;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia; 

class DocumentCategoryController extends Controller
{
    use AllFunction; 

    public function index($slug, Request $request){          

        $country = AllFunction::get_current_country(); 
        $country_id = $country['country_id'] ?? '';        

        $q = DB::table('documents_category');  
        $q = $q->where('documents_category.country_id',$country_id);   
        $q = $q->where('documents_category.slug',$slug); 
        $category = $q->first(); 
        $category = json_decode(json_encode($category), true); 

        $category_id = $category['category_id'] ?? ''; 
        
        $q = DB::table('documents');  
        $q = $q->select('documents.document_id','documents.category_id','documents.name','documents.slug','documents.short_description','documents.image');   
        $q = $q->where('documents.category_id',$category_id);   
        $q = $q->where('documents.status',1); 
        $q = $q->orderby('documents.sort_order','asc'); 
        $q = $q->orderby('documents.name','asc'); 
        $documents = $q->get()->toArray(); 
        $documents = json_decode(json_encode($documents), true); 
              
        $meta = [
            'title'=>$category['meta_title'] ?? '',
            'keywords'=>$category['meta_keyword'] ?? '',
            'description'=>$category['meta_description'] ?? '',
        ];

        $header_banner = [
            'title'=>$category['name'],
            'banner_image'=>$category['banner_image'],
            'banner_text'=>$category['banner_text'],
        ];
        $breadcrumb = [
            ['name'=>'Home', 'url'=>route('home')],
            ['name'=>$category['name'], 'url'=>''],
        ];
                
        $pageData = compact('category','meta','header_banner','breadcrumb','documents'); 
        return Inertia::render('frontend/pages/category/Category', [            
            'pageData' => $pageData,            
        ]);
    }
    
}
