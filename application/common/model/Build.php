<?php

namespace app\common\model;

use think\Model;

class Build extends Model
{
    protected $update_time = false;

    /*楼盘信息接口*/
    public function BuildInfo($buildid = '',$userid='')
    {
        $buildInfo = db('Build')->where('id', $buildid)->find();/*查询出楼盘详细信息*/
//        $buildInfo['create_time'] = date('Y-m-d', $buildInfo['create_time']);
        $label = GetLabel($buildInfo);
        $number = db('Comment')->where('roomid',$buildid)->count();/*评论数量*/
        /*标签*/
        $buildInfo['label'] = $label;
        $buildInfo['logos'] = str2arr($buildInfo['logos']);
        $buildInfo['number'] = $number; /*评论数*/;

        $userinfo = db('UserInfo')->where('id',$userid)->field('id,ulike')->find();
        $arr = str2arr($userinfo['ulike']);/*关注的楼盘ID*/
        if(in_array($buildid,$arr)){
            $buildInfo['like'] = 1;/*关注了like为1*/
        }else{
            $buildInfo['like'] = 0;
        }

        return $buildInfo;
    }
}