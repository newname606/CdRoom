<?php


namespace app\common\model;


use think\Db;
use think\Model;

class RoomFind extends Model
{
    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取楼盘信息接口
     */
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

    /**
     * 楼盘筛选获取详细信息
     * @param array $data
     * @param string $areaid 面积编号
     * @param string $typeid 类型编号
     * @param string $city 城市
     * @param string $zgxiuid 装修编号
     * @param string $sortid 户型分类编号
     * @param string $pricestate 价格状态
     * @param string $totalid 总价编号
     * @param string $unitid 单价编号
     * @return bool|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
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

    /**
     * @param $where
     * @param $data
     * @return mixed
     * 面积筛选
     */
    public function area($where,$data){
        /*是否传入面积*/
        if($data['areaid']){
            $where['areaid'] = ['in',$data['areaid']];
        }
        return $where;
    }

    /**
     * @param $data
     * @return false|string|null
     * 户型筛选
     */
    public function type($data){
        /*是否传入户型编号*/
        $map1 = null;
        if($data['typeid']){
            $type = str2arr($data['typeid']);
            foreach($type as $k=>$v){
                $v = '%'.$v.'%';
                $map1 .= ' typeid LIKE "'.$v.'" or';
            }
            $map1  = substr($map1,0,strlen($map1)-3);
        }

        return $map1;
    }

    /**
     * @param $where
     * @param $data
     * @return mixed
     * 装修
     */
    public function zgxiu($where,$data){
        /*是否传入装修编号*/
        if($data['zgxiuid']){
            $where['zgxiuid'] = ['in',$data['zgxiuid']];
        }
        return $where;
    }

    /**
     * @param $where
     * @param $data
     * @return mixed
     * 价格筛选
     */
    public function price($where,$data){
        /*是否传入户型编号  0 总价 1单价*/
            if($data['pricestate'] == '0'){
                $where['totalid'] = $data['totalid'];
            }else if($data['pricestate'] == '1'){
                $where['unitid'] = $data['unitid'];
            }

        return $where;
    }

    /**
     * @param $where
     * @param $data
     * @return mixed
     * 区域
     */
    public function city($where,$data){
        /*是否传入户型编号*/
        if($data['city']){
            $where['path'] = ['like','%'.$data['city'].'%'];
        }
        return $where;
    }

    /**
     * @param $data
     * @return false|string|null
     * 标签
     */
    public function label($data){
        /*是否传入户型编号*/
        $map = null;
        if($data['labelid']){
            $label = str2arr($data['labelid']);

            foreach($label as $k=>$v){
                $v = '%'.$v.'%';
                $map .= ' sortid LIKE "'.$v.'" or';
            }
            $map  = substr($map,0,strlen($map)-3);
        }
        return $map;
    }

    /**
     * @param $Info
     * @return array
     * 数组排序
     */
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

