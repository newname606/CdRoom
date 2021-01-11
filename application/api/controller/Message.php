<?php
namespace app\api\controller;
use think\Controller;

class Message extends Controller
{
    /*获取系统消息接口*/
    public function SystemMessage($userid='')
    {
        $data = db('SystemMessage')->select();
        foreach($data as $k=>$v){
            $state = str2arr($v['state']);
            $key = array_search($userid, $state);
            if($key !== false){
                $v['state'] = 0;/*已读*/
            }else{
                $v['state'] = 1;/*未读*/
            }
            $data[$k] = $v;
        }
        if($data){
            return json(array('code' => 200, 'msg' => '请求成功', 'data' => $data));
        }else{
            return json(array('code' => 402, 'msg' => '暂无数据', 'data' => []));
        }
    }

    /*获取系统消息详情接口*/
    public function MessageInfo($id = '',$userid = '')
    {
        $data = db('SystemMessage')->find($id);
        $state = str2arr($data['state']);
        $key = array_search($userid, $state);
        if ($key == false) {
            /*已读*/
            $state[] = $userid;
            $state = arr2str($state);
            $res = db('SystemMessage')->where('id', $id)->setField('state', $state);
        }

        return json(array('code' => 200, 'msg' => '请求成功', 'data' => $data));
    }
}

