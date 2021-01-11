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

    /*获取楼盘信息*/
    public function GetBuildInfo(){
        $data = input('post.');
        $data = model('RoomFind')->GetBuildInfo($data);
        $pages = ($data['page']-1)*$data['pagesize'];
        $data = db('Build')
            ->field('id,logos,path,bname,price,labelid')
            ->where('sortid',$data['sortid'])
            ->where('path like "%'.$data['city'].'%"')
            ->limit($pages,$data['pagesize'])->select();

        foreach($data as $k=>$v){
            $v['label'] = GetLabel($v);
            $logo = str2arr($v['logos']);
            $v['logos'] = $logo[0];
            $data[$k]=$v;
        }
        if ($data){
            return json(array('code'=>200,'msg'=>'请求成功','data'=>$data));
        }else{
            return json(array('code'=>402,'msg'=>'请求失败,请稍后再试'));
        }
    }

    /*楼盘筛选获取详细信息
    $sortid = ''户型分类编号数组
    totalid='',unitid='',价格 总价和单价
    $maxarea='',$minarea ,面积 最低面积和最高面积
    $pricestate='', 0 总价 1 单价
    $labelid  标签编号 数组
    $typeid  户型编号 数组
    $city='', 区域
    $page=1,
    $pagesize=5
    */
    public function GetDetailInfo(){
        $data = input('post.');
        $Info = model('RoomFind')->GetBuildInfo($data);
        if($Info){
            return json(array('code'=>200,'msg'=>'请求成功','data'=>$Info));
        }else{
            return json(array('code'=>402,'msg'=>'数据错误,请稍后再试','data'=>[]));
        }
    }
}
