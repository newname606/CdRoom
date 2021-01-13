<?php


namespace app\api\controller;


use think\Controller;

class BuildDongtai extends Controller
{

    /*房友圈动态页
    $labelid*/
    public function HomeInfo($labelid = '',$page=1,$pagesize=5)
    {
        $res = db('Label')->where('id', $labelid)->find();
        $pages = ($page-1)*$pagesize;

//        dump($res);
        if ($res['name'] == '楼盘动态') {
            $dongtai = db('Dongtai')->alias('a')
                ->field('a.id,a.content,a.logo,a.create_time time,b.bname,a.roomid')
                ->join('build b', 'a.roomid=b.id')
                ->where('a.labelid like '.$labelid)
                ->limit($pages,$pagesize)
                ->select();
        } else {
            $dongtai = db('Dongtai')->alias('a')
                ->field('id,uname,title,logo,create_time time,roomid')
                ->where('labelid like '.$labelid)
                ->limit($pages,$pagesize)
                ->select();
        }

        if ($dongtai) {
            return json(array('code' => 200, 'msg' => '请求成功', 'data' => $dongtai));
        } else {
            return json(array('code' => 200, 'msg' => '暂无动态', 'data' => []));
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
