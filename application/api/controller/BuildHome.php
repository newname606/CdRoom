<?php


namespace app\api\controller;

use think\Controller;

class BuildHome extends Controller
{
    /*获取首页信息接口*/
    public function BuyBuildInfo($city = '', $page = '', $pagesize = '')
    {
        $data['buybuild'] = model('GetBuild')->GetBuild($city, $page, $pagesize);/*获取在售楼盘信息*/

        if ($data) {
            return json(array('code' => 200, 'msg' => '请求成功', 'data' => $data));
        } else {
            return json(array('code' => 402, 'msg' => '请稍后再试', 'data' => []));
        }
    }

    /*获取首页轮播图接口*/
    public function LunboInfo()
    {
        $data['lunbo'] = db('LunboMap')->select();/*查询出所有轮播图片*/

        if ($data) {
            return json(array('code' => 200, 'msg' => '请求成功', 'data' => $data));
        } else {
            return json(array('code' => 402, 'msg' => '请稍后再试', 'data' => []));
        }
    }

    /*获取首页热门楼盘接口*/
    public function HotBuildInfo($city = '')
    {
        $data['hotbuild'] = model('GetBuild')->getInfo($city);/*获取热门楼盘信息*/

        if ($data) {
            return json(array('code' => 200, 'msg' => '请求成功', 'data' => $data));
        } else {
            return json(array('code' => 402, 'msg' => '请稍后再试', 'data' => []));
        }
    }

    /*搜索框
    type 0 首页搜索  1 房友圈搜索
    state 0 楼盘动态 1 热门文章
    page 第几页
    pagesize 一页多少条
    */
    public function SerchInfo($type = '', $content = '', $state = '', $page = 1, $pagesize = 5)
    {
        $pages = ($page - 1) * $pagesize;
        if ($type == '0') {

            $data = db('Build')->where('bname like "%' . $content . '%"')->limit($pages, $pagesize)->select();

            foreach ($data as $k => $v) {
                $label = GetLabel($v);
                $v['label'] = $label;
                $logos = str2arr($v['logos']);
                $v['logos'] = $logos[0];
                $data[$k] = $v;
            }
        } else if ($type == '1') {
            if ($state == '0') {
                $data = db('Dongtai')->alias('a')
                    ->field('a.id,a.create_time,a.content,b.bname')
                    ->join('Build b', 'a.roomid=b.id')
                    ->where('b.bname like "%' . $content . '%"')
                    ->limit($pages, $pagesize)
                    ->select();
            } else if ($state == '1') {
                $data = db('Dongtai')->field('id,uname,title,logo,create_time')
                    ->where('title like "%' . $content . '%"')
                    ->limit($pages, $pagesize)
                    ->select();
            } else {
                $data = [];
            }

        } else {
            $data = [];
        }

        if ($data) {
            return json(array('code' => 200, 'msg' => '查询成功', 'data' => $data));
        } else {
            return json(array('code' => 402, 'msg' => '请稍后再试', 'data' => []));
        }
    }
}

