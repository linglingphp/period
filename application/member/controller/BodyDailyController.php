<?php

namespace app\member\controller;

use app\auth\controller\BaseController;
use app\common\model\BodyDaily;
use think\facade\Request;
use think\Validate;

class BodyDailyController extends BaseController
{
    
    public function get()
    {
        $params['date'] = Request::param('date', date('Y-m-d'));

        $where = [
            'date'      => $params['date'],
            'member_id' => $this->member_id,
        ];
        $bodydaily = BodyDaily::where($where)->find();
        
        return renderData(0, $bodydaily??[]);
    
    }

    public function edit()
    {
        $params = Request::only([
            'date', 
            'weight', 
            'spirit', 
            'power', 
            'shit_time', 
            'shit_type', 
            'dream_type', 
            'water', 
            'exercise', 
            'food'
            ]);
        $validate = Validate::make([
            'date'       => 'require|dateFormat:Y-m-d',
            'weight'     => 'require',
        ]);
        if (!$validate->check($params)) {
            return renderData(100, $validate->getError());
        }

        $where = [
            'date'      => $params['date'],
            'member_id' => $this->member_id,
        ];
        $bodydaily = BodyDaily::where($where)->find();
        
        $params['member_id'] = $this->member_id;
        $params['dt_edit'] = $params['dt_login'] = date('Y-m-d H:i:s') ;
        $params['ip'] = Request::ip();
        if(empty($bodydaily)){
            $params['dt_add'] = $params['dt_edit'];
            BodyDaily::create($params);
        }else{
            $bodydaily->save($params);
        }
        return renderData(0);
    }

   
}
