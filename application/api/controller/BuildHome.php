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

    /**
     * @param string $type 0 首页搜索  1 房友圈搜索
     * @param string $content 搜索内容
     * @param int $page 页码
     * @param int $pagesize 每页的条数
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function SerchInfo($type = '', $content = '', $page = 1, $pagesize = 5)
    {
        $pages = ($page - 1) * $pagesize;
        if ($type == '0') {
            $data = db('Build')
                ->where('bname like "%' . $content . '%"')
                ->limit($pages, $pagesize)
                ->select();
            foreach ($data as $k => $v) {
                $label = GetLabel($v);
                $v['label'] = $label;
                $logos = str2arr($v['logos']);
                $v['logos'] = $logos[0];
                $data[$k] = $v;
            }
        } else if ($type == '1') {
            $data = db('Dongtai')->field('id,uname,title,logo,create_time')
                ->where('title like "%' . $content . '%"')
                ->where('labelid', '<>', 2)
                ->limit($pages, $pagesize)
                ->select();
        } else {
            $data = [];
        }

        if ($data) {
            return json(array('code' => 200, 'msg' => '查询成功', 'data' => $data));
        } else {
            return json(array('code' => 402, 'msg' => '暂无数据', 'data' => []));
        }
    }


    /**
     * 获取热门关键字
     */
    public function GetKeywords()
    {
        $res = db('Keywords')->select();
        if ($res) {
            return json(['code' => 200, 'msg' => '请求成功', 'data' => $res]);
        } else {
            return json(['code' => 200, 'msg' => '暂无数据', 'data' => []]);
        }
    }
}

