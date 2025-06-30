<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PagesController;

use App\Http\Controllers\SearchController;

use App\Http\Controllers\DocumentCategoryController;
use App\Http\Controllers\DocumentController; 

use App\Http\Controllers\MembershipController; 

use App\Http\Controllers\Auth\CustomerController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\MyDocumentController;
use App\Http\Controllers\MyMembershipController;
use App\Http\Controllers\MySettingsController;
use App\Http\Controllers\ChangePasswordController;

use App\Http\Controllers\TestingController;

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

    Route::get('/my-account',[MyAccountController::class, 'index'])->name('customer.account');     
    Route::get('/my-membership',[MyMembershipController::class, 'index'])->name('customer.membership'); 
    Route::get('/cancel-membership/{cus_membership_id}',[MyMembershipController::class, 'cancel_membership'])->name('cancel.membership'); 
    Route::get('/my-account-settings',[MySettingsController::class, 'index'])->name('customer.settings'); 
    Route::post('/my-account-settings',[MySettingsController::class, 'account_post'])->name('customer.settings.post'); 
    Route::get('/change-password',[ChangePasswordController::class, 'index'])->name('customer.changepassword'); 
    Route::post('/change-password',[ChangePasswordController::class, 'password_post'])->name('customer.changepassword.post'); 
    Route::get('/my-documents',[MyDocumentController::class, 'index'])->name('customer.documents');   
    Route::get('/my-documents/{cus_document_id}',[MyDocumentController::class, 'view'])->name('customer.documents.view');  
    Route::get('/edit-my-documents/{cus_document_id}',[MyDocumentController::class, 'edit'])->name('customer.documents.edit');  
    Route::post('/update-my-documents/{cus_document_id}',[MyDocumentController::class, 'update'])->name('customer.documents.update');  
});

Route::group(['middleware'=>['front_view']],function(){ // 'prefix' => 'in'
    
    Route::get('/coming-soon', [PagesController::class,'coming_soon'])->name('comingsoon');
    Route::get('/', [HomeController::class,'index'])->name('home'); 
    
    Route::get('/search-result', [SearchController::class, 'index'])->name('search.post');
    
    //=== Auth ===
    Route::get('/register', [CustomerController::class, 'register'])->name('customer.register');
    Route::post('/register', [CustomerController::class, 'register_post'])->name('customer.register.post');     

    Route::get('/login', [CustomerController::class, 'login'])->name('customer.login');
    Route::post('/login', [CustomerController::class, 'login_post'])->name('customer.login.post');     

    Route::get('/forgot-password', [CustomerController::class, 'forgot_password'])->name('customer.forgot.password');  
    Route::post('/forgot-password', [CustomerController::class, 'forgot_password_post'])->name('customer.forgot.password.post');

    Route::any('/reset-password/{token}', [CustomerController::class, 'reset_password'])->name('customer.password.reset');
    Route::post('/reset-password', [CustomerController::class, 'reset_password_post'])->name('customer.reset.password.post');      
    Route::get('/logout', [CustomerController::class, 'logout'])->name('customer.logout');

    //=== Documents ==
    Route::get('/group/{slug}', [DocumentCategoryController::class, 'index'])->name('category.index');
    Route::any('/all-documents', [DocumentCategoryController::class, 'all_documents'])->name('all.documents');
    Route::get('/document/{slug}', [DocumentController::class, 'index'])->name('doc.index');   
    Route::post('/document/{slug}', [DocumentController::class, 'doc_post'])->name('doc.post');   
    Route::get('/document-download/{slug}', [DocumentController::class, 'download'])->name('doc.download');   
    Route::get('/save-document', [DocumentController::class, 'save_document'])->name('save.document'); 
    

    //=== membership ==
    Route::get('/membership', [MembershipController::class, 'index'])->name('membership.index');
    Route::post('/select-membership', [MembershipController::class, 'select_membership'])->name('select.membership.post');   
    Route::get('/checkout', [MembershipController::class, 'checkout'])->name('membership.checkout');
    Route::any('/checkout-success', [MembershipController::class, 'success'])->name('membership.checkout.success');
    Route::any('/checkout-callback', [MembershipController::class, 'callback'])->name('membership.checkout.callback');
    Route::any('/renew-callback', [MembershipController::class, 'renew'])->name('membership.renew.callback');   
    

    //=== pages ==
    Route::get('/about-us', [PagesController::class,'about'])->name('about');    
    Route::get('/help', [PagesController::class,'help'])->name('help');
    Route::get('/terms-and-condition', [PagesController::class,'terms_and_condition'])->name('terms');   
    Route::get('/privacy-policy', [PagesController::class,'privacy_policy'])->name('privacy');       

    //=== contact ==
    Route::get('/contact', [ContactController::class,'index'])->name('contact');
    Route::post('/contact', [ContactController::class,'post_contact'])->name('post.contact');  

    //=== testing ==
    Route::get('/testing-renewal', [TestingController::class,'index']);
    
    //=== 404 page ====
    Route::any('{catchall}', [PagesController::class,'notfound'])->where('catchall', '.*');

});



