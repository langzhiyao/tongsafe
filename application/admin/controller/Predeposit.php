<?php

namespace app\admin\controller;

use think\Lang;
use think\Validate;
use think\model;

class Predeposit extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/zh-cn/predeposit.lang.php');
    }

    /*
     * 充值明细
     */

    public function pdrecharge_list() {
        $condition = array();
        $if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', input('param.query_start_date'));
        $if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', input('param.query_end_date'));
        $start_unixtime = $if_start_date ? strtotime(input('param.query_start_date')) : null;
        $end_unixtime = $if_end_date ? strtotime(input('param.query_end_date')) : null;
        if ($start_unixtime || $end_unixtime) {
            $condition['pdr_add_time'] = array('between', array($start_unixtime, $end_unixtime));
        }
        if (input('param.mname') != '') {
            $condition['pdr_member_name'] = input('param.mname');
        }
        if (input('param.paystate_search') != '') {
            $condition['pdr_payment_state'] = input('param.paystate_search');
        }
        $model_pd = Model('predeposit');
        $recharge_list = $model_pd->getPdRechargeList($condition, 20, '*', 'pdr_id desc');
        $this->assign('recharge_list', $recharge_list);
        $this->setAdminCurItem('pdrecharge_list');
        return $this->fetch();
    }

    /**
     * 充值编辑(更改成收到款)
     */
    public function recharge_edit() {
        $id = intval(input('param.id'));
        if ($id <= 0) {
            $this->error(lang('admin_predeposit_parameter_error'), 'admin/Predeposit/pdrecharge_list');
        }
        //查询充值信息
        $model_pd = Model('predeposit');
        $condition = array();
        $condition['pdr_id'] = $id;
        $condition['pdr_payment_state'] = 0;
        $info = $model_pd->getPdRechargeInfo($condition);
        if (empty($info)) {
            $this->error(lang('admin_predeposit_record_error'), 'admin/Predeposit/pdrecharge_list');
        }
        if (!request()->isPost()) {
            //显示支付接口列表
            $payment_list = Model('payment')->getPaymentOpenList();
            //去掉预存款和货到付款
            foreach ($payment_list as $key => $value) {
                if ($value['payment_code'] == 'predeposit' || $value['payment_code'] == 'offline') {
                    unset($payment_list[$key]);
                }
            }
            $this->assign('payment_list', $payment_list);
            $this->assign('info', $info);
            $this->setAdminCurItem('recharge_edit');
            return $this->fetch('recharge_edit');
            exit();
        }

        //取支付方式信息
        $model_payment = Model('payment');
        $condition = array();
        $condition['payment_code'] = $_POST['payment_code'];
        $payment_info = $model_payment->getPaymentOpenInfo($condition);
        if (!$payment_info || $payment_info['payment_code'] == 'offline' || $payment_info['payment_code'] == 'offline') {
            $this->error(lang('payment_index_sys_not_support'));
        }

        $condition = array();
        $condition['pdr_sn'] = $info['pdr_sn'];
        $condition['pdr_payment_state'] = 0;
        $update = array();
        $update['pdr_payment_state'] = 1;
        $update['pdr_payment_time'] = strtotime($_POST['payment_time']);
        $update['pdr_payment_code'] = $payment_info['payment_code'];
        $update['pdr_payment_name'] = $payment_info['payment_name'];
        $update['pdr_trade_sn'] = $_POST['trade_no'];
        $update['pdr_admin'] = $this->admin_info['admin_name'];
        $log_msg = lang('admin_predeposit_recharge_edit_state') . ',' . lang('admin_predeposit_sn') . ':' . $info['pdr_sn'];

        try {
//            $model_pd->startTrans();
            $model_pd->startTrans();
            //更改充值状态
            $state = $model_pd->editPdRecharge($update, $condition);
            if (!$state) {
                throw Exception(lang('predeposit_payment_pay_fail'));
            }
            //变更会员预存款
            $data = array();
            $data['member_id'] = $info['pdr_member_id'];
            $data['member_name'] = $info['pdr_member_name'];
            $data['amount'] = $info['pdr_amount'];
            $data['pdr_sn'] = $info['pdr_sn'];
            $data['admin_name'] = $this->admin_info['admin_name'];
            $model_pd->changePd('recharge', $data);
            $model_pd->commit();
            $this->log($log_msg, 1);
            $this->success(lang('admin_predeposit_recharge_edit_success'), 'admin/Predeposit/pdrecharge_list');
        } catch (Exception $e) {
            $model_pd->rollback();
            $this->log($log_msg, 0);
            $this->error($e->getMessage(), 'admin/Predeposit/pdrecharge_list');
        }
    }

    /**
     * 充值查看
     */
    public function recharge_info() {
        $id = intval(input('param.id'));
        if ($id <= 0) {
            $this->error(lang('admin_predeposit_parameter_error'), 'admin/Predeposit/pdrecharge_list');
        }
        //查询充值信息
        $model_pd = Model('predeposit');
        $condition = array();
        $condition['pdr_id'] = $id;
        $info = $model_pd->getPdRechargeInfo($condition);
        if (empty($info)) {
            $this->error(lang('admin_predeposit_record_error'), 'admin/Predeposit/pdrecharge_list');
        }
        $this->assign('info', $info);
        $this->setAdminCurItem('recharge_info');
        return $this->fetch('recharge_info');
    }

    /**
     * 充值删除
     */
    public function recharge_del() {
        $pdr_id = intval(input('param.id'));
        if ($pdr_id <= 0) {
            $this->error(lang('admin_predeposit_parameter_error'), '/Admin/Predeposit/pdrecharge_list');
        }
        $model_pd = Model('predeposit');
        $condition = array();
        $condition['pdr_id'] = "$pdr_id";
        $condition['pdr_payment_state'] = 0;
        $result = $model_pd->delPdRecharge($condition);
        if ($result) {
            $this->success(lang('admin_predeposit_recharge_del_success'), '/Admin/Predeposit/pdrecharge_list');
        } else {
            $this->error(lang('admin_predeposit_recharge_del_fail'), '/Admin/Predeposit/pdrecharge_list');
        }
    }



    /*
     * 预存款明细
     */

    public function pdlog_list() {
        $condition = array();
        $stime = input('get.stime');
        $etime = input('get.etime');
        $if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $stime);
        $if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $etime);
        $start_unixtime = $if_start_date ? strtotime($stime) : null;
        $end_unixtime = $if_end_date ? strtotime($etime) : null;
        if ($start_unixtime || $end_unixtime) {
            $condition['lg_add_time'] = array('between', array($start_unixtime, $end_unixtime));
        }
        $mname = input('get.mname');
        if (!empty($mname)) {
            $condition['lg_member_name'] = $mname;
        }
        $aname = input('get.aname');
        if (!empty($aname)) {
            $condition['lg_admin_name'] = $aname;
        }
        $model_pd = Model('predeposit');
        $list_log = $model_pd->getPdLogList($condition, 10, '*', 'lg_id desc');
        $this->assign('show_page', $model_pd->page_info->render());
        $this->assign('list_log', $list_log);
        $this->setAdminCurItem('pdlog_list');
        return $this->fetch();
    }

    /*
     * 提现列表
     */
    public function pdcash_list() {
        $condition = array();
        $stime = input('get.stime');
        $etime = input('get.etime');
        $if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $stime);
        $if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $etime);
        $start_unixtime = $if_start_date ? strtotime($stime) : null;
        $end_unixtime = $if_end_date ? strtotime($etime) : null;
        if ($start_unixtime || $end_unixtime) {
            $condition['pdc_add_time'] = array('between', array($start_unixtime, $end_unixtime));
        }
        $mname = input('get.mname');
        if (!empty($mname)) {
            $condition['pdc_member_name'] = $mname;
        }
        $pdc_bank_user = input('get.pdc_bank_user');
        if (!empty($pdc_bank_user)) {
            $condition['pdc_bank_user'] = $pdc_bank_user;
        }
        $paystate_search = input('get.paystate_search');
        if ($paystate_search != '') {
            $condition['pdc_payment_state'] = $paystate_search;
        }

        $model_pd = Model('predeposit');
        $cash_list = $model_pd->getPdCashList($condition, 20, '*', 'pdc_payment_state asc,pdc_id asc');
        $this->assign('list', $cash_list);
        $this->assign('show_page', $model_pd->page_info->render());
        $this->setAdminCurItem('pdcash_list');
        return $this->fetch('pdcash_list');
    }

    /**
     * 删除提现记录
     */
    public function pdcash_del() {
        $pdc_id = intval(input('param.id'));
        if ($pdc_id <= 0) {
            $this->error(lang('admin_predeposit_parameter_error'), '/Admin/Predeposit/pdcash_list');
        }
        $model_pd = Model('predeposit');
        $condition = array();
        $condition['pdc_id'] = $pdc_id;
        $condition['pdc_payment_state'] = 0;
        $info = $model_pd->getPdCashInfo($condition);
        if (!$info) {
            $this->error(lang('admin_predeposit_parameter_error'), '/Admin/Predeposit/pdcash_list');
        }
        try {
            $result = $model_pd->delPdCash($condition);
            if (!$result) {
                exception(lang('admin_predeposit_cash_del_fail'));
            }
            //退还冻结的预存款
            $model_member = Model('member');
            $member_info = $model_member->getMemberInfo(array('member_id' => $info['pdc_member_id']));
            //扣除冻结的预存款
            $admininfo = $this->getAdminInfo();
            $data = array();
            $data['member_id'] = $member_info['member_id'];
            $data['member_name'] = $member_info['member_name'];
            $data['amount'] = $info['pdc_amount'];
            $data['order_sn'] = $info['pdc_sn'];
            $data['admin_name'] = $admininfo['admin_name'];
            $model_pd->changePd('cash_del', $data);
            $model_pd->commit();
            $this->success(lang('admin_predeposit_cash_del_success'), '/Admin/Predeposit/pdcash_list');
        } catch (Exception $e) {
            $model_pd->commit();
            $this->error($e->getMessage(), '/Admin/Predeposit/pdcash_list');
        }
    }

    /**
     * 更改提现为支付状态
     */
    public function pdcash_pay() {
        $id = intval(input('param.id'));
        if ($id <= 0) {
            $this->error(lang('admin_predeposit_parameter_error'),'/Admin/Predeposit/pdcash_list');
        }
        $model_pd = Model('predeposit');
        $condition = array();
        $condition['pdc_id'] = $id;
        $condition['pdc_payment_state'] = 0;
        $info = $model_pd->getPdCashInfo($condition);
        if (!is_array($info) || count($info) < 0) {
            $this->error(lang('admin_predeposit_record_error'), '/Admin/Predeposit/pdcash_list');
        }
        //查询用户信息
        $model_member = Model('member');
        $member_info = $model_member->getMemberInfo(array('member_id' => $info['pdc_member_id']));

        $update = array();
        $admininfo = $this->getAdminInfo();
        $update['pdc_payment_state'] = 1;
        $update['pdc_payment_admin'] = $admininfo['admin_name'];
        $update['pdc_payment_time'] = TIMESTAMP;
        $log_msg = lang('admin_predeposit_cash_edit_state') . ',' . lang('admin_predeposit_cs_sn') . ':' . $info['pdc_sn'];

        try {
//            $model_pd->startTrans();
            $model_pd->startTrans();
            $result = $model_pd->editPdCash($update, $condition);
            if (!$result) {
                $this->error(lang('admin_predeposit_cash_edit_fail'));
            }
            //扣除冻结的预存款
            $data = array();
            $data['member_id'] = $member_info['member_id'];
            $data['member_name'] = $member_info['member_name'];
            $data['amount'] = $info['pdc_amount'];
            $data['order_sn'] = $info['pdc_sn'];
            $data['admin_name'] = $admininfo['admin_name'];
            $model_pd->changePd('cash_pay', $data);
            $model_pd->commit();
            $this->log($log_msg, 1);
            $this->success(lang('admin_predeposit_cash_edit_success'), 'Predeposit/pdcash_list');
        } catch (Exception $e) {
            $model_pd->rollback();
            $this->log($log_msg, 0);
            $this->error($e->getMessage(), 'Predeposit/pdcash_list');
        }
    }

    /**
     * 查看提现信息
     */
    public function pdcash_view() {
        $id = intval(input('param.id'));
        if ($id <= 0) {
            $this->error(lang('admin_predeposit_parameter_error'), '/Admin/Predeposit/pdcash_list');
        }
        $model_pd = Model('predeposit');
        $condition = array();
        $condition['pdc_id'] = $id;
        $info = $model_pd->getPdCashInfo($condition);
        if (!is_array($info) || count($info) < 0) {
            $this->error(lang('admin_predeposit_record_error'), '/Admin/Predeposit/pdcash_list');
        }
        $this->assign('info', $info);
        $this->setAdminCurItem('pdcash_list');
        return $this->fetch();
    }

    /*
     * 调节预存款
     */

    public function pd_add() {
        if (!(request()->isPost())) {
            $this->setAdminCurItem('pd_add');
            return $this->fetch();
        } else {
            $data = array(
                'member_id' => input('post.member_id'),
                'amount' => input('post.amount'),
                'operatetype' => input('post.operatetype'),
                'lg_desc' => input('post.lg_desc'),
            );
            //验证 BEGIN
            $rule = [
                ['member_id', 'require|number', '用户名必须存在|用户名错误'],
                ['amount', 'require', '金额为必填'],
                ['operatetype', 'require', '增减类型为必填'],
            ];
            $validate = new Validate($rule);
            $validate_result = $validate->check($data);
            if (!$validate_result) {
                $this->error($validate->getError());
            }
            //验证 END



            $money = abs(floatval(input('post.amount')));
            $memo = trim(input('post.lg_desc'));
            if ($money <= 0) {
                $this->error('输入的金额必需大于0');
            }
            //查询会员信息
            $member_mod = Model('member');
            $member_id = intval(input('post.member_id'));
            $operatetype = input('post.operatetype');
            $member_info = $member_mod->getMemberInfo(array('member_id' => $member_id));

            if (!is_array($member_info) || count($member_info) <= 0) {
                $this->error('用户不存在', 'Predeposit/pd_add');
            }
            $available_predeposit = floatval($member_info['available_predeposit']);
            $freeze_predeposit = floatval($member_info['freeze_predeposit']);
            if ($operatetype == 2 && $money > $available_predeposit) {
                $this->error(('预存款不足，会员当前预存款') . $available_predeposit, 'Predeposit/pd_add');
            }
            if ($operatetype == 3 && $money > $available_predeposit) {
                $this->error(('可冻结预存款不足，会员当前预存款') . $available_predeposit, 'Predeposit/pd_add');
            }
            if ($operatetype == 4 && $money > $freeze_predeposit) {
                $this->error(('可恢复冻结预存款不足，会员当前冻结预存款') . $freeze_predeposit, 'Predeposit/pd_add');
            }
            $model_pd = Model('predeposit');
            $order_sn = $model_pd->makeSn();
            $admininfo = $this->getAdminInfo();
            $log_msg = "管理员【" . $admininfo['admin_name'] . "】操作会员【" . $member_info['member_name'] . "】预存款，金额为" . $money . ",编号为" . $order_sn;
            $admin_act = "sys_add_money";
            switch ($operatetype) {
                case 1:
                    $admin_act = "sys_add_money";
                    $log_msg = "管理员【" . $admininfo['admin_name'] . "】操作会员【" . $member_info['member_name'] . "】预存款【增加】，金额为" . $money . ",编号为" . $order_sn;
                    break;
                case 2:
                    $admin_act = "sys_del_money";
                    $log_msg = "管理员【" . $admininfo['admin_name'] . "】操作会员【" . $member_info['member_name'] . "】预存款【减少】，金额为" . $money . ",编号为" . $order_sn;
                    break;
                case 3:
                    $admin_act = "sys_freeze_money";
                    $log_msg = "管理员【" . $admininfo['admin_name'] . "】操作会员【" . $member_info['member_name'] . "】预存款【冻结】，金额为" . $money . ",编号为" . $order_sn;
                    break;
                case 4:
                    $admin_act = "sys_unfreeze_money";
                    $log_msg = "管理员【" . $admininfo['admin_name'] . "】操作会员【" . $member_info['member_name'] . "】预存款【解冻】，金额为" . $money . ",编号为" . $order_sn;
                    break;
                default:
                    $this->error('操作失败', 'Predeposit/pdlog_list');
                    break;
            }
            try {
                $model_pd->startTrans();
                //扣除冻结的预存款
                $data = array();
                $data['member_id'] = $member_info['member_id'];
                $data['member_name'] = $member_info['member_name'];
                $data['amount'] = $money;
                $data['order_sn'] = $order_sn;
                $data['admin_name'] = $admininfo['admin_name'];
                $data['pdr_sn'] = $order_sn;
                $data['lg_desc'] = $memo;
                $model_pd->changePd($admin_act, $data);
                $model_pd->commit();
                $this->log($log_msg, 1);
                $this->success('操作成功', 'Predeposit/pdlog_list');
            } catch (Exception $e) {
                $model_pd->rollback();
                $this->log($log_msg, 0);
                $this->error($e->getMessage(), 'Predeposit/pdlog_list');
            }
        }
    }

    //取得会员信息
    public function checkmember() {
        $name = input('post.name');
        if (!$name) {
            exit(json_encode(array('id' => 0)));
            die;
        }
        $obj_member = model('member');
        $member_info = $obj_member->getMemberInfo(array('member_name' => $name));
        if (is_array($member_info) && count($member_info) > 0) {
            exit(json_encode(array('id' => $member_info['member_id'], 'name' => $member_info['member_name'], 'available_predeposit' => $member_info['available_predeposit'], 'freeze_predeposit' => $member_info['freeze_predeposit'])));
        } else {
            exit(json_encode(array('id' => 0)));
        }
    }
    
    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'pdrecharge_list',
                'text' => '充值明细',
                'url' => url('Admin/Predeposit/pdrecharge_list')
            ),
            array(
                'name' => 'pdcash_list',
                'text' => '提现管理',
                'url' => url('Admin/Predeposit/pdcash_list')
            ),
            array(
                'name' => 'pdlog_list',
                'text' => '预存款明细',
                'url' => url('Admin/Predeposit/pdlog_list')
            ),
            array(
                'name' => 'pd_add',
                'text' => '预存款调节',
                'url' => url('Admin/Predeposit/pd_add')
            ),
        );
        return $menu_array;
    }
}

?>
