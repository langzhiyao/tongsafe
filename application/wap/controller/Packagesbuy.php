<?php

namespace app\wap\controller;


class Packagesbuy extends MobileMember
{
    private $payment_code;
    private $payment_config;
    private $orderInfo;

    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        if (request()->action() != 'payment_list' && !input('param.payment_code')) {
            $payment_code = 'alipay';
        }
        else {
            $payment_code = input('post.payment_code');
        }
        $model_mb_payment = Model('mbpayment');
        $condition = array();
//        $condition['payment_code'] = $payment_code == 'wxpay_h5'?'wxpay_app':$payment_code;
        $condition['payment_code'] = $payment_code;
        $mb_payment_info = $model_mb_payment->getMbPaymentOpenInfo($condition);

//        if (!$mb_payment_info && $payment_code == 'wxpay_h5') {
//            $mb_payment_info = $model_mb_payment->getMbPaymentOpenInfo(array('payment_code'=>'wxpay_h5'));
//        }
        if (!$mb_payment_info) {
            output_error('支付方式未开启');
        }
        $this->payment_code = $payment_code;
        $this->payment_config = $mb_payment_info['payment_config'];
        $inc_file = APP_PATH . DIR_APP . DS . 'api' . DS . 'payment' . DS . $this->payment_code . DS . $this->payment_code . '.php';



        if (!is_file($inc_file)) {
            output_error('支付接口出错，请联系管理员！');
        }
        require_once($inc_file);
        $this->_logic_buy_1 = \model('buy_1','logic');
    }


    public function GetNowPackageTime(){
        $input = input();
        $condition=array(
            'member_id'=>$this->member_info['member_id'],
            's_id'=>$input['child_id'],
            'pkg_type'=>1
        );
        $PkgTime = model('Packagetime');
        $packagetime = $PkgTime->getOnePkg($condition);
        if ($packagetime) {
            output_data(array('endtime'=>date('Y-m-d',$packagetime['end_time'])));
        }else{
            output_error('还未购买套餐！');
        }


    }
    /**
     * 获取套餐列表
     * @return [type] [description]
     */
    public function get_packages_list(){
        $pkg=model('Pkgs');
        $condition=array();
        $condition['pkg_type'] = !empty(input('post.pkg_type'))?input('post.pkg_type'):1;
        $condition['pkg_enabled']=1;
        $field = 'pkg_id,pkg_length,pkg_axis,pkg_length,pkg_name,pkg_price,pkg_cprice,pkg_sort,pkg_type,pkg_desc';
        $list = $pkg->getPkgLists($condition,'');
        foreach ($list as $k => &$v) {
            /*  $str = $v['pkg_length'].'个月';
              switch ($v['pkg_axis']) {
                  case 'quarter':
                      $str = ($v['pkg_length']*3).'个月';
                      break;
                  case 'half':
                      $str = ($v['pkg_length']*6).'个月';
                      break;
                  case 'year':
                      $str = ($v['pkg_length']*12).'个月';
                      break;

                  default:
                      $str = $v['pkg_length'].'个月';
                      break;
              }
              $v['pkg_title'] = $str;*/
            $v['pkg_title'] = $v['pkg_name'];

        }
        unset($v);
        if ($list) {
            output_data($list);
        }else{
            output_error('暂无套餐信息！');
        }
    }

    /**
     * 获取已开启的支付列表
     * @return [type] [description]
     */
    public function get_payment_list(){
        $payment_list = model('mbpayment')->getMbPaymentOpenList();

        if (!empty($payment_list)) {
            foreach ($payment_list as $k => $value) {
                unset($payment_list[$k]['payment_id']);
                unset($payment_list[$k]['payment_config']);
                unset($payment_list[$k]['payment_state']);
                unset($payment_list[$k]['payment_state_text']);
            }
        }
        if(in_array($this->member_info['client_type'],array('ios','android'))){
            foreach ($payment_list as $k => $v) {
                if(!strpos($payment_list[$k]['payment_code'],'app')){
                    unset($payment_list[$k]);
                }
                if ($payment_list[$k]->payment_code== 'wxpay_app'){
                    $payment_list[$k]->payment_title = 'wxpay_h5';
                }
                if ($payment_list[$k]->payment_code=='alipay_app'){
                    $payment_list[$k]->payment_title = 'alipay_app';
                }
            }
        }
        output_data(array_values($payment_list));
    }

    /**
     * 计算套餐时间何时到期
     * @return [type] [description]
     */
    public function packages_time_reckon(){
        $input = input();
        $PkgTime = model('Packagetime');
        $pkginfo= json_decode($input['pkginfo'],TRUE);
        if(!isset($pkginfo['pkg_id']))output_error('参数错误！1');
        if(!$pkginfo['pkg_id'])output_error('参数错误！2');

        $condition=array(
            'member_id'=>$this->member_info['member_id'],
            's_id'=>$input['child_id'],
            'pkg_type'=>$pkginfo['pkg_type']
        );
        $packagetime = $PkgTime->getOnePkg($condition);
        $pkginfo['finnshed_time'] = time();
        $end_time = CalculationTime($pkginfo,$packagetime);
        output_data(array('end_time'=>date('Y-m-d',$end_time)));

    }




    /**
     * 购买套餐
     * 1，拿到需要购买的套餐信息
     *     --购买人信息
     *     --套餐信息
     *     --购买人孩子信息，摄像头信息
     *     --支付类型
     * 2，根据得到的信息生成订单
     *     --生成订单流水号
     *     --生成支付流水号
     *     --存储到订单表-》包含套餐信息，购买人信息，支付类型，孩子，摄像头信息
     *     --返回
     * @return [type] [description]
     */
    public function buy_step1(){
        $package_id = input('post.pkg_id');
        $chind_id = input('post.child_id');
        if (!$chind_id || !$package_id) {
            output_error('缺少参数package_id或chind_id ！');
        }
        $Pkgs=model('Pkgs');

        $packageInfo = $Pkgs->getOnePkg(array('pkg_id'=>$package_id,'pkg_enabled'=>1));
        if ($packageInfo) {
            unset($packageInfo['pkg_sort']);
            unset($packageInfo['pkg_enabled']);
        }else{
            output_error('没有此套餐的信息！');
        }
        $pay_sn = $this->_logic_buy_1->makePaySn($this->member_info['member_id']);
        $order = array();
        //生成基本订单信息
        $order['pay_sn'] = $pay_sn;
        $order['buyer_id'] = $this->member_info['member_id'];
        $order['buyer_name'] = $this->member_info['member_name'];
        $order['buyer_mobile'] = $this->member_info['member_mobile'];
        $order['add_time'] = TIMESTAMP;
        $order['payment_code'] = $this->payment_code;
        if ($order['payment_code'] == "") {
            $order['payment_code'] = "offline";
        }
        $order['order_from'] = $this->member_info['client_type'];
        $order['order_state'] = ORDER_STATE_NEW;
        //加入套餐信息
        if(is_array($packageInfo))$order +=$packageInfo;
        unset($order['up_time']);
        $Children = model('Student');
        $childinfo=$Children->getChildrenInfoById($chind_id);
        if (!$childinfo) {
            output_error('没有当前孩子信息！');
        }
        $Relation = $Children->checkParentRelation($this->member_info['member_id'],$chind_id);
        if($Relation=='false')output_error('您不是此孩子的家长，不能购买当前套餐！');
        //加入学生学校班级信息
        if(is_array($childinfo))$order += $childinfo;
        $order['order_amount'] = $packageInfo['pkg_price'];
        try {
            $model = Model('Packagesorder');
            $model->startTrans();
            //写入订单表
            $order_pay_id = $model->addOrder($order);
            $this->orderInfo = $order;
            $this->orderInfo['order_id'] = $order_pay_id;
            $model->commit();

        } catch (Exception $e) {
            $model->rollback();
            return ds_callback(false, $e->getMessage());
        }
        $this->orderInfo['order_sn'] = $this->_logic_buy_1->makeOrderSn($order_pay_id);
        //写入平台流水号
        $model->editOrder(array('order_sn'=>$this->orderInfo['order_sn']), array('order_id'=>$order_pay_id));
        //app支付
        $this->_app_pay($this->orderInfo);
    }

    /**
     * app支付
     * @param  [type] $order_pay_info [description]
     * @return [type]                 [description]
     */
    private function _app_pay($order_pay_info){
        $param = $this->payment_config;
        $param['orderInfo'] = config('site_name') . '商品订单' . $order_pay_info['pay_sn'];
        $param['orderSn'] = $order_pay_info['pay_sn'];

        //微信app支付
        if ($this->payment_code == 'wxpay_app') {
            $param['orderSn'] = $order_pay_info['pay_sn'];
//            $param['orderFee'] = (100 * $order_pay_info['order_amount']);
            $param['orderFee'] = (100 * 0.01);
            $param['orderInfo'] = config('site_name') . '订单' . $order_pay_info['pay_sn'];
//            $param['orderAttach'] = $order_pay_info['pkg_type'] = "teachchild";
            $param['orderAttach'] = $order_pay_info['pkg_type']==1?'witching':'reClass';
            $param['notifyUrl'] = WAP_SITE_URL . '/payment/wx_notify_h5.html';
            $api = new \wxpay_app();
            $api->get_payform($param);
            exit;
        }
        //支付宝
        if ($this->payment_code == 'alipay_app') {
            $param['orderSn'] = $order_pay_info['pay_sn'];;
//            $param['orderFee'] = $order_pay_info['order_amount'];
            $param['orderFee'] = 0.01;
            $param['orderInfo'] = config('site_name') . '订单' . $order_pay_info['pay_sn'];
//            $param['order_type'] = $order_pay_info['pkg_type'] = "teachchild";
            $param['orderAttach'] = $order_pay_info['pkg_type']==1?'witching':'reClass';
            $param['notifyUrl'] = WAP_SITE_URL . '/payment/alipay_notify_app.html';
            $api = new \alipay_app();
            $api->get_payform($param);

            exit;
        }

        /* // 使用h5支付 wxpay_h5
         if ($this->payment_code == 'wxpay_h5') {
             $param['orderFee'] = 1;//(100 * $order_pay_info['order_amount']);
             $param['orderAttach'] = $order_pay_info['pkg_type']==1?'witching':'teaching';
             $api = new \wxpay_h5();
             $api->setConfigs($param);
             $mweburl = $api->get_payurl($this);
             if ($mweburl['result_code']=='SUCCESS') {
                 $redirect_url = urlencode('vip.xiangjianhai.com');
                 $mweburl['mweb_url'] .='&redirect_url='.$redirect_url;
             }
             output_data($mweburl);
             exit;
         }

         //alipay and so on
         $param['order_type'] = $order_pay_info['pkg_type']==1?'witching':'teaching';
         $param['orderFee'] = 0.0100;//$order_pay_info['order_amount'];//
         $payment_api = new $this->payment_code($param);
         $return = $payment_api->getSubmitUrl($param);
         echo $return;
         exit;*/
    }

    public function notify_url(){
        echo 'success';
    }

    public function order_status_check(){
        $pay_sn = input('post.pay_sn');
        if(!$pay_sn)output_error('订单号错误！');
        $Order = model('Packagesorder');

        $orderInfo = $Order->getOrderInfo(array('pay_sn'=>$pay_sn,'buyer_mobile'=>$this->member_info['member_mobile']));
        if(!$orderInfo)output_error('没有此订单信息！');
        if($this->payment_code == 'wxpay_h5'){
            $payment = new $this->payment_code();
        }else if($this->payment_code == 'alipay_app'){
            $payment = new $this->payment_code();
        }else{
            output_error('支付类型错误！');
        }
        $Status = $payment->getOrderStateBysn($orderInfo['pay_sn']);
        p($Status);exit;
        output_data($this);
    }



    /**
     * 验证密码
     */
    public function check_password()
    {
        if (empty($_POST['password'])) {
            output_error('参数错误');
        }

        $model_member = Model('member');

        $member_info = $model_member->getMemberInfoByID($this->member_info['member_id']);
        if ($member_info['member_paypwd'] == md5($_POST['password'])) {
            output_data('1');
        }
        else {
            output_error('密码错误');
        }
    }

    /**
     * AJAX验证支付密码
     */
    public function check_pd_pwd()
    {
        if (empty($_POST['password'])) {
            output_error('支付密码格式不正确');
        }
        $buyer_info = Model('member')->getMemberInfoByID($this->member_info['member_id'], 'member_paypwd');
        if ($buyer_info['member_paypwd'] != '') {
            if ($buyer_info['member_paypwd'] === md5($_POST['password'])) {
                output_data('1');
            }
        }
        output_error('支付密码验证失败');
    }


}