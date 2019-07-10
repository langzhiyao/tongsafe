<?php

namespace app\home\controller;


use think\Validate;

class Sellermsg extends BaseSeller
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
    }

    /**
     * 消息列表
     */
    public function index()
    {
        $where = array();
        $where['store_id'] = session('store_id');
        if (!session('seller_is_admin')) {
            $where['smt_code'] = array('in', session('seller_smt_limits'));
        }
        $model_storemsg = Model('storemsg');
        $msg_list = $model_storemsg->getStoreMsgList($where, '*', 10);

        // 整理数据
        if (!empty($msg_list)) {
            foreach ($msg_list as $key => $val) {
                $msg_list[$key]['sm_readids'] = explode(',', $val['sm_readids']);
            }
        }
        $this->assign('msg_list', $msg_list);
        $this->assign('show_page', $model_storemsg->page_info->render());


        $this->setSellerCurMenu('Sellermsg');
        $this->setSellerCurItem('msg_list');
        return $this->fetch($this->template_dir . 'index');
    }

    /**
     * 消息详细
     */
    public function msg_info()
    {
        $sm_id = intval(input('param.sm_id'));
        if ($sm_id <= 0) {
            $this->error(lang('wrong_argument'));
        }
        $model_storemsg = Model('storemsg');
        $where = array();
        $where['sm_id'] = $sm_id;
        if (session('seller_smt_limits') !== false) {
            $where['smt_code'] = array('in', session('seller_smt_limits'));
        }
        $msg_info = $model_storemsg->getStoreMsgInfo($where);
        if (empty($msg_info)) {
            $this->error(lang('wrong_argument'));
        }
        $this->assign('msg_list', $msg_info);

        // 验证时候已读
        $sm_readids = explode(',', $msg_info['sm_readids']);
        if (!in_array(session('seller_id'), $sm_readids)) {
            // 消息阅读表插入数据
            $condition = array();
            $condition['seller_id'] = session('seller_id');
            $condition['sm_id'] = $sm_id;
            Model('storemsgread')->addStoreMsgRead($condition);

            $update = array();
            $sm_readids[] = session('seller_id');
            $update['sm_readids'] = implode(',', $sm_readids) . ',';
            $model_storemsg->editStoreMsg(array('sm_id' => $sm_id), $update);

            // 清除店铺消息数量缓存
            cookie('storemsgnewnum' . session('seller_id'), 0, -3600);
        }

        return $this->fetch($this->template_dir.'msg_info');
    }

    /**
     * AJAX标记为已读
     */
    public function mark_as_read()
    {
        $smids = input('param.smids');
        if (!preg_match('/^[\d,]+$/i', $smids)) {
            showDialog(lang('para_error'), '', 'error');
        }

        $smids = explode(',', $smids);
        $model_storemsgread = Model('storemsgread');
        $model_storemsg = Model('storemsg');
        foreach ($smids as $val) {
            $condition = array();
            $condition['seller_id'] = session('seller_id');
            $condition['sm_id'] = $val;
            $read_info = $model_storemsgread->getStoreMsgReadInfo($condition);
            if (empty($read_info)) {
                // 消息阅读表插入数据
                $model_storemsgread->addStoreMsgRead($condition);

                // 更新店铺消息表
                $storemsg_info = $model_storemsg->getStoreMsgInfo(array('sm_id' => $val));
                $sm_readids = explode(',', $storemsg_info['sm_readids']);
                $sm_readids[] = session('seller_id');
                $sm_readids = array_unique($sm_readids);
                $update = array();
                $update['sm_readids'] = implode(',', $sm_readids) . ',';
                $model_storemsg->editStoreMsg(array('sm_id' => $val), $update);
            }
        }

        // 清除店铺消息数量缓存
        cookie('storemsgnewnum' . session('seller_id'), 0, -3600);

        showDialog(lang('ds_common_op_succ'), 'reload', 'succ');
    }

    /**
     * AJAX删除消息
     */
    public function del_msg()
    {
        // 验证参数
        $smids = input('param.smids');
        if (!preg_match('/^[\d,]+$/i', $smids)) {
            showDialog(lang('para_error'), '', 'error');
        }
        $smid_array = explode(',', $smids);

        // 验证是否为管理员
        if (!$this->checkIsAdmin()) {
            showDialog(lang('para_error'), '', 'error');
        }

        $where = array();
        $where['store_id'] = session('store_id');
        $where['sm_id'] = array('in', $smid_array);
        // 删除消息记录
        Model('storemsg')->delStoreMsg($where);
        // 删除阅读记录
        unset($where['store_id']);
        Model('storemsgread')->delStoreMsgRead($where);
        // 清除店铺消息数量缓存
        cookie('storemsgnewnum' . session('seller_id'), 0, -3600);
        showDialog(lang('ds_common_op_succ'), 'reload', 'succ');
    }

    /**
     * 消息接收设置
     */
    public function msg_setting()
    {
        // 验证是否为管理员
        if (!$this->checkIsAdmin()) {
            showDialog(lang('para_error'), '', 'error');
        }

        // 店铺消息模板列表
        $smt_list = Model('storemsgtpl')->getStoreMsgTplList(array(), 'smt_code,smt_name,smt_message_switch,smt_message_forced,smt_short_switch,smt_short_forced,smt_mail_switch,smt_mail_forced');

        // 店铺接收设置
        $setting_list = Model('storemsgsetting')->getStoreMsgSettingList(array('store_id' => session('store_id')), '*', 'smt_code');

        if (!empty($smt_list)) {
            foreach ($smt_list as $key => $val) {
                // 站内信消息模板是否开启
                if ($val['smt_message_switch']) {
                    // 是否强制接收，强制接收必须开启
                    $smt_list[$key]['sms_message_switch'] = $val['smt_message_forced'] ? 1 : intval($setting_list[$val['smt_code']]['sms_message_switch']);

                    // 已开启接收模板
                    if ($smt_list[$key]['sms_message_switch']) {
                        $smt_list[$key]['is_opened'][] = '商家消息';
                    }
                }
                // 短消息模板是否开启
                if ($val['smt_short_switch']) {
                    // 是否强制接收，强制接收必须开启
                    $smt_list[$key]['sms_short_switch'] = $val['smt_short_forced'] ? 1 : intval($setting_list[$val['smt_code']]['sms_short_switch']);

                    // 已开启接收模板
                    if ($smt_list[$key]['sms_short_switch']) {
                        $smt_list[$key]['is_opened'][] = '手机短信';
                    }
                }
                // 邮件模板是否开启
                if ($val['smt_mail_switch']) {
                    // 是否强制接收，强制接收必须开启
                    $smt_list[$key]['sms_mail_switch'] = $val['smt_mail_forced'] ? 1 : intval($setting_list[$val['smt_code']]['sms_mail_switch']);

                    // 已开启接收模板
                    if ($smt_list[$key]['sms_mail_switch']) {
                        $smt_list[$key]['is_opened'][] = '邮件';
                    }
                }

                if (is_array($smt_list[$key]['is_opened'])) {
                    $smt_list[$key]['is_opened'] = implode('&nbsp;|&nbsp;&nbsp;', $smt_list[$key]['is_opened']);
                }
            }
        }
        $this->assign('smt_list', $smt_list);

        $this->setSellerCurMenu('Sellermsg');
        $this->setSellerCurItem('msg_setting');
        return $this->fetch($this->template_dir . 'msg_setting');
    }

    /**
     * 编辑店铺消息接收设置
     */
    public function edit_msg_setting()
    {
        // 验证是否为管理员
        if (!$this->checkIsAdmin()) {
            showDialog(lang('para_error'), '', 'error');
        }
        $code = trim(input('param.code'));
        if ($code == '') {
            return false;
        }
        // 店铺消息模板
        $smt_info = Model('storemsgtpl')->getStoreMsgTplInfo(array('smt_code' => $code), 'smt_code,smt_name,smt_message_switch,smt_message_forced,smt_short_switch,smt_short_forced,smt_mail_switch,smt_mail_forced');
        if (empty($smt_info)) {
            return false;
        }

        // 店铺消息接收设置
        $setting_info = Model('storemsgsetting')->getStoreMsgSettingInfo(array(
                                                                             'smt_code' => $code,
                                                                             'store_id' => session('store_id')
                                                                         ));
        $this->assign('smt_info', $smt_info);
        $this->assign('smsetting_info', $setting_info);
        return $this->fetch($this->template_dir . 'setting_edit');
    }

    /**
     * 保存店铺接收设置
     */
    public function save_msg_setting()
    {
        // 验证是否为管理员
        if (!$this->checkIsAdmin()) {
            showDialog(lang('para_error'), '', 'error');
        }
        $code = trim($_POST['code']);
        if ($code == '') {
            showDialog(lang('wrong_argument'), 'reload');
        }
        if (isset($_POST["short_number"]) && isset($_POST["mail_number"])) {
            $obj_validate = new Validate();
            $data = [
                'short_number' => $_POST["short_number"], 'mail_number' => $_POST["mail_number"],
            ];
            $rule = [
                ['short_number', '^1[0-9]{10}$', '请填写正确的手机号码'], ['mail_number', 'email', '请填写正确的邮箱']
            ];

            $error = $obj_validate->check($data, $rule);
            if (!$error) {
                showDialog($obj_validate->getError(), 'reload');
            }
        }
            $smt_info = Model('storemsgtpl')->getStoreMsgTplInfo(array('smt_code' => $code), 'smt_code,smt_name,smt_message_switch,smt_message_forced,smt_short_switch,smt_short_forced,smt_mail_switch,smt_mail_forced');

            // 保存
            $insert = array();
            $insert['smt_code'] = $smt_info['smt_code'];
            $insert['store_id'] = session('store_id');
            // 验证站内信是否开启
            if ($smt_info['smt_message_switch']) {
                $insert['sms_message_switch'] = $smt_info['smt_message_forced'] ? 1 : intval($_POST['message_forced']);
            }
            else {
                $insert['sms_message_switch'] = 0;
            }
            // 验证短消息是否开启
            if ($smt_info['smt_short_switch']) {
                $insert['sms_short_switch'] = $smt_info['smt_short_forced'] ? 1 : intval($_POST['short_forced']);
            }
            else {
                $insert['sms_short_switch'] = 0;
            }
            $insert['sms_short_number'] = isset($_POST['short_number']) ? $_POST['short_number'] : '';
            // 验证邮件是否开启
            if ($smt_info['smt_mail_switch']) {
                $insert['sms_mail_switch'] = $smt_info['smt_mail_forced'] ? 1 : intval($_POST['mail_forced']);
            }
            else {
                $insert['sms_mail_switch'] = 0;
            }
            $insert['sms_mail_number'] = isset($_POST['mail_number']) ? $_POST['mail_number'] : '';

            $result = Model('storemsgsetting')->addStoreMsgSetting($insert);
            if ($result) {
                showDialog(lang('ds_common_op_succ'), 'reload', 'succ');
            }
            else {
                showDialog(lang('ds_common_op_fail'), 'reload');
            }
        }

        private function checkIsAdmin()
        {
            return session('seller_is_admin') ? true : false;
        }

        /**
         * 用户中心右边，小导航
         *
         * @param string $name 当前导航的name
         * @param array $array 附加菜单
         * @return
         */
        protected function getSellerItemList()
        {
            $menu_array = array(
                1 => array('name' => 'msg_list', 'text' => '消息列表', 'url' => url('sellermsg/index')), 2 => array(
                    'name' => 'msg_setting', 'text' => '消息接收设置', 'url' => url('sellermsg/msg_setting')
                ),
            );
            if (!$this->checkIsAdmin()) {
                unset($menu_array[2]);
            }
            return $menu_array;
        }
    }