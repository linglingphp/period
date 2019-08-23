<?php

namespace app\auth\controller;

use think\Controller;
use app\auth\controller\TokenController;
use app\common\model\Member;
use think\facade\Request;
use think\Validate;

class AuthController extends Controller
{
   
    public function auth()
    {
        $params = Request::param();
        $validate = Validate::make([
            'username'  => 'require|min:3',
            'passward'  => 'require|min:6'
        ]);
        if (!$validate->check($params)) {
            return renderData(100, $validate->getError());
        }
        //检查参数
        $member = Member::where('username',$params['username'])->find();
        if (!empty($member->id) && password_verify($params['passward'], $member->password_hash)) {
            $member->dt_login = date('Y-m-d H:i:s');
            $member->save();
        }else{
            return renderData(100, '信息错误');
        }
         //验证信息正确，生成用户token
        $member_info = [
            'member_id'      => isset($member->id)?$member->id:0,
            'nickname'       => isset($member->nickname)?$member->nickname:'', 
            'avatar'         => isset($member->avatar)?$member->avatar:'', 
        ];
        $token = TokenController::createToken($member_info);

        $data = [
            'member_info' => $member_info,
            'token' => $token,
        ];
        return renderData(0, $data);
    }

    public function checkStatus($brand_id){
        $info = TokenController::verifyToken($brand_id);
        if (empty($info)) {
            header('HTTP/1.0 401 Unauthorized');
            header('Content-type: application/json');
            return renderData(10004);
        }
        return renderData(0);
    }

    
}
