<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('/', function () {
    return 'hello,visitor!';
});

Route::group('api', function(){

    
    Route::post('auth', 'auth/AuthController/auth');//认证模块
    Route::post('member/enroll', 'member/EnrollController/enroll');

})->pattern([
    'id'       => '\d+',
    'brand_id' => '\d+',
]);