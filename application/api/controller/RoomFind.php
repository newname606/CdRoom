<?php


namespace app\api\controller;


use think\Controller;

class RoomFind extends Controller
{

    /*获取筛选信息*/
    public function GetBuildSort(){
        $Info = model('RoomFind')->GetInfo();
        if ($Info){
            return json(array('code'=>200,'msg'=>'请求成功','data'=>$Info));
        }else{
            return json(array('code'=>402,'msg'=>'请求失败,请稍后再试'));
        }
    }

    /**
     * 楼盘筛选获取详细信息
     * @param array $data
     * @param string $areaid 面积编号
     * @param string $typeid 类型编号
     * @param string $city 城市
     * @param string $zgxiuid 装修编号
     * @param string $sortid 户型分类编号
     * @param string $pricestate 价格状态
     * @param string $totalid 总价编号
     * @param string $unitid 单价编号
     * @return bool|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function GetDetailInfo(){
        $data = input('post.');
        $Info = model('RoomFind')->GetBuildInfo($data);
        if($Info){
            return json(array('code'=>200,'msg'=>'请求成功','data'=>$Info));
        }else{
            return json(array('code'=>200,'msg'=>'暂无数据','data'=>[]));
        }
    }
}
