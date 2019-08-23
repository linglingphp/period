<?php

Route::group('api', function(){

    //认证模块
    // Route::get('checkStatus/:brand_id', 'auth/AuthController/checkStatus');
    
    Route::put('member', 'member/IndexController/edit');
})->pattern(['id' => '\d+'])->middleware('Check');