<?php


namespace app\common\model;


use think\Model;

class User extends Model
{
    /*用户登录*/
    public function GetOpenid($data,$appid,$secret){

        $js_code = $data['code'];

        $url = 'https://api.weixin.qq.com/sns/jscode2session';
        $arr2Session = [
            'appid' => $appid,
            'secret' => $secret,
            'js_code' => $js_code,
            'grant_type' => 'authorization_code'
        ];
        /** 获取sessionKey */
        //初始化curl
        $ch = curl_init($url);
        //字符串不直接输出，进行一个变量的存储
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //https请求
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arr2Session);

        //发送请求
        $str = curl_exec($ch);
        $aStatus = curl_getinfo($ch);
        //关闭连接
        curl_close($ch);
        // 得到session_key结果数组
        $result2Session = json_decode($str, true);
        $data['openid'] = $result2Session['openid'];
        return $data;
    }

    /*获取手机号*/
    public function GetPhone($data,$appid,$secret){

        $js_code = $data['code'];

        $url = 'https://api.weixin.qq.com/sns/jscode2session';
        $arr2Session = [
            'appid' => $appid,
            'secret' => $secret,
            'js_code' => $js_code,
            'grant_type' => 'authorization_code'
        ];
        /** 获取sessionKey */
        //初始化curl
        $ch = curl_init($url);
        //字符串不直接输出，进行一个变量的存储
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //https请求
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arr2Session);

        //发送请求
        $str = curl_exec($ch);
        $aStatus = curl_getinfo($ch);
        //关闭连接
        curl_close($ch);
        // 得到session_key结果数组
        $result2Session = json_decode($str, true);

        $insert_data['openid'] = $result2Session['openid'];
        $aesKey = base64_decode($result2Session['session_key']);
        $aesIV = base64_decode($data['iv']);
        $aesCipher = base64_decode($data['encryptedData']);
        $result = openssl_decrypt($aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

        $arr_result = json_decode($result, true);
        // 获取到的手机号
        $insert_data['phone'] = $arr_result['purePhoneNumber'];
        return $insert_data;
    }


    /*获取用户关注*/
    public function GetMylike($userid,$page,$pagesize){
        $pages = ($page-1)*$pagesize;
        $res = db('UserInfo')->where('id',$userid)->find();
        $likes = $res['ulike'];

        $builds = db('Build')->field('id,logos,bname,path,price,labelid')
            ->where('id','in',$likes)
            ->limit($pages,$pagesize)
            ->select();
        foreach($builds as $k=>$v){
            $label = GetLabel($v);
            $v['label']=$label;
            $logo = str2arr($v['logos']);
            $v['logos'] = $logo[0];
            $builds[$k]=$v;
        }
        return $builds;
    }

}