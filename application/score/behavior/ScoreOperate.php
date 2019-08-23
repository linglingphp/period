<?php

namespace app\score\behavior;
use app\common\model\MemberMp;
use app\common\model\Score;
use think\facade\Validate;


class ScoreOperate
{
    public function run($params){
        $validate = Validate::make([
            'member_mp_id' => 'require|integer',
            'member_id'    => 'require|integer',
            'score'        => 'require|integer',
            'type'         => 'require|in:recharge,withdraw',
            'from'         => 'require|integer',
            'message'      => 'require',
        ]);
        $result = $validate->check($params);
        if(!$result ){
            return 100;
        }

        Db::startTrans();
        try {
            Score::create($params);
            if($params['type'] == 'recharge'){
                MemberMp::where(['id'=>$params['member_mp_id']])->setInc('score', $params['score']);
            }else{
                MemberMp::where(['id'=>$params['member_mp_id']])->setDesc('score', $params['score']);
            }
            Db::commit();
        } catch(Exception $e){
            Db::rollback();
        }
        
        return 0;
    }

}