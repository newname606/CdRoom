<?php

namespace app\api\controller;
use think\Controller;

class System extends Controller
{
    /**
     * 获取帮助中心接口
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */

    public function GetHelpInfo(){
        $data = db('HelpCenter')->select();
        if($data){
            return json(array('code'=>200,'msg'=>'请求成功','data'=>$data));
        }else{
            return json(array('code'=>402,'msg'=>'暂无数据','data'=>[]));
        }
    }

    /**
     * 获取小程序信息
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */

    public function GetInfo(){
        $data = db('System_setting')->find();
        if($data){
            return json(array('code'=>200,'msg'=>'请求成功','data'=>$data));
        }else{
            return json(array('code'=>402,'msg'=>'暂无数据','data'=>[]));
        }
    }

    /**
     * 联系我们
     * @param string $type
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function GetOtherInfo($type=''){
        if($type == '1'){/*商务合作*/
            $data = db('Hezuo')->find();
        }else if($type == '2'){/*联系客服*/
            $data = db('Contact')->find();
        }elseif($type == '3'){/*加入我们*/
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

