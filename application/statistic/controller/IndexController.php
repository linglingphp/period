<?php

namespace app\statistic\controller;

use app\auth\controller\BaseController;
use app\common\model\BodyDaily;
use think\Controller;
use think\facade\Request;

class IndexController extends BaseController
{
   
    public function getPowerData()
    {
        $startDay = Request::param('date')?? date("Y-m");
        $endDay = date("Y-m-d", strtotime(" $startDay +1 month"));
        $where = [
            'member_id' => $this->member_id,
        ];
        $bodydaily = BodyDaily::where($where)
            ->whereTime('date', '>=', $startDay)
            ->whereTime('date', '<', $endDay)
            ->order('date', 'asc')
            ->select();

        if(empty($bodydaily)){
            return renderData(0,[]);
        }
        $data = [];
        $not_exercise_percent = $exercise_percent = 0;
        foreach($bodydaily as $v){
            $data[] = [
                'date'  => $v['date'],
                'type'  => 'power',
                'value'   => $v[ 'power']
            ];
            $data[] = [
                'date'  => $v['date'],
                'type'  => 'period',
                'value'   => $v[ 'is_period']?60:0
            ];
            // $data[] = [
            //     'date'  => $v['date'],
            //     'type'  => 'exercise',
            //     'value'   => $v[ 'is_exercise']?20:0
            // ];
            $data[] = [
                'date'  => $v['date'],
                'type'  => 'weight',
                'value'   => $v[ 'weight']
            ];
            $v['is_exercise']? $exercise_percent++: $not_exercise_percent++;
        }
        //{ name: '锻炼', percent: 83.59 },
        //   { name: '未锻炼', percent: 2.17 }
        $data = [
            'data' => $data,
            'statisticData' => [
                ['name' => '锻炼', 'percent' => $exercise_percent],
                ['name' => '未锻炼', 'percent' => $not_exercise_percent],
            ]
        ];
        return renderData(0, $data ?? []);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
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
