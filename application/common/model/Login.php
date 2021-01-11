<?php

namespace app\common\model;
use think\Model;

class Login extends Model
{
    protected  $update_time = false;
    /*验证*/
    public function login($data)
    {
        $name = $data['username'];
        $password = splicpwd($data['password']);

        $result = db("Admin")->field('id,password,username')->where('username', '=', $name)->find();
        $id = $result['id'];
        //验证,验证码
        if (!captcha_check($data['captcha'])) {
            return 0;
        }
        //验证密码和用户名
        if (!empty($result)) {
            if ($result['password'] == $password) {
                session('id',$id);
                session('uname',$name);
                return $id;
            } else {
                return -2;//密码
            }
        } else {
            return -1;//账号错误
        }
    }
}