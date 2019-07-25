<?php

/*
 * 支付相关处理
 */

namespace app\home\controller;

use think\Lang;
use think\Log;

class Payment extends BaseMall
{

    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        Lang::load(APP_PATH . 'mobile/lang/zh-cn/buy.lang.php');

    }

    /**
     * 实物商品订单
     */
    public function real_order()
    {
        $pay_sn = $_POST['pay_sn'];
        $payment_code = $_POST['payment_code'];
        $url = url('Home/Memberorder/index');

        if (!preg_match('/^\d{18}$/', $pay_sn)) {
            $this->error('参数错误', $url);
        }
        $logic_payment = model('payment', 'logic');
        $result = $logic_payment->getPaymentInfo($payment_code);
        if (!$result['code']) {
            $this->error($result['msg'], $url);
        }
        $payment_info = $result['data'];
        //计算所需支付金额等支付单信息
        $result = $logic_payment->getRealOrderInfo($pay_sn, session('member_id'));
        if (!$result['code']) {
            $this->error($result['msg'], $url);
        }
        if ($result['data']['api_pay_state'] || empty($result['data']['api_pay_amount'])) {
            $this->error('该订单不需要支付', $url);
        }

        //转到第三方API支付
        $this->_api_pay($result['data'], $payment_info);
    }

    /**
     * 虚拟商品购买
     */
    public function vr_order()
    {
        $order_sn = $_POST['order_sn'];
        $payment_code = $_POST['payment_code'];
        $url = url('membervrorder/index');

        if (!preg_match('/^\d{18}$/', $order_sn)) {
            $this->error('参数错误');
        }

        $logic_payment = model('payment', 'logic');
        $result = $logic_payment->getPaymentInfo($payment_code);
        if (!$result['code']) {
            $this->error($result['msg'], $url);
        }
        $payment_info = $result['data'];

        //计算所需支付金额等支付单信息
        $result = $logic_payment->getVrOrderInfo($order_sn, session('member_id'));
        if (!$result['code']) {
            $this->error($result['msg'], $url);
        }

        if ($result['data']['order_state'] != ORDER_STATE_NEW || empty($result['data']['api_pay_amount'])) {
            $this->error('该订单不需要支付', $url);
        }

        //转到第三方API支付
        $this->_api_pay($result['data'], $payment_info);
    }

    /**
     * 预存款充值
     */
    public function pd_order()
    {
        $pdr_sn = $_POST['pdr_sn'];
        $payment_code = $_POST['payment_code'];
        $url = url('predeposit/index');

        if (!preg_match('/^\d{18}$/', $pdr_sn)) {
            $this->error('参数错误', $url);
        }

        $logic_payment = model('payment', 'logic');
        $result = $logic_payment->getPaymentInfo($payment_code);
        if (!$result['code']) {
            $this->error($result['msg'], $url);
        }
        $payment_info = $result['data'];

        $result = $logic_payment->getPdOrderInfo($pdr_sn, session('member_id'));
        if (!$result['code']) {
            $this->error($result['msg'], $url);
        }
        if ($result['data']['pdr_payment_state'] || empty($result['data']['api_pay_amount'])) {
            $this->error('该充值单不需要支付', $url);
        }

        //转到第三方API支付
        $this->_api_pay($result['data'], $payment_info);
    }

    /**
     * 第三方在线支付接口
     *
     */
    private function _api_pay($order_info, $payment_info)
    {
        $payment_api = new $payment_info['payment_code']($payment_info, $order_info);
        if ($payment_info['payment_code'] == 'chinabank') {
            $payment_api->submit();
        }
        elseif ($payment_info['payment_code'] == 'wxpay') {
            if (!extension_loaded('curl')) {
                $this->error('系统curl扩展未加载，请检查系统配置');
            }
            if (array_key_exists('order_list', $order_info)) {
                $this->assign('order_list', $order_info['order_list']);
                $this->assign('args', 'buyer_id=' . session('member_id') . '&pay_id=' . $order_info['pay_id']);
            }
            else {
                $this->assign('order_list', array($order_info));
                $this->assign('args', 'buyer_id=' . session('member_id') . '&order_id=' . (isset($order_info['order_id'])? $order_info['order_id']:''));
            }
            $this->assign('api_pay_amount', $order_info['api_pay_amount']);
            $this->assign('pay_url', base64_encode(encrypt($payment_api->get_payurl(), MD5_KEY)));
            $this->assign('nav_list', rkcache('nav', true));
            echo $this->fetch($this->template_dir . 'wxpay');
        }
        else {
            @header("Location: " . $payment_api->get_payurl());
        }
        exit();
    }

    /**
     * 通知处理(支付宝异步通知和网银在线自动对账)
     *
     */
    public function alipay_notify_url()
    {
        $order_type = input('param.body');
        $out_trade_no = input('param.out_trade_no');
        $trade_no = input('param.trade_no');
        $fail='fail';
        $success='success';
        //参数判断
        if (!preg_match('/^\d{18}$/', $out_trade_no))
            exit($fail);

        $model_pd = Model('predeposit');
        $logic_payment = model('payment', 'logic');

        if ($order_type == 'real_order') {

            $result = $logic_payment->getRealOrderInfo($out_trade_no);
            if (intval($result['data']['api_pay_state'])) {
                exit($success);
            }
            $order_list = $result['data']['order_list'];
        }
        elseif ($order_type == 'vr_order') {

            $result = $logic_payment->getVrOrderInfo($out_trade_no);
            if ($result['data']['order_state'] != ORDER_STATE_NEW) {
                exit($success);
            }
        }
        elseif ($order_type == 'pd_order') {

            $result = $logic_payment->getPdOrderInfo($out_trade_no);
            if ($result['data']['pdr_payment_state'] == 1) {
                exit($success);
            }
        }
        else {
            exit();
        }
        $order_pay_info = $result['data'];

        //取得支付方式
        $result = $logic_payment->getPaymentInfo('alipay');
        if (!$result['code']) {
            exit($fail);
        }
        $payment_info = $result['data'];

        //创建支付接口对象
        $payment_api = new $payment_info['payment_code']($payment_info, $order_pay_info);

        //对进入的参数进行远程数据判断
        $verify = $payment_api->notify_verify();
        if (!$verify) {
            exit($fail);
        }
        //取得支付结果
        $pay_result	= $payment_api->getPayResult($_POST);
        if (!$pay_result) {
            $this->error('非常抱歉，您的订单支付没有成功，请您后尝试','Memberorder/index');
        }

        //修改订单状态
        if ($order_type == 'real_order') {
            $result = $logic_payment->updateRealOrder($out_trade_no, $payment_info['payment_code'], $order_list, $trade_no);
        }
        elseif ($order_type == 'vr_order') {
            $result = $logic_payment->updateVrOrder($out_trade_no, $payment_info['payment_code'], $order_pay_info, $trade_no);
        }
        elseif ($order_type == 'pd_order') {
            $result = $logic_payment->updatePdOrder($out_trade_no, $trade_no, $payment_info, $order_pay_info);
        }
        exit($result['code'] ? $success : $fail);
    }

    /**
     * 支付接口同步返回路径
     *
     */
    public function alipay_return_url()
    {
        $data['pay_sn'] = input('param.out_trade_no');  //返回的支付单号
        $data['order_amount'] = input('param.total_amount');  //订单金额
        $appid=input('param.app_id');    //appid
        $trade_no = input('param.trade_no');
        $payment_code = 'alipay';

        $order_model = model('order');
        $logic_payment= model('payment','logic');
        //判断out_trade_no和total_amount是否订单匹配
        $order_info = $order_model->getOrderInfo($data);
        if(empty($order_info)){
            return false;
        }

         $payment_state=db('orderpay')->where(array('pay_sn'=>$data['pay_sn']))->field('api_pay_state')->find();
        if ($payment_state != '1') {
            //取得支付方式
            $result = $logic_payment->getPaymentInfo($payment_code);
            if(!$result['code']){
                $this->error($result['msg'],'Memberorder/index');
            }
            $payment_info = $result['data'];
            if($payment_info['payment_config']['alipay_appid'] != $appid){
                $this->error('支付数据验证失败','memberorder/index');
            }

            //创建支付接口对象
            $payment_api = new $payment_info['payment_code']($payment_info);

            //返回参数判断
            $verify = $payment_api->return_verify();
            if (!$verify) {
                $this->error('支付数据验证失败', 'Memberorder/index');
            }
        }
        //支付成功后跳转
       /* if ($order_type == 'real_order') {
            $pay_ok_url = SHOP_SITE_URL.'/buy/pay_ok?pay_sn='.$out_trade_no.'&pay_amount='.dsPriceFormat($api_pay_amount);
        } elseif ($order_type == 'vr_order') {
            $pay_ok_url = SHOP_SITE_URL.'/buyvirtual/pay_ok?order_sn='.$out_trade_no.'&order_id='.$order_pay_info['order_id'].'&order_amount='.dsPriceFormat($api_pay_amount);
        } elseif ($order_type == 'pd_order') {
            $pay_ok_url = SHOP_SITE_URL.'/predeposit/index';
        }*/
        $pay_ok_url = SHOP_SITE_URL.'/buy/pay_ok?pay_sn='.$data['pay_sn'].'&pay_amount='.dsPriceFormat($data['order_amount']);
        header("Location:$pay_ok_url");
        exit;
        //支付宝交易号
       /* $trade_no = htmlspecialchars($trade_no);

        echo "验证成功<br />支付宝交易号：".$trade_no;*/
    }

    /**
     * 二维码显示(微信扫码支付) v3-b12
     */
    public function qrcode()
    {
        $data = base64_decode(input('data'));
        $data = decrypt($data, MD5_KEY, 30);
        import('qrcode.phpqrcode', EXTEND_PATH);
        \QRcode::png($data);
    }

    /**
     * 接收微信请求，接收productid和用户的openid等参数，执行（【统一下单API】返回prepay_id交易会话标识
     */
    public function wxpay_returnOp()
    {
        $result = model('payment', 'logic')->getPaymentInfo('wxpay');
        if (!$result['code']) {
            Log::record('wxpay not found', 'RUN');
        }
        new wxpay($result['data'], array());
        require_once BASE_PATH . '/api/payment/wxpay/native_notify.php';
    }

    /**
     * 支付成功，更新订单状态
     */
    public function wxpay_notify()
    {
        trace('wxpay_notify', 'degug');
        $result = model('payment', 'logic')->getPaymentInfo('wxpay');
        if (!$result['code']) {
            Log::record('wxpay not found', 'info ');
        }
        new \wxpay($result['data'], array());
        require_once APP_PATH . ATTACH_PATH . '/api/payment/wxpay/notify.php';
    }

    public function query_state()
    {

        if (input('param.pay_id') && intval(input('param.pay_id')) > 0) {
            $info = Model('order')->getOrderPayInfo(array(
                                                        'pay_id' => intval(input('param.pay_id')),
                                                        'buyer_id' => intval(input('param.buyer_id'))
                                                    ));
            exit(json_encode(array(
                                 'state' => ($info['api_pay_state'] == '1'), 'pay_sn' => $info['pay_sn'], 'type' => 'r'
                             )));
        }
        elseif (intval(input('param.order_id')) > 0) {
            $info = Model('vrorder')->getOrderInfo(array(
                                                       'order_id' => intval(input('param.order_id')),
                                                       'buyer_id' => intval(input('param.buyer_id'))
                                                   ));
            exit(json_encode(array(
                                 'state' => ($info['order_state'] == '20'), 'pay_sn' => $info['order_sn'], 'type' => 'v'
                             )));
        }
    }

}

?>
