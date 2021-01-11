<?php

namespace app\fish\controller;

class Menu extends Base{
    protected  $title = '菜单';
    protected  $controller_name = "Menu";

    protected function __index_data()
    {
        $rows = db("Menu")->alias('a')
            ->field('a.id,a.name m_name,b.name n_name,a.path,a.create_time')
            ->join('nav b','a.nav_id=b.id')
            ->paginate();
        $this->assign('rows',$rows);
    }

    protected function __save_data()
    {
        $navs = db("Nav")->select();

        $this->assign('navs',$navs);
    }
}

