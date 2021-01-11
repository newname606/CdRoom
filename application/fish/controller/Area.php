<?php

namespace app\fish\controller;

class Area extends Base{
    protected  $title = '区管理';
    protected  $controller_name = "Area";
    public function __index_data()
    {
       $rows = model('Area')->alias('a')
           ->field('a.*,b.name as cname')
           ->join('city b','a.cityid=b.id')
           ->paginate();
       $this->assign('rows',$rows);
    }

    public function __save_data()
    {
        $citys = model('City')->select();
        $this->assign('citys',$citys);

    }
}

