<?php

namespace app\fish\controller;

use think\Controller;
use think\Request;

class Build extends Controller
{
    protected $title = '楼盘管理';
    protected $controller_name = "Build";

    public function index()
    {
        $rows = model('Build')->alias('a')
            ->field('a.id,a.bname,a.labelid,a.path,u.name unit_name,t.name total_name,a.phone,f.name s_name,a.logos,a.build_logo,a.create_time,c.area,d.name z_name')
            ->join('BuildArea c', 'a.areaid=c.id')
            ->join('BuildZgxiu d', 'a.zgxiuid=d.id')
            ->join('Sort f', 'a.sortid=f.id')
            ->join('UnitPrice u', 'a.unitid=u.id')
            ->join('TotalPrice t', 'a.totalid=t.id')
            ->paginate();
        $labels = model('BuildLabel')->field('id,name')->select();/*楼盘标签*/
        $arr = [];

        foreach ($rows as $k => $v) {
            $l_name = '';
            $label_id = explode(',', $v['labelid']);/*楼盘标签*/
            foreach ($labels as $label) {
                if (in_array($label['id'], $label_id)) {
                    $l_name .= $label['name'] . ',';/*拼接标签*/
                }
            }
            /*删除标签的最后一个逗号*/
            $l_name = substr($l_name, 0, strlen($l_name) - 1);
            $arr = explode(',', $v['logos']);/*把楼盘图片的字符串转为数组*/
            $v['logos'] = $arr;
            $v['l_name'] = $l_name;
            $rows[$k] = $v;
        }

        $count = model($this->controller_name)->count();
        $this->assign([
            'count' => $count,
            'rows' => $rows,
        ]);
        return $this->fetch();
    }

    public function save($id = '')
    {
        if (request()->isPost()) {
            $data = input('post.');

            $data['labelid'] = implode(',', $data['labelid']);
            $area = $data['path'] . $data['bname'];
            $result = getLonLLat($area);/*根据城市加楼盘获取经纬度*/
            if ($result) {
                $data['lng'] = $result['lng'];
                $data['lat'] = $result['lat'];
            }

            $data['sortid'] = arr2str($data['sortid']);
            $data['typeid'] = arr2str($data['typeid']);

            foreach ($data as $k => $v) {
                if ($k == 'id') {
                    continue;
                } else {
                    if ($v == null || $v == '') {
                        return json(array('status' => -2, 'msg' => '数据不能为空'));
                    }
                }
            }

            $request = Request::instance();

            /*多图拼接字符串*/
            $logo = $request->file('build_logo');

            if ($logo) {
                $data['build_logo'] = image($logo);
            }else {
                if ($id) {
                    $res = db($this->controller_name)->find($id);
                    $data['build_logo'] = $res['build_logo'];
                }
            }

            /*多图拼接字符串*/
            $logos = $request->file('logos');
            if ($logos) {
                $data['logos'] = images($logos);
            } else {
                if ($id) {
                    $res = db($this->controller_name)->find($id);
                    $data['logos'] = $res['logos'];
                }
            }

            //添加和修改
            if (empty($id)) {
                //添加时间
                $data['create_time'] = time();
                unset($data['id']);
                $result = model($this->controller_name)->allowField(true)->insert($data);
            } else {
                $result = model($this->controller_name)->update($data);
            }
            if ($result) {
                return json(array('status' => 1, 'msg' => '编辑成功'));
            } else {
                return json(array('status' => -1, 'msg' => '编辑失败'));
            }
        }
        $this->__save_data();
        if (!empty($id)) {
            $row = model($this->controller_name)->find($id);
            $this->assign('row', $row);
        }
        return $this->fetch();
    }

    /*删除单条数据*/
    public function del($id)
    {
        $result = model($this->controller_name)->where('id', $id)->delete();
        if ($result) {
            return json(array('status' => 1, 'msg' => '删除成功'));//删除成功
        } else {
            return json(array('status' => 0, 'msg' => '删除失败'));//删除失败
        }
    }

    /*删除多条数据*/
    public function delall($id)
    {
        $res = model($this->controller_name)->where('id', 'in', $id)->delete();
        if ($res) {
            return 1;
        } else {
            return -1;
        }
    }

    public function __save_data()
    {
        $areas = model("BuildArea")->select();/*面积*/
        $labels = model("BuildLabel")->select();/*关键字标签*/
        $types = model("BuildType")->select();/*户型*/
        $zgxius = model('BuildZgxiu')->select();/*装修*/
        $sorts = model('Sort')->select();/*装修*/
        $units = model('UnitPrice')->select();/*装修*/
        $totals = model('TotalPrice')->select();/*装修*/
        $id = input('id');
        if (!empty($id)) {
            /*查询出标签,户型,分类编号*/
            $authority = db('Build')
                ->field('labelid,sortid,typeid')
                ->where('id', $id)
                ->find();

            $this->assign([
                'authlabel'=>explode(',', $authority['labelid']),
                'authsort'=>explode(',', $authority['sortid']),
                'authtype'=>explode(',', $authority['typeid']),
            ]);
        } else {
            $this->assign([
                'authlabel'=>'',
                'authsort'=>'',
                'authtype'=>'',
            ]);
        }
        $this->assign([
            'areas' => $areas,
            'labels' => $labels,
            'types' => $types,
            'zgxius' => $zgxius,
            'sorts' => $sorts,
            'units' => $units,
            'totals' => $totals,
        ]);

    }

    /*详情页*/
    public function detail($id = '')
    {

        /*查询出楼盘的详情*/
        $row = model('Build')->find($id);
        $this->assign('row', $row);

        return $this->fetch();
    }

}

