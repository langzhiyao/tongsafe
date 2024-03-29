<?php

namespace app\mobile\controller;


class Memberevaluate extends MobileMember
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
    }

    /**
     * 评论
     */
    public function index()
    {
        $order_id = intval(input('param.order_id'));
        $return = model('memberevaluate','logic')->validation($order_id, $this->member_info['member_id']);
        if (isset($return['state'])) {
            output_error($return['msg']);
        }
        extract($return['data']);

        $store = array();
        $store['store_id'] = $store_info['store_id'];
        $store['store_name'] = $store_info['store_name'];
        $store['is_own_shop'] = $store_info['is_own_shop'];

        output_data(array('store_info' => $store, 'order_goods' => $order_goods));
    }

    /**
     * 评论保存
     */
    public function save()
    {
        $order_id = intval($_POST['order_id']);
        $return = model('memberevaluate','logic')->validation($order_id, $this->member_info['member_id']);
        if (isset($return['state'])) {
            output_error($return['msg']);
        }
        //halt($return);
        extract($return['data']);
        $return = model('memberevaluate','logic')->saveorderevaluate($_POST, $order_info, $store_info, $order_goods, $this->member_info['member_id'], $this->member_info['member_name']);

        if (!$return['state']) {
            output_data($return['msg']);
        }
        else {
            output_data('1');
        }
    }

    /**
     * 追评
     */
    public function again()
    {
        $order_id = intval(input('param.order_id'));
        $return = model('memberevaluate','logic')->validationAgain($order_id, $this->member_info['member_id']);
        if (!$return['state']) {
            output_error($return['msg']);
        }
        extract($return['data']);
        $store = array();
        $store['store_id'] = $store_info['store_id'];
        $store['store_name'] = $store_info['store_name'];
        $store['is_own_shop'] = $store_info['is_own_shop'];

        output_data(array('store_info' => $store, 'evaluate_goods' => $evaluate_goods));
    }

    /**
     * 追加评价保存
     */
    public function save_again()
    {
        $order_id = intval($_POST['order_id']);
        $return = model('memberevaluate','logic')->validationAgain($order_id, $this->member_info['member_id']);
        if (!$return['state']) {
            output_error($return['msg']);
        }
        extract($return['data']);

        $return = model('memberevaluate','logic')->saveAgain($_POST, $order_info, $evaluate_goods);
        if (!$return['state']) {
            output_data($return['msg']);
        }
        else {
            output_data('1');
        }
    }

    /**
     * 虚拟订单评价
     */
    public function vr()
    {
        $order_id = intval(input('param.order_id'));
        $return = model('memberevaluate','logic')->validationVr($order_id, $this->member_info['member_id']);
        if (isset($return['state'])) {
            output_error($return['msg']);
        }
        extract($return['data']);
        output_data(array('order_info' => $order_info));
    }

    /**
     * 虚拟订单评价保存
     */
    public function save_vr()
    {
        $order_id = intval($_POST['order_id']);
        $return = model('memberevaluate','logic')->validationVr($order_id, $this->member_info['member_id']);
        if (isset($return['state'])) {
            output_error($return['msg']);
        }
        extract($return['data']);

        $return = model('memberevaluate','logic')->saveVr($_POST, $order_info, $store_info, $this->member_info['member_id'], $this->member_info['member_name']);
        if (!$return['state']) {
            output_data($return['msg']);
        }
        else {
            output_data('1');
        }
    }
}