<?php
namespace app\api\controller;
use think\Controller;

class Message extends Controller
{
    /**
     * 获取系统消息
     * @param string $userid 用户编号
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function SystemMessage($userid='')
    {
        if ($userid){
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
                return json(array('code' => 200, 'msg' => '暂无数据', 'data' => []));
            }
        }else{
            return json(array('code' => 402, 'msg' => '请先登录', 'data' => []));
        }
    }

    /**
     * 系统消息详情接口
     * @param string $id 消息编号
     * @param string $userid 用户编号
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function MessageInfo($id = '',$userid = '')
    {
        $data = db('SystemMessage')->find($id);
        $state = str2arr($data['state']);
        $key = array_search($userid, $state);
        if ($key == false) {/*没查到未读,修改为已读*/
            $state[] = $userid;
            $state = arr2str($state);
            $res = db('SystemMessage')->where('id', $id)->setField('state', $state);
        }

        return json(array('code' => 200, 'msg' => '请求成功', 'data' => $data));
    }
}

