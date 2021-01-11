<?php


namespace app\common\model;


use think\Db;
use think\Model;

class RoomFind extends Model
{
    /*获取筛选信息*/
    public function GetInfo(){
        $Info['BuildType'] = db('BuildType')->field('id,type name')->select();/*户型*/
        $Info['BuildArea'] = db('BuildArea')->field('id,area name')->select();/*面积*/
        $Info['BuildZgxiu'] = db('BuildZgxiu')->select();/*装修风格*/
        $Info['TotalPrice'] = db('TotalPrice')->select();/*总价*/
        $Info['UnitPrice'] = db('UnitPrice')->select();/*单价*/
        $Info['label'] = db('Sort')->select();
        $city = db('Area')->alias('a')
            ->field('a.id,a.name,b.name cityname')
            ->join('city b','a.cityid=b.id')
            ->select();

        foreach($city as $v)
            $res[$v['cityname']][] = $v;

        $arr = [];

        foreach($res as $k=>$v){

            $title = $v[0]['cityname'];
            $array['title'] = $title;
            $array['children'] = $v;
            $arr[]=$array;
        }

        $Info['city'] = $arr;
        $Info = $this->ArrInfo($Info);


        return $Info;
    }

    /*楼盘筛选获取详细信息
    $areaid,面积编号
    $typeid  户型编号 数组
    $city='', 区域
    $zgxiuid='', 装修
    $page=1,
    $pagesize=5
    $sortid = ''户型分类编号数组

    minprice maxprice
    $pricestate='', 0 总价 1 单价
    $labelid  标签编号 数组
    */
    public function GetBuildInfo($data){

        $pages = ($data['page']-1)*$data['pagesize'];
        $where = array();

        $where = $this->area($where,$data);/*面积*/
        $where = $this->zgxiu($where,$data);/*装修*/
        $where = $this->city($where,$data);/*区域*/
        $where = $this->price($where,$data);/*价格*/
        $map1 = $this->type($data);/*户型*/
        $map = $this->label($data);/*标签*/

        $Info = db('Build')->field('id,logos,labelid,price,path,bname,price')
            ->where($where)
            ->where($map)
            ->where($map1)
            ->limit($pages,$data['pagesize'])
            ->select();
        foreach($Info as $k=>$v){
            $v['label'] = GetLabel($v);
            $logos = str2arr($v['logos']);
            $v['logos'] = $logos[0];
            $Info[$k] = $v;
        }
//        dump($Info);die;
        return $Info;
    }

    /*面积筛选*/
    public function area($where,$data){
        /*是否传入面积*/
        if($data['areaid']){
            $where['areaid'] = ['in',$data['areaid']];
        }
        return $where;
    }

    /*户型*/
    public function type($data){
        /*是否传入户型编号*/
        if($data['typeid']){
            $type = str2arr($data['typeid']);
            $map = '';
            foreach($type as $k=>$v){
                $v = '%'.$v.'%';
                $map .= ' typeid LIKE "'.$v.'" or';
            }
            $map  = substr($map,0,strlen($map)-3);
        }
        return $map;
    }

    /*户型*/
    public function zgxiu($where,$data){
        /*是否传入户型编号*/
        if($data['zgxiuid']){
            $where['zgxiuid'] = ['in',$data['zgxiuid']];
        }
        return $where;
    }

    /*价格*/
    public function price($where,$data){
        /*是否传入户型编号  0 总价 1单价*/
            if($data['pricestate'] == '0'){
                $where['totalid'] = $data['totalid'];
            }else if($data['pricestate'] == '1'){
                $where['unitid'] = $data['unitid'];
            }

        return $where;
    }

    /*区域*/
    public function city($where,$data){
        /*是否传入户型编号*/
        if($data['city']){
            $where['path'] = ['like','%'.$data['city'].'%'];
        }
        return $where;
    }

    /*标签*/
    public function label($data){
        /*是否传入户型编号*/
        if($data['labelid']){
            $label = str2arr($data['labelid']);
            $map = '';
            foreach($label as $k=>$v){
                $v = '%'.$v.'%';
                $map .= ' sortid LIKE "'.$v.'" or';
            }
            $map  = substr($map,0,strlen($map)-3);
        }
        return $map;
    }

    /*处理数组*/
    public function ArrInfo($Info){
        $Infos[0]['title'] = '区域';
        $Infos[0]['children'] = $Info['city'];
        $chileren = array();
        $total['title'] = '总价';
        $total['children'] = $Info['TotalPrice'];
        $unit['title'] = '单价';
        $unit['children'] = $Info['UnitPrice'];
        $chileren['TotalPrice'] = $Info['TotalPrice'];
        $chileren['UnitPrice'] = $Info['UnitPrice'];
        $Infos[1]['title'] = '价格';
        $Infos[1]['children'][] = $total;
        $Infos[1]['children'][] = $unit;
        $Infos[2]['title'] = '户型';
        $Infos[2]['children'] = $Info['BuildType'];
        $Infos[3]['title'] = '面积';
        $Infos[3]['children'] = $Info['BuildArea'];
        $Infos[4]['title'] = '装修';
        $Infos[4]['children'] = $Info['BuildZgxiu'];
        $Infos[5]['title'] = '标签';
        $Infos[5]['children'] = $Info['label'];
        return $Infos;
    }
}

