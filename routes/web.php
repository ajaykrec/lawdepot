<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PagesController;

use App\Http\Controllers\DashboardController;

use App\Http\Controllers\DocumentCategoryController;
use App\Http\Controllers\DocumentController; 

use App\Http\Controllers\MembershipController; 


//=== download file ====
Route::get('/download/{folder}/{file_name}', function ($folder,$file_name) { 
    $file_path = public_path().'/storage/uploads/'.$folder.'/'.$file_name;   
    $headers = array(
        'Content-Type: ' . mime_content_type( $file_path ),
    );
    return Response::download($file_path, $file_name, $headers);
});

//=== clear cache ====
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear'); // php artisan cache:clear
});

//=== link storage folder in public ====
Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

//== protected routes
Route::middleware(['auth.customer','front_view'])->group( function(){
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('customer.dashboard'); 
});

Route::group(['middleware'=>['front_view']],function(){ // 'prefix' => 'in'
    
    Route::get('/coming-soon', [PagesController::class,'coming_soon'])->name('comingsoon');
    Route::get('/', [HomeController::class,'index'])->name('home');    

    //=== Documents ==
    Route::get('/group/{slug}', [DocumentCategoryController::class, 'index'])->name('category.index');
    Route::get('/document/{slug}', [DocumentController::class, 'index'])->name('doc.index');   
    Route::get('/document-download/{slug}', [DocumentController::class, 'download'])->name('doc.download');   

    //=== membership ==
    Route::get('/membership', [MembershipController::class, 'index'])->name('membership.index');

    //=== pages ==
    Route::get('/about-us', [PagesController::class,'about'])->name('about');    
    Route::get('/help', [PagesController::class,'help'])->name('help');
    Route::get('/terms-and-condition', [PagesController::class,'terms_and_condition'])->name('terms');   
    Route::get('/privacy-policy', [PagesController::class,'privacy_policy'])->name('privacy');       

    //=== contact ==
    Route::get('/contact', [ContactController::class,'index'])->name('contact');
    Route::post('/contact', [ContactController::class,'post_contact'])->name('post.contact');  
    
    //=== 404 page ====
    Route::any('{catchall}', [PagesController::class,'notfound'])->where('catchall', '.*');

});


