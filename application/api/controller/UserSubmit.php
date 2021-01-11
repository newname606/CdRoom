<?php


namespace app\api\controller;


use think\Controller;

class UserSubmit extends Controller
{

    /*用户提交买房和卖房信息接口
    type  0  买房
    type  1  卖房
    */
    public function RoomSubmit()
    {
        $data = input('post.');
        $type = $data['type'];
        unset($data['type']);
        $insert_data = $data;
        $insert_data['create_time'] = time();
        if ($type == '0') {
            $res = model('UserBuy')->insert($insert_data);
        } else if ($type == '1') {
            $res = model('UserSell')->insert($insert_data);
        } else {
            return json(array('code'=>500,'msg'=>'数据错误,请稍后再试'));
        }
        if($res){
            return json(array('code'=>200,'msg'=>'提交成功'));
        }else{
            return json(array('code'=>402,'msg'=>'提交失败,请稍后再试'));
        }
    }

    /*用户提交问题反馈接口
    summary 问题描述
    logo 图片
    phone 手机号
    */
    public function Question_Fback(){
        $data = input('post.');
        if($data){
            $data['create_time'] = time();
            $res = db('Question_feedback')->insert($data);
            return json(array('code'=>200,'msg'=>'提交成功'));
        }else{
            return json(array('code'=>402,'msg'=>'请稍后再试'));
        }
    }
}

