<?php
use Illuminate\Support\Facades\Route;

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
