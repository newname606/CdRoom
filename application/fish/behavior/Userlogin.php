<?php

namespace app\fish\behavior;
use think\Controller;

class Userlogin extends Controller
{
    public function run($params){

        /*$ip = request()->ip();
        $res = db("checkip")->where('ippath',$ip)->find();

        if(!$res){
            echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>页面错误</title></head><body><h1>404!</h1><span>你访问的页面不存在</span></body></html>';exit;
        }*/

        $arr = array('Login/index','Index/index','Gen/index','Reply/index','Dongtai/index');
        $controller = \request()->controller();
        $module = request()->module();
        $controller_name = $controller.'/index';

        $authority = db('Admin')->alias('a')
            ->field('a.id,a.role_id,b.menu_id')
            ->join('role b','a.role_id=b.id')
            ->where('a.id',session('id'))
            ->find();

        $menus = db("Menu")->field('id,name,path')->where('id','in',$authority['menu_id'])->select();

        foreach($menus as $menu){
            $arr[] = $menu['path'];
        }

        if ($module=='fish'){
            if(in_array($controller_name,$arr)){
                return true;
            }else{
                echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>页面错误</title></head><body><h1>404!</h1><span>你访问的页面不存在</span></body></html>';exit;
            }
        }

        /*elseif ($module == 'api'){
            $ip = get_ip();
            $res = isIp($ip);
            if(!$res){
                echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>页面错误</title></head><body><h1>404!</h1><span>你访问的页面不存在</span></body></html>';exit;
            }
        }*/
    }
}



