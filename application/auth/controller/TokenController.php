<?php

namespace app\auth\controller;

use think\Controller;
use think\facade\Request;
use think\facade\Cache;

class TokenController extends Controller
{
    public static function createToken($user_info=[])
    {
        $hash = md5(openssl_random_pseudo_bytes(16));
        $key = config("CacheKey.token").$hash;
        Cache::set($key, $user_info, config("CacheExpire.token"));
        return $key;
    }

    /**
     * 验证token
     * @return array|bool
     */
    public static function verifyToken($brand_id = 0)
    {
        $token = Request::header('token');
        if (empty($token)) {
            return false;
        }
        $token_arr = explode(':', $token);
     
        $info = Cache::get($token);
        if (empty($info)) {
            return false;//校验失败
        }

        Cache::handler()->expire($token, 60 * 60 * 2);
        
        return $info;
    }

    public static function verifyHasToken()
    {
        $token = Request::header('token');
        if (empty($token)) {
            return false;
        }
       
        $info = Cache::get($token);
        if (empty($info)) {
            return false;//校验失败
        }
        
        return $info;
    }
}
