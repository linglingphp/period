<?php

Route::group('benifit/api', function(){

    //认证模块
    Route::get('checkStatus/:brand_id', 'auth/AuthController/checkStatus');

})->pattern(['id' => '\d+'])->middleware('Check');