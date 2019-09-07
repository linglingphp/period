<?php

namespace app\member\controller;

use app\auth\controller\BaseController;
use app\common\model\BodyDaily;
use think\facade\Request;
use think\Validate;

class BodyDailyController extends BaseController
{
    
    public function list()
    {
        $where = [
            'member_id' => $this->member_id,
        ];
        $bodydaily = BodyDaily::where($where)->order('date', 'desc')->select()->toArray();
        
        return renderData(0, $bodydaily??[]);
    
    }

    public function get()
    {
        $params['date'] = Request::param('date', date('Y-m-d'));

        $where = [
            'date'      => $params['date'],
            'member_id' => $this->member_id,
        ];
        $bodydaily = BodyDaily::where($where)->find();
        if(isset($bodydaily['is_exercise'])){
            $bodydaily['is_exercise'] = $bodydaily['is_exercise']?true:false;
            $bodydaily['is_pimple'] = $bodydaily['is_pimple']?true:false;
            $bodydaily['is_period'] = $bodydaily['is_period']?true:false;
            $bodydaily['is_study'] = $bodydaily['is_study']?true:false;
            $bodydaily['is_dream'] = $bodydaily['is_dream']?true:false;
            $bodydaily['is_beauty'] = $bodydaily['is_beauty']?true:false;
        }
        return renderData(0, $bodydaily??[]);
    
    }

    public function edit()
    {
        $params = Request::only([
            'date', 
            'weight', 
            'spirit', 
            'power', 
            'beauty', 
            'shit_time', 
            'shit_type', 
            'water', 
            'exercise', 
            'is_dream', 
            'is_exercise', 
            'is_pimple', 
            'is_period', 
            'is_study', 
            'is_beauty', 
            'item', 
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
        $params['is_dream'] = (isset($params['is_dream'])&&$params['is_dream']==='true')?1:0;
        $params['is_exercise'] = (isset($params['is_exercise'])&&$params['is_exercise']==='true')?1:0;
        $params['is_pimple'] = (isset($params['is_pimple'])&&$params['is_pimple']==='true')?1:0;
        $params['is_period'] = (isset($params['is_period'])&&$params['is_period']==='true')?1:0;
        $params['is_study'] = (isset($params['is_study'])&&$params['is_study']==='true')?1:0;
        $params['is_beauty'] = (isset($params['is_beauty'])&&$params['is_beauty']==='true')?1:0;
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
