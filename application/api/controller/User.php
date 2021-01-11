<?php
/**
 * Created by PhpStorm.
 * User: REN
 * Date: 2020/8/6
 * Time: 13:51
 */

namespace app\api\controller;

use think\Controller;

class User extends Controller
{

    /*获取用户信息
    *传入用户ID
    */
    public function userinfo($id = '')
    {
        $list = db("UserInfo")->find($id);
        if ($list) {
            return json(array('code' => 200, 'msg' => '请求成功', 'data' => $list));
        } else {
            return json(array('code' => 402, 'msg' => '数据错误', 'data' => []));
        }
    }

    /*修改用户信息
     * id 用户编号 必传
     * logo 用户头像
     * uname 用户名
     * sex 用户性别
     * phone 手机号
     * */
    public function UpdateInfo()
    {
        $data = input();

        if ($data['id']) {
            $res = db('UserInfo')->update($data);
            if ($res) {
                return json(array('code' => 200, 'msg' => '修改信息成功'));
            } else {
                return json(array('code' => 402, 'msg' => '修改信息失败,请稍后再试!'));
            }
        } else {
            return json(array('code' => 500, 'msg' => '参数错误!'));
        }
    }

    /*
     * 获取用户手机号
     * uname  用户名
     * logo 用户头像
     * openid 用户的openid
     * iv
     * encryptedData
     * code 用户的code码
     * */

    public function getphone()
    {
        $data = input('post.');
        $appid = 'wx6d8bc8404d67a87c';/*小程序的appid*/
        $secret = '1eb8f70d0d69975b31c8c16e76e2146f';/*小程序的secret*/
        $insert_data = model("User")->GetPhone($data,$appid,$secret);

        // 修改 用户名 手机号 logo code openID
        $result = model('UserInfo')->where('openid', $insert_data['openID'])->update($insert_data);
        $row = model('UserInfo')->where('openid', $insert_data['openID'])->find();

        return json(array('code' => 200, 'msg' => '登录成功', 'id' => $row['id']));

    }

    /*
     * uname 用户名
     * logo 头像
     * code 用户的code码
     * */

    public function userlogo()
    {
        $data = input();
        $appid = 'wx6d8bc8404d67a87c';/*小程序的appid*/
        $secret = '1eb8f70d0d69975b31c8c16e76e2146f';/*小程序的secret*/
        $data = model('User')->GetOpenid($data,$appid,$secret);

        $row = model('UserInfo')->where('openid', $data['openid'])->find();

        if (!$row) {
            unset($data['code']);
            $data['create_time'] = time();
            //为空说明用户不存在返回402
            $id = model('UserInfo')->insertGetId($data);
            $data = db('UserInfo')->where('id',$id)->find();
            return json(array('code' => 402, 'msg' => '需要授权手机号','data'=>$data));
        } else {
            //不为空说明用户存在返回200,和用户的id
            return json(array('code' => 200, 'data' => $row, 'msg' => '登录成功'));
        }
    }

    /*单图片上传*/
    public function uploadimage()
    {
        $file = request()->file('logo');
        if ($file){
            $logo = image($file);
            return json(array('code'=>200,'msg'=>'上传成功','imgurl'=>$logo));
        }else{
            return json(array('code'=>402,'msg'=>'上传失败','imgurl'=>''));
        }
    }

    /*用户关注楼盘
    userid 用户编号
    buildid 楼盘编号
    */
    public function BuildHeart($userid = '', $buildid = '')
    {
        $data = db('UserInfo')->field('id,ulike')->where('id', $userid)->find();
        $ulike = str2arr($data['ulike']);

        //1.返回一个键名，如果值有重复,返回第一个键名
        $key = array_search($buildid, $ulike);
        if ($key !== false) {
            /*查询到了 取消关注*/
            unset($ulike[$key]);
            $ulike = arr2str($ulike);
            $res = db('UserInfo')->where('id', $userid)->setField('ulike', $ulike);
            $data['msg']='取消关注成功';
            return json(array('code' => 200, 'data' => $data));
        } else {
            /*未查询到,关注楼盘*/
            $ulike[] = $buildid;
            $ulike = arr2str($ulike);
            $res = db('UserInfo')->where('id', $userid)->setField('ulike', $ulike);
            $data['msg']='关注成功';
            return json(array('code' => 200, 'data' => $data));
        }
    }

    /*用户评论点赞
    userid 用户编号
    commentid 评论编号
    */
    public function CommentHeart($userid = '', $commentid = '')
    {
        $data = db('Comment')->field('id,heart')->where('id', $commentid)->find();
        $heart = str2arr($data['heart']);

        //1.返回一个键名，如果值有重复,返回第一个键名
        $key = array_search($userid, $heart);
        if ($key !== false) {
            /*查询到了 取消关注*/
            unset($heart[$key]);
            $heart = arr2str($heart);
            $res = db('Comment')->where('id', $commentid)->setField('heart', $heart);
            $data['msg']='取消点赞成功';
            return json(array('code' => 200, 'data' => $data));
        } else {
            $heart[] = $userid;
            $heart = arr2str($heart);
            $res = db('Comment')->where('id', $commentid)->setField('heart', $heart);
            $data['msg']='点赞成功';
            return json(array('code' => 200, 'data' => $data));
            /*未查询到,点赞*/
        }
    }

    /*用户发表评论
    userid 用户编号
    content 评论内容
    buildid 楼盘编号
    */
    public function UserComment($userid='',$content='',$buildid=''){
        $result = db('UserInfo')->where('id',$userid)->find();
        if($result['state'] == 0){
            return json(array('code'=>500,'msg'=>'账号被冻结,请联系管理员'));
        }
        $res = db('Comment')
            ->where('userid',$userid)
            ->where('content',$content)
            ->where('roomid',$buildid)
            ->find();
        if($res){
            return json(array('code'=>500,'msg'=>'请勿重复评论'));
        }
        $insert_data['userid']=$userid;
        $insert_data['content']=$content;
        $insert_data['roomid']=$buildid;
        $insert_data['create_time']=time();

        if(db('Comment')->insert($insert_data) !== false){
            return json(array('code'=>200,'msg'=>'评论成功'));
        }else{
            return json(array('code'=>402,'msg'=>'评论失败'));
        }

    }

    /*用户回复评论
    username 用户名称
    replyname 回复人名称
    content 评论内容
    buildid 楼盘编号
    */
    public function UserReply($username,$replyname,$content,$commentid,$logo,$userid){
        $result = db('UserInfo')->where('id',$userid)->find();
        if($result['state'] == 0){
            return json(array('code'=>500,'msg'=>'账号被冻结,请联系管理员'));
        }
        /*如果回复名为楼主,则不显示*/
        $data = db('Comment')->alias('a')
            ->field('a.id,b.uname')->join('UserInfo b','a.userid=b.id')
            ->find();
        if($replyname == $data['uname']){
            $replyname = '';
        }
        $insert_data['username']    =$username;
        $insert_data['replyname']   =$replyname;
        $insert_data['content']     =$content;
        $insert_data['logo']        =$logo;
        $insert_data['commentid']   =$commentid;
        $insert_data['create_time'] =time();

        if(db('Reply')->insert($insert_data) !== false){
            return json(array('code'=>200,'msg'=>'评论成功'));
        }else{
            return json(array('code'=>402,'msg'=>'评论失败'));
        }
    }

    /*我的关注楼盘页
    userid  用户编号*/
    public function Mylike($userid='',$page=1,$pagesize=5){

        $data = model('User')->GetMylike($userid,$page,$pagesize);

        if($data){
            return json(array('code'=>200,'msg'=>'请求成功','data'=>$data));
        }else{
            return json(array('code'=>402,'msg'=>'暂无关注楼盘','data'=>[]));
        }
    }
}


