<?php
namespace app\common\model;
use think\Model;

class GetBuild extends Model
{
    /*获取热门楼盘信息*/
    public function getInfo($city='')
    {
        $buildnum = db('Comment')->field('COUNT(roomid) as max,roomid')
            ->order('max desc')->group('roomid')->limit(0, 4)
            ->select();
        $buildInfo = [];
        $l_name = '';

        foreach ($buildnum as $k => $v) {
            $Info = db('Build')->alias('a')
                ->field('a.id,a.bname,a.logos,b.name avg_price,a.price,a.path,a.labelid')
                ->join('UnitPrice b','a.unitid=b.id')
                ->where('a.id', $v['roomid'])
                ->order('a.path like "%'.$city.'%" desc')
                ->find();
            $l_name = GetLabel($Info);
            unset($Info['labelid']);/*删除标签编号*/
            $arr = explode(',', $Info['logos']);/*把楼盘图片的字符串转为数组*/
            $Info['logos'] = $arr[0];
            $Info['labelname'] = $l_name;
            if ($Info['logos']){
                $buildInfo[] = $Info;
            }
        }
        return $buildInfo;
    }

    /*获取在售楼盘信息*/
    public function GetBuild($city='',$page='',$pagesize='')
    {
        /*查询多少条*/
        $num = $page-1;
        $offset = $num*$pagesize;
        $Build = db('Build')->alias('a')
            ->field('a.id,a.bname,a.logos,c.name avg_price,price,a.path,a.labelid,b.name')
            ->join('BuildLabel b', 'a.labelid=b.id')
            ->join('UnitPrice c', 'a.unitid=c.id')
            ->where('b.name', '在售')
            ->order('a.path like "%'.$city.'%" desc')
            ->limit($offset,$pagesize)
            ->select();

        foreach ($Build as $k => $v) {
            $v['labelname'] = GetLabel($v);/*获取标签*/
            unset($v['labelid']);/*删除标签编号*/
            $arr = explode(',', $v['logos']);/*把楼盘图片的字符串转为数组*/
            $v['logos'] = $arr[0];
            $Build[$k] = $v;
        }

        return $Build;
    }
}

