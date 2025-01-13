<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PagesController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;


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

Route::group(['middleware'=>['front_view']],function(){ // 'prefix' => 'in'
    
    Route::get('/coming-soon', [PagesController::class,'coming_soon'])->name('comingsoon');
    Route::get('/', [HomeController::class,'index'])->name('home');

    //=== Auth ===
    Route::get('/login', [LoginController::class, 'login'])->name('customer.login');
    Route::post('/login', [LoginController::class, 'login_post'])->name('customer.login.post');    
    Route::get('/forgot-password', [LoginController::class, 'forgot_password'])->name('customer.forgot.password');  
    Route::post('/forgot-password', [LoginController::class, 'forgot_password_post'])->name('customer.forgot.password.post');
    Route::get('/reset-password/{token}', [LoginController::class, 'reset_password'])->name('customer.password.reset');
    Route::post('/reset-password', [LoginController::class, 'reset_password_post'])->name('customer.reset.password.post');      
    Route::get('/logout', [LoginController::class, 'logout'])->name('customer.logout');

    Route::get('/about-us', [PagesController::class,'about'])->name('about');    
    Route::get('/teams', [PagesController::class,'teams'])->name('teams');
    Route::get('/terms-and-condition', [PagesController::class,'terms_condition'])->name('tearms');    

    Route::get('/contact', [ContactController::class,'index'])->name('contact');
    Route::post('/contact', [ContactController::class,'post_contact'])->name('post.contact');     

});

//== protected routes
Route::middleware(['auth.customer','front_view'])->group( function(){
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('customer.dashboard'); 

});

Route::group(['middleware'=>['front_view']],function(){    
    //=== 404 page ====
    Route::any('{catchall}', [PagesController::class,'notfound'])->where('catchall', '.*');
});

