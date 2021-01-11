<?php
namespace app\fish\behavior;
use think\Controller;

class Loginlog extends Controller
{
    public function run($parems){
        $data['ip'] = request()->ip();

        $data['create_time'] = time();
        $time = time()-3600*2;
        $res = db('log')->where('create_time','<=',$time)->where('ip',$data['ip']);
        if(!$res){
            db('log')->insert($data);
        }
    }
}

