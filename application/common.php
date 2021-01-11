<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use think\Request;

/*传入地址获取经纬度*/
function getLonLLat($area)
{
    if (!$area) {
        return false;
    }
    //参数的排序需要和文档一致
    $data = [
        'address' => $area,/*地址*/
        'output' => 'json',/*json数据*/
        'key' => 'XeNA6vWOb6wOFAEyZD3QDPTldV9yYQtd',/*迷药*/
    ];
    //将数据转换成连接的参数形式
    $url = "http://api.map.baidu.com/geocoder?" . http_build_query($data);
    //传参 提交到 接口地址 获取返回的经纬度数据
    $result = doCurl($url);
    /*json字符串转数组*/
    $res = json_decode($result, true);
    if ($res['status'] == 'OK') {
        $location = $res['result']['location'];
        return $location;/*返回经纬度*/
    } else {
        return -1;/*没查询到*/
    }
}


/**
 * @param $url
 * @param $type 0get 1post
 * @param array $data 提交数据
 * 封装curl方法
 */
function doCurl($url, $type = 0, $data = [])
{
    //初始化
    $ch = curl_init();

    //设置选项
    curl_setopt($ch, CURLOPT_URL, $url);//配置请求地址
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//是否返回结果
    curl_setopt($ch, CURLOPT_HEADER, 0);//header头内容不输出
    //请求方式是post的实话
    if ($type == 1) {
        curl_setopt($ch, CURLOPT_POST, 1);//开启post
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    //执行并获取内容
    $output = curl_exec($ch);
    //释放curl
    curl_close($ch);
    //返回数据
    return $output;
}

/*php多图片上传拼接成字符串*/
function images($file)
{
    $pic = '';
    foreach ($file as $files) {
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $files->move(ROOT_PATH . DS . 'public/uploads');
        // 成功上传后 获取上传信息
        $files = $info->getSaveName() . ',';/*用逗号分隔开*/
        $request = Request::instance();
        $domain = $request->domain();/*获取当前域名*/
        $files = $domain . '/uploads/' . $files;
        $pic = $pic . $files;
    }
    $pic = substr($pic, 0, -1);/*截取掉最后一个逗号*/
    return $pic;
}

/*单图片上传*/
function image($file)
{
    $info = $file->move(ROOT_PATH  . DS . 'public/uploads');
    $cover = $info->getSaveName();/*获取名字*/
    $request = Request::instance();
    $domain = $request->domain();
    $file = $domain . "/uploads/" . $cover;/*拼接绝对路径*/
    return $file;
}

/*拼接密码*/
function splicpwd($pwd=''){
    $password = 'QFGASscz'.$pwd.'weqqweQWEQWASCZ123';
    return md5($password);
}

/*获取楼盘标签
Info 传入楼盘信息
*/
function GetLabel($Info=''){
    if($Info){
        $labels = model('BuildLabel')->field('id,name,color')->select();/*楼盘标签*/
        $label_id = explode(',',$Info['labelid']);/*字符串转数组*/
        $labelname = '';
        $arr = [];
        foreach($labels as $k=>$label){
            if(in_array($label['id'],$label_id)){
                $arr[$k]['name'] = $label['name'];
                $arr[$k]['color'] = $label['color'];
            }
        }
        return $arr;/*返回字符串*/
    }
}


/*数组转字符串*/
function arr2str($arr=''){
    return implode(',',$arr);
}

/*字符串转数组*/
function str2arr($str=''){
    return explode(',',$str);
}

/*数组转字符串*/
function json2arr($json=''){
    return json_decode($json,true);
}

/*字符串转数组*/
function arr2json($arr=''){
    return json_encode($arr);
}

/*获取真正ip*/
function get_ip(){
    //判断服务器是否允许$_SERVER
    if(isset($_SERVER)){
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }elseif(isset($_SERVER['HTTP_CLIENT_IP'])) {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        }else{
            $realip = $_SERVER['REMOTE_ADDR'];
        }
    }else{
        //不允许就使用getenv获取
        if(getenv("HTTP_X_FORWARDED_FOR")){
            $realip = getenv( "HTTP_X_FORWARDED_FOR");
        }elseif(getenv("HTTP_CLIENT_IP")) {
            $realip = getenv("HTTP_CLIENT_IP");
        }else{
            $realip = getenv("REMOTE_ADDR");
        }
    }

    return $realip;
}


/**
 * 判断IP输入是否合法
 * @param type $ip IP地址
 * @return int 等于1是输入合法  0 输入不合法
 */
function isIp($ip) {
    if (preg_match('/^((?:(?:25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d)))\.){3}(?:25[0-5]|2[0-4]\d|((1\d{2})|([1 -9]?\d))))$/', $ip)) {
        return 1;
    } else {
        return 0;
    }
}
