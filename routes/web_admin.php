<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FileController;
use App\Http\Controllers\admin\CommonController;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\FaqController;
use App\Http\Controllers\admin\UserTypesController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\ContactController;
use App\Http\Controllers\admin\EmailTemplateController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\PageController;
use App\Http\Controllers\admin\BlockController;
use App\Http\Controllers\admin\TestimonialController;

use App\Http\Controllers\admin\BannerController;
use App\Http\Controllers\admin\BannerCategoryController;

use App\Http\Controllers\admin\LanguageController;
use App\Http\Controllers\admin\CountryController;
use App\Http\Controllers\admin\ZonesController;

use App\Http\Controllers\admin\DocumentCategoryController;
use App\Http\Controllers\admin\DocumentController;
use App\Http\Controllers\admin\DocumentCopyController;

use App\Http\Controllers\admin\DocumentStepController;
use App\Http\Controllers\admin\DocumentFaqController;
use App\Http\Controllers\admin\DocumentQuestionController;
use App\Http\Controllers\admin\DocumentQuestionOptionController;

use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\CustomerAddressController;
use App\Http\Controllers\admin\CustomerMembershipController;  
use App\Http\Controllers\admin\CustomerDocumentController;
use App\Http\Controllers\admin\OrderController;

use App\Http\Controllers\admin\MembershipController;

//==============

Route::any('/', [LoginController::class, 'login'])->name('login');
Route::get('/forgot-password', [LoginController::class, 'forgot_password'])->name('forgot.password');
Route::post('/forgot-password', [LoginController::class, 'forgot_password_post'])->name('forgot.password.post');
Route::get('/reset-password/{token}', [LoginController::class, 'reset_password'])->name('password.reset');
Route::post('/reset-password', [LoginController::class, 'reset_password_post'])->name('reset.password.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//== protected routes
Route::middleware(['auth'])->group( function(){

    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');
    Route::delete('/file',[FileController::class, 'delete_file'])->name('delete.file');        
    Route::get('/profile',[ProfileController::class, 'index'])->name('profile');
    Route::any('/edit-profile',[ProfileController::class, 'update'])->name('profile.update');
    Route::any('/change-profile-password',[ProfileController::class, 'change_password'])->name('profile.change.password');

    Route::resource('/faq',FaqController::class);
    Route::resource('/user-types',UserTypesController::class);   
    Route::resource('/users',UserController::class); 
    Route::resource('/contact',ContactController::class); 
    Route::resource('/email-templates',EmailTemplateController::class); 
    Route::resource('/settings',SettingController::class); 
    Route::resource('/pages',PageController::class);
    Route::resource('/blocks',BlockController::class);   
    Route::resource('/language',LanguageController::class);       
    Route::resource('/banner-category',BannerCategoryController::class); 

    //=== nested resource controller
    //Hint : https://laravel.com/docs/10.x/controllers#restful-scoping-resource-routes
    Route::resource('/banner-category.banners',BannerController::class)->shallow();

    Route::resource('/testimonial',TestimonialController::class);  
    Route::resource('/country',CountryController::class);  
    Route::resource('/zones',ZonesController::class);  
    
    Route::resource('/document-category',DocumentCategoryController::class);    
    Route::resource('/document',DocumentController::class);
    Route::post('/document-copy/{parent_document_id}', [DocumentCopyController::class, 'copy_document'])->name('document.copy'); 
    Route::get('/doc-categories/{country_id}', [DocumentController::class, 'get_categories'])->name('doc.categories');   
    Route::resource('/document.steps',DocumentStepController::class)->shallow();
    Route::resource('/document.faqs',DocumentFaqController::class)->shallow();    
    
    //Route::resource('/document.questions',DocumentQuestionController::class)->shallow();
    Route::resource('/questions',DocumentQuestionController::class)->shallow();
    Route::resource('/document.options',DocumentQuestionOptionController::class)->shallow();    
    Route::post('/shift-question', [DocumentQuestionController::class, 'shift_question'])->name('shift.question');   
    Route::get('/shift-step-group', [DocumentQuestionController::class, 'shift_step_group'])->name('shift.step.group');   

    /*
    Route::resource('/document-steps/{document_id}',DocumentStepController::class)->names([
        'index' => 'steps.index',
        'create' => 'steps.create',
        'store' => 'steps.store',
        'show' => 'steps.show',
        'edit' => 'steps.edit',
        'update' => 'steps.update',
        'destroy' => 'steps.destroy',
    ]);
    */

    Route::resource('/customers',CustomerController::class)->shallow();
    Route::resource('/customers.address',CustomerAddressController::class)->shallow(); 
    Route::resource('/customers.membership',CustomerMembershipController::class)->shallow(); 
    Route::resource('/customers.cusdocument',CustomerDocumentController::class)->shallow(); 
    Route::resource('/membership-setting',MembershipController::class)->shallow();
    Route::resource('/orders',OrderController::class)->shallow();    
    
    Route::get('/common',[CommonController::class, 'index'])->name('common');
    
});
//=== 404 page ====
Route::any('{catchall}', [LoginController::class,'notfound'])->where('catchall', '.*');

