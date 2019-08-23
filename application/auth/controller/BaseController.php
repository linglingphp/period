<?php

namespace app\auth\controller;

use think\Controller;
use app\auth\controller\TokenController;
use think\facade\Cache;
use think\facade\Request;

class BaseController extends Controller
{
    protected $member;
    protected $member_id;

    public function __construct()
    {
        $info = TokenController::verifyToken();
        if (empty($info)) {
            header('HTTP/1.0 401 Unauthorized');
            header('Content-type: application/json');
            $result = [
                'errorCode' => 401,
                'message' => '未授权',
            ];
            header('Content-type: application/json');
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            exit;
        }
        $this->member = $info;
        $this->member_id = $info['member_id'];
        return true;
    }

    
    /**
     * Api 接口请求频率限制
     */
    public function apiLimit()
    {
        $token = Request::header('token');
        Cache::handler()->incr("concurrent:{$token}");
        Cache::handler()->expire("concurrent:{$token}", 3);
        if (Cache::handler()->get("concurrent:{$token}") > 2) {
            $response = [
                'errorCode' => 10040,
                'message' => config('errorCode.10040')
            ];
            header('Content-type: application/json');
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            die();
        }
    }

}
