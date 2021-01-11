<?php


namespace app\api\controller;


use think\Controller;

class BuildDongtai extends Controller
{

    /*房友圈动态页
    $labelid*/
    public function HomeInfo($labelid = '')
    {
        $res = db('Label')->where('id', $labelid)->find();

        if ($res['name'] == '楼盘动态') {
            $dongtai = db('Dongtai')->alias('a')
                ->field('a.id,a.content,a.logo,a.create_time time,b.bname')
                ->join('build b', 'a.roomid=b.id')
                ->select();
        } else {
            $dongtai = db('Dongtai')
                ->field('id,uname,title,logo,create_time time')
                ->select();
        }

        if ($dongtai) {
            return json(array('code' => 200, 'msg' => '请求成功', 'data' => $dongtai));
        } else {
            return json(array('code' => 402, 'msg' => '暂无动态', 'data' => []));
        }
    }

    /*楼盘动态详情页*/
    public function BuildDetail($id = '')
    {
        if ($id) {
            $dongtai = db('Dongtai')->find($id);
            return json(array('code' => 200, 'msg' => '请求成功', 'data' => $dongtai));
        } else {
            return json(array('code' => 500, 'msg' => '数据错误,请稍后再试', 'data' => []));
        }
    }
}
