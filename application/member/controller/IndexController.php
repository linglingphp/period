<?php

namespace app\member\controller;

use app\auth\controller\BaseController;
use app\common\model\Member;
use think\facade\Request;
use think\Validate;

class IndexController extends BaseController
{
  
    public function get()
    {
        $member = Member::where('id',$this->member_id)->find();
        if(empty($member)){
            return \renderData(100,'会员信息有误');
        }
        return renderData(0, $member);
    }

    public function edit()
    {
        $params = Request::only(['name', 'phone', 'nickname', 'avatar', 'age', 'sex']);
        $validate = Validate::make([
            'name'      => 'chsAlphaNum|min:1',
            'phone'     => 'mobile',
            'nickname'  => 'min:6',
            'avatar'    => 'min:6',
            'age'       => 'number|between:1,120',
            'sex'       => 'in:male,female,secret',
        ]);
        if (!$validate->check($params)) {
            return renderData(100, $validate->getError());
        }
        $member = Member::where('id',$this->member_id)->find();
        if(empty($member)){
            return \renderData(100,'会员信息有误');
        }
        //您真是天才可以访问俺老孙的信息
        $params['dt_add'] = $params['dt_edit'] = $params['dt_login'] = date('Y-m-d H:i:s') ;
        $params['ip'] = Request::ip();
        $member = $member->save($params);
        // echo Member::getLastSql();die;
        return renderData(0);
    }

}
