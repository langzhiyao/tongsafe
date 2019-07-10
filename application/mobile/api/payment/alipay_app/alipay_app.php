<?php

class alipay_app {

    function get_payform($param) {

        require_once APP_PATH .ATTACH_MOBILE.'/api/payment/alipay_app/AopClient.php';
        $aop = new \AopClient();
        $aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";
        $aop->appId = $param['app_alipay_appid'];
        $aop->rsaPrivateKey = $param['app_private_key'];
        $aop->format = "json";
        $aop->charset = "UTF-8";
        $aop->signType = "RSA2";
        $aop->alipayrsaPublicKey = $param['app_public_key'];
//实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay

        require_once APP_PATH .ATTACH_MOBILE.'/api/payment/alipay_app/request/AlipayTradeAppPayRequest.php';
        $request = new \AlipayTradeAppPayRequest();
        $bizcontent = "{\"body\":\"{$param['orderSn']}\","
                . "\"subject\":\"{$param['orderInfo']}\","
                . "\"out_trade_no\":\"{$param['orderSn']}-{$param['order_type']}\","
                . "\"total_amount\":\"{$param['orderFee']}\","
                . "\"product_code\":\"QUICK_MSECURITY_PAY\""
                . "}";
        trace('bizcontent'.$bizcontent,'debug');
        $request->setNotifyUrl(MOBILE_SITE_URL . '/payment/alipay_notify_app');
        $request->setBizContent($bizcontent);
//这里和普通的接口调用不同，使用的是sdkExecute
        $response = $aop->sdkExecute($request);

//htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
//        echo htmlspecialchars($response); //就是orderString 可以直接给客户端请求，无需再做处理。

        output_data(array('content'=>$response,'orderSn'=>$param['orderSn']));
    }

    function verify_notify($param) {
        require_once APP_PATH .ATTACH_MOBILE.'/api/payment/alipay_app/AopClient.php';
        $aop = new \AopClient;

//        $aop->alipayrsaPublicKey = $param['app_public_key'];
        $aop->alipayrsaPublicKey = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAlPXfE+mKzBC+NBgN68OORr2WtqHzhkNgbrqlfW4ClwHgRO/YABz2e7iHD4SFcFidFEUvKp7eQPWr39IwNOQ8tBYMzdIHTgebzuI36RaGO0ojEokm5QyIBNnutWuJVQ7AWD3gexqivn+Aoh0WA0pnXq7vI348EvkrQFRVkLDbMpd/FzwYQ8q4HCM/ffVnAN7gZ/kYLOuvc3LypwTkXZOUlZYvzCVg1d9nPxBXj5zxXV/lXDzPyIswX/99yONixC+RA2OCRmeiskEYaSrXN+WY8i7aBrFvLnHQ7IppYGWlhdhjc6YovrUnVR/7mY2ThkMsns9/o24tEUSljT8I/gGGoQIDAQAB";

        $flag = $aop->rsaCheckV1($_POST, NULL, "RSA2");
        if ($flag) {
            $notify_result = array(
                'out_trade_no' => $_POST["out_trade_no"], #商户订单号
                'trade_no' => $_POST['trade_no'], #交易凭据单号
                'total_fee' => $_POST["total_amount"], #涉及金额
                'trade_status' => '1',
            );
        } else {
            $notify_result = array(
                'trade_status' => '0',
            );
        }
        return $notify_result;
    }

}

?>
