<?php

namespace app\common\model;

use think\Model;

class Reply extends Model
{
    protected $update_time = false;

    /**
     * @param string $buildid 楼盘编号
     * @param string $userid 用户编号
     * @param string $state 状态 0默认查询 1按时间查询
     * @param int $page
     * @param int $pagesize
     */

    public function GetComment($buildid = '', $userid = '', $state = '', $page = '', $pagesize = '')
    {
        $pages = ($page - 1) * $pagesize;
        if ($state == 0) {
            $data = db('Comment')->alias('a')
                ->field('a.id,a.heart,a.content,a.create_time as time,b.uname,b.logo')
                ->join('UserInfo b', 'a.userid=b.id')
                ->where('a.roomid', $buildid)
                ->limit($pages, $pagesize)
                ->select();
        } else if ($state == 1) {
            $data = db('Comment')->alias('a')
                ->field('a.id,a.heart,a.content,a.create_time as time,b.uname,b.logo')
                ->join('UserInfo b', 'a.userid=b.id')
                ->where('a.roomid', $buildid)
                ->order('a.create_time desc')
                ->limit($pages, $pagesize)
                ->select();
        }

        foreach ($data as $k => $v) {
            /*处理用户是否点赞*/
            $heart = str2arr($v['heart']);
            if (in_array($userid, $heart)) {
                $v['heart'] = 1;/*1点赞0未点赞*/
            } else {
                $v['heart'] = 0;
            }
            $v['heartnum'] = count(array_filter($heart));

            /*处理评论回复内容*/
            $reply = db('Reply')
                ->field('id,commentid,username,replyname,content')
                ->where('commentid', $v['id'])
                ->select();
            $v['replynum'] = count($reply);
            foreach ($reply as $key => $value) {
                if ($value == '' || $value == null) {
                    unset($value['replyname']);/*如果没有回复名,默认为一级回复*/
                }
                $reply[$k] = $value;
            }
            $v['reply'] = $reply;
            $data[$k] = $v;
        }

        return $data;
    }

}