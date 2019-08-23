<?php

namespace app\member\controller;

use think\Controller;
use app\common\model\Member;
use think\facade\Request;
use think\Validate;

class EnrollController extends Controller
{
  
    public function enroll()
    {
        $params = Request::only(['username', 'password', 'name', 'phone', 'nickname', 'avatar', 'age', 'sex']);
        $validate = Validate::make([
            'username'  => 'require|alphaNum|min:3',
            'password'  => 'require|alphaDash|min:6',
            'name'      => 'chsAlphaNum|min:6',
            'phone'     => 'mobile',
            'nickname'  => 'min:6',
            'avatar'    => 'min:6',
            'age'       => 'number|between:1,120',
            'sex'       => 'in:male,female,secret',
        ]);
        if (!$validate->check($params)) {
            return renderData(100, $validate->getError());
        }
        $member = Member::where('username',$params['username'])->find();
        if(!empty($member)){
            return \renderData(100,'此用户名已被使用了呢');
        }
        $params['password'] = password_hash($params['password'], PASSWORD_DEFAULT);
        $params['dt_add'] = $params['dt_edit'] = $params['dt_login'] = date('Y-m-d H:i:s') ;
        $params['ip'] = Request::ip();
        $member = Member::create($params);
        return renderData(0);
    }

    
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
