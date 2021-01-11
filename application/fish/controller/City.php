<?php

namespace app\fish\controller;

class City extends Base{
    protected  $title = '省管理';
    protected  $controller_name = "City";

    /*改变状态启用*/
    public function statestart($id){
        $res = model('City')->where('id',$id)->setField('state',1);;
        if($res){
            return json(1);
        }else{
            return json(-1);
        }
    }

    /*改变状态启用*/
    public function statestop($id){
        $res = model('City')->where('id',$id)->setField('state',0);;
        if($res){
            return json(1);
        }else{
            return json(-1);
        }
    }
}

