<?php

namespace app\auth\controller;

use think\Controller;
use app\auth\controller\TokenController;
use app\common\model\Member;
use app\common\model\MemberMp;
use think\facade\Request;

class AuthController extends Controller
{
   
    public function auth($brand_id)
    {
        $params = Request::param();
       
        $openid = $params['openid'];
        $where = [
            'openid' => $openid
        ];
        $memberMp = MemberMp::where($where)->find();
        if(!$memberMp->id){
            $memberMp->brand_id = $brand_id;
            $memberMp->openid = $openid;
            $memberMp->dt_add = date('Y-m-d H:i:s');
            $memberMp->save();
        }

        if($memberMp->member_id){
            $member = Member::where(['id' => $memberMp->member_id])->find();
            $member->dt_login = date('Y-m-d H:i:s');
            $member->save();
        }
        
         //验证信息正确，生成用户token
        $member_info = [
            'brand_id'       => $brand_id,
            'member_mp_id'   => $memberMp->id,
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
