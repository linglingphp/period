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

Route::group('benifit/api', function(){

    //认证模块
    Route::get('auth/:brand_id', 'auth/AuthController/auth');

})->pattern([
    'id'       => '\d+',
    'brand_id' => '\d+',
]);