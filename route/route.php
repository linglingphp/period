<?php

Route::group('api', function(){

    //认证模块
    // Route::get('checkStatus/:brand_id', 'auth/AuthController/checkStatus');
    
    Route::get('checkStatus', 'auth/AuthController/checkStatus');

    Route::get('body/bodyDailys', 'member/BodyDailyController/list');
    Route::get('body/bodyDaily', 'member/BodyDailyController/get');
    Route::post('body/bodyDaily', 'member/BodyDailyController/edit');
    Route::get('member', 'member/IndexController/get');
    Route::post('member', 'member/IndexController/edit');

    Route::get( 'statistic/power', 'statistic/IndexController/getPowerData');
})->pattern(['id' => '\d+'])->middleware('Check');