<?php

namespace app\fish\controller;

use think\Controller;

class Index extends Controller
{
    function _initialize()
    {
        if (session('uname') == null) {
            $this->error('请先登录', url("Login/index"));
            exit;
        }
    }

    /*首页*/
    public function index()
    {
        /*导航列表*/
        $uname = session('uname');
        $user = db("Admin")->alias('a')
            ->field('a.id,a.role_id,b.menu_id')
            ->join('role b', 'a.role_id=b.id')
            ->where('a.username', '=', $uname)
            ->find();
        $menu_id = $user['menu_id'];

        $navs = db("menu")
            ->alias('a')
            ->field('b.id,b.name')
            ->join('nav b', 'a.nav_id=b.id')
            ->where('a.id', 'in', $menu_id)
            ->group('b.id')
            ->select();

        $menus = db("menu")
            ->field('id,name,nav_id,path')
            ->where('id', 'in', $menu_id)
            ->select();

        $this->assign([
            'navs' => $navs,
            'menus' => $menus,
        ]);

        return $this->fetch();
    }

    /*欢迎*/
    public function welcome()
    {
        return $this->fetch();
    }

    /*退出登录*/
    public function logout()
    {
        session('uname', null);
        $this->success("退出成功", url('Login/index'));
        exit();
    }

    /*切换用户*/
    public function change()
    {
        session('uname', null);
        $this->success("切换成功", url('Login/index'));
        exit();
    }
}

