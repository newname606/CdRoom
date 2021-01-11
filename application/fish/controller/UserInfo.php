<?php

namespace app\fish\controller;

class UserInfo extends Base{
    protected  $title = '用户信息管理';
    protected  $controller_name = "UserInfo";

    /*改变状态启用*/
    public function statestart($id){
        $res = model('UserInfo')->where('id',$id)->setField('state',1);;
        if($res){
            return json(1);
        }else{
            return json(-1);
        }
    }

    /*改变状态启用*/
    public function statestop($id){
        $res = model('UserInfo')->where('id',$id)->setField('state',0);;
        if($res){
            return json(1);
        }else{
            return json(-1);
        }
    }
}

