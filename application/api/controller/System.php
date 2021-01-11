<?php

namespace app\api\controller;
use think\Controller;

class System extends Controller
{
    /*获取常见问题接口*/
    public function GetHelpInfo(){
        $data = db('HelpCenter')->select();
        if($data){
            return json(array('code'=>200,'msg'=>'请求成功','data'=>$data));
        }else{
            return json(array('code'=>402,'msg'=>'暂无数据','data'=>[]));
        }
    }

    /*获取小程序*/
    public function GetInfo(){
        $data = db('System_setting')->find();
        if($data){
            return json(array('code'=>200,'msg'=>'请求成功','data'=>$data));
        }else{
            return json(array('code'=>402,'msg'=>'暂无数据','data'=>[]));
        }
    }

    /*商务合作
    type  1商务合作 2 联系客服 3 加入我们
    */
    public function GetOtherInfo($type=''){
        if($type == '1'){
            $data = db('Hezuo')->find();
        }else if($type == '2'){
            $data = db('Contact')->find();
        }elseif($type == '3'){
            $data = db('Join')->find();
        }else{
            $data = [];
        }

        if($data){
            return json(array('code'=>200,'msg'=>'请求成功','data'=>$data));
        }else{
            return json(array('code'=>402,'msg'=>'暂无数据','data'=>[]));
        }
    }


}

