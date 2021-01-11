<?php

namespace app\alipay\controller;

use think\Controller;
use app\alipay\model\Pay as payModel;

class Wxpay extends Controller
{
    function weChatPay($WIDtotal_amount, $WIDbody = '描述', $WIDsubject = '订单名称', $user_id = '')
    {
        header('content-type:application:json;charset=utf8');
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');

        $out_trade_no = 'lp' . date('Ymdhis', time()); //订单号
        $foundtime = date("Y-m-d H:i:s"); //创建订单时间
        $params = [
            //商户订单号，商户网站订单系统中唯一订单号，必填
            'out_trade_no' => $out_trade_no,
            //订单名称，必填
            'trade_name' => $WIDsubject,
            //付款金额，必填
            'total_amount' => $WIDtotal_amount,
            //描述
            't_body' => $WIDbody,
        ];

        $data = [
            'user_id' => $user_id,
            'order' => $out_trade_no,
            'serve' => $WIDbody,
            'pay' => 1,
            'money' => $WIDtotal_amount,
            'status' => 0,
            'foundtime' => $foundtime
        ];
        //存入数据库
        $model = new payModel();
        $id = $model->inse($data);

        if (!$id) {
            return false;
        }
        //获取微信支付参数
        $config = weChatPayConfig();
        $notifyUrl = 'https://admin.luping666.com/alipay.php/wxpay/wePayNotify';//支付成功异步回调地址

        //订单发起时间
        $timestamp = time();
        $unified = array(
            'appid' => $config['appid'],
            'attach' => 'pay',             //商家数据包，原样返回，如果填写中文，请注意转换为utf-8
            'body' => $WIDsubject,
            'mch_id' => $config['mch_id'],
            'nonce_str' => createNonceStr(),
            'notify_url' => $notifyUrl,
            'out_trade_no' => $out_trade_no,
            'spbill_create_ip' => get_client_ip(),
            'total_fee' => intval($WIDtotal_amount * 100),       //单位 转为分
            'trade_type' => 'NATIVE',
        );
        $unified['sign'] = getSign($unified, $config['key']);
        $responseXml = curlPost('https://api.mch.weixin.qq.com/pay/unifiedorder', arrayToXml($unified));
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $unifiedOrder = simplexml_load_string($responseXml, 'SimpleXMLElement', LIBXML_NOCDATA);

        if (false === $unifiedOrder) {
            die('parse xml error');
        }
        if ('SUCCESS' != $unifiedOrder->return_code) {
            die($unifiedOrder->return_msg);
        }
        if ('SUCCESS' != $unifiedOrder->result_code) {
            die($unifiedOrder->err_code);
        }
        $codeUrl = (array)($unifiedOrder->code_url);
        if (!$codeUrl[0]) {
            exit('get code_url error');
        }

        //生成二维码 这里利用qrcode类库生成的二维码  可根据自己业务进行修改
        return $codeUrl[0];
    }

    /** * 生成签名, $KEY就是支付key * @return 签名 */
    public function MakeSign($params, $KEY)
    {
        //签名步骤一：按字典序排序数组参数javascript:;
        ksort($params);
        $string = $this->ToUrlParams($params); //参数进行拼接key=value&k=v
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=" . $KEY;

        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }

    public function xml_to_array($xml)
    {
        if (!$xml) {
            return false;
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $data;
    }

    //微信支付回调地址
    public function wePayNotify()
    {
        header('content-type:application:json;charset=utf8');
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $data['xml'] = trim(file_get_contents('php://input'));
        $res = db("log")->insert($data);
        //key
        //$key = 'fishcat147258369fishcat147258369';
        $xml = $this->xml_to_array($data['xml']);
        //$sign = $xml['sign'];
        //unset($xml['sign']);
        //$array = $this->MakeSign($xml, $key);

        if ($xml['result_code'] == 'SUCCESS' && $xml['return_code'] == "SUCCESS") {
            //if($sign == $array){/*验证签名*/
            //成功回调异步通知地址
            //订单支付成功
            $orderId = $xml['out_trade_no'];
            $res = db("order")->where('order', $orderId)->find();
            $fountime = strtotime($res['foundtime']);
            if ($res['serve'] == '永久授权') {
                $time = 0;
            } else if ($res['serve'] == '半年授权') {
                $time = date('Y-m-d H:i:s', strtotime("$fountime+6month"));
            } else if ($res['serve'] == '一年授权') {
                $time = date('Y-m-d H:i:s', strtotime("$fountime+1year"));
            }
            $res2 = db("Wxuser")->where('id', $res['user_id'])->update(['serve' => $res['serve'], 'time' => $time]);
            $data['order'] = $orderId;/*订单号*/
            $id = db("Order")->where('order', $data['order'])->update(['status' => 1]);
            //  在此进行数据库操作
            echo '<xml>
                    <return_code><![CDATA[SUCCESS]]></return_code>
                    <return_msg><![CDATA[OK]]></return_msg>
                  </xml>';
        }else {
        echo '<xml>
                    <return_code><![CDATA[SUCCESS]]></return_code>
                    <return_msg><![CDATA[OK]]></return_msg>
                  </xml>';
    }
    }
}


