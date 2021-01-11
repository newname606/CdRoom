<?php
/**
 * Created by PhpStorm.
 * User: REN
 * Date: 2020/6/22
 * Time: 12:48
 */
namespace app\fish\controller;


use think\Controller;

class Login extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function login()
    {
        //调用模型验证
        $data = input('post.');
        $result = model('login')->Login($data);
        if ($result == -1) {
            return json(array('status' => -1, 'msg' => '账号错误'));
        } elseif ($result == -2) {
            return json(array('status' => -2, 'msg' => '密码错误'));
        } elseif ($result == 0) {
            return json(array('status' => 0, 'msg' => '请填写正确验证码'));
        } else {
            return json(array('status' => 1, 'msg' => '登录成功'));
        }
    }
}