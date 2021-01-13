<?php


namespace app\api\controller;

use think\Controller;

class BuildDetail extends Controller
{

    /**
     * 获取此楼盘所有户型图
     * @param string $buildid
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function GetHouseType($buildid = '')
    {
        if ($buildid) {
            $data = db('HouseType')->where('roomid', $buildid)->select();
            if ($data) {
                return json(array('code' => 200, 'msg' => '请求成功', 'data' => $data));
            } else {
                return json(array('code' => 402, 'msg' => '暂无数据', 'data' => []));
            }
        } else {
            return json(array('code' => 500, 'msg' => '数据错误,请稍后再试', 'data' => []));
        }
    }

    /**
     * 获取楼盘动态
     * @param string $buildid 楼盘编号
     * @param int $page 页码
     * @param int $pagesize 条数
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function GetDongtai($buildid = '', $page = 1, $pagesize = 5)
    {
        $pages = ($page-1)*$pagesize;
        $data = db('Dongtai')
            ->field('id,uname,title,content,logo,create_time as time')
            ->where('roomid', $buildid)
            ->order('time desc')
            ->limit($pages, $pagesize)
            ->select();
        if ($data) {
            return json(array('code' => 200, 'msg' => '请求成功', 'data' => $data));
        } else {
            return json(array('code' => 402, 'msg' => '暂无数据', 'data' => []));
        }
    }

    /**
     * 获取此楼盘评论
     * @param string $buildid 楼盘编号
     * @param string $userid 用户编号
     * @param string $state 状态 0默认查询 1按时间查询
     * @param int $page
     * @param int $pagesize
     * @return \think\response\Json
     */

    public function GetComment($buildid = '', $userid = '', $state = '', $page = 1, $pagesize = 5)
    {
        if ($buildid) {
            $data = model('Reply')->GetComment($buildid, $userid, $state, $page, $pagesize);
            if ($data) {
                return json(array('code' => 200, 'msg' => '请求成功', 'data' => $data));
            } else {
                return json(array('code' => 402, 'msg' => '暂无评论', 'data' => []));
            }
        } else {
            return json(array('code' => 500, 'msg' => '数据错误,请稍后再试', 'data' => []));
        }
    }

    /**
     * 获取评论详情
     * @param string $commentid 评论编号
     * @param string $userid 用户编号
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function CommentDetail($commentid='',$userid=''){
        $comment = db("Comment")->alias('a')
            ->field('a.id,a.content,a.heart,a.create_time time,b.uname,b.logo')
            ->where('a.id',$commentid)
            ->join('UserInfo b','a.userid=b.id')
            ->find();

        $heart = str2arr($comment['heart']);
        if (in_array($userid, $heart)) {
            $comment['heart'] = 1;/*1点赞0未点赞*/
        } else {
            $comment['heart'] = 0;
        }
        $comment['heartnum'] = count(array_filter($heart));

        /*处理评论回复内容*/
        $reply = db('Reply')
            ->field('id,commentid,username uname,replyname,content,create_time time,logo')
            ->where('commentid', $comment['id'])
            ->select();

        $comment['reply'] = $reply;
        return json(array('code'=>200,'msg'=>'请求成功','data'=>$comment));
    }

    /**
     * 楼盘信息接口
     * @param string $buildid 楼盘编号
     * @param string $userid 用户编号
     * @return \think\response\Json
     */
    public function BuildInfo($buildid = '', $userid = '')
    {
        if ($buildid) {
            $Info = model('Build')->BuildInfo($buildid, $userid);
            if ($Info) {
                return json(array('code' => 200, 'msg' => '请求成功', 'data' => $Info));
            } else {
                return json(array('code' => 402, 'msg' => '稍后再试', 'data' => []));
            }
        } else {
            return json(array('code' => 500, 'msg' => '数据错误,请稍后再试', 'data' => []));
        }
    }

    /**
     * 楼盘详情页接口
     * @param string $buildid 楼盘编号
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function BuildDetail($buildid = '')
    {
        if ($buildid) {
            $data = db('Build')->where('id', $buildid)->find();/*查询出楼盘详细信息*/
            $logo = str2arr($data['logos']);
            $data['logos'] = $logo[0];/*图片*/
            $data['create_time'] = date('Y-m-d', $data['create_time']);/*时间*/
            $data['labelname'] = GetLabel($data);/*标签*/
            foreach ($data as $k => $v) {/*删除不要的键*/
                if ($k == 'lng' || $k == 'lat' || $k == 'areaid' || $k == 'typeid' || $k == 'labelid' || $k == 'zgxiuid' || $k == 'build_logo') {
                    unset($data[$k]);
                }
            }
            if ($data) {
                return json(array('code' => 200, 'msg' => '请求成功', 'data' => $data));
            } else {
                return json(array('code' => 402, 'msg' => '暂无评论', 'data' => []));
            }
        } else {
            return json(array('code' => 500, 'msg' => '数据错误,请稍后再试', 'data' => []));
        }
    }
}

