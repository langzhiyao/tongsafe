<?php

namespace app\common\model;

use think\Model;

class Vrorder extends Model {
    public $page_info;
    /**
     * 取单条订单信息
     *
     * @param array $condition
     * @return unknown
     */
    public function getOrderInfo($condition = array(), $fields = '*', $master = false) {
        $order_info = db('vrorder')->field($fields)->where($condition)->master($master)->find();
        if (empty($order_info)) {
            return array();
        }
        if (isset($order_info['order_state'])) {
            $order_info['state_desc'] = $this->_orderState($order_info['order_state']);
            $order_info['state_desc'] = $order_info['state_desc'][0];
        }
        if (isset($order_info['payment_code'])) {
            $order_info['payment_name'] = orderPaymentName($order_info['payment_code']);
        }
        return $order_info;
    }

    /**
     * 新增订单
     * @param array $data
     * @return int 返回 insert_id
     */
    public function addOrder($data) {
        $insert = db('vrorder')->insertGetId($data);
        return $insert;
    }

    /**
     * 更改订单信息
     *
     * @param array $data
     * @param array $condition
     */
    public function editOrder($data, $condition, $limit = '') {
        return db('vrorder')->where($condition)->limit($limit)->update($data);
    }

    /**
     * 取得订单列表(所有)
     * @param unknown $condition
     * @param string $pagesize
     * @param string $field
     * @param string $order
     * @return array
     */
    public function getOrderList($condition, $pagesize = '', $field = '*', $order = 'order_id asc', $limit = '') {
        if($pagesize){
            $list = db('order')->field($field)->where($condition)->order($order)->limit($limit)->paginate($pagesize,false,['query' => request()->param()]);
            $this->page_info = $list;
            $list = $list->items();
        }else{
            $list = db('order')->field($field)->where($condition)->order($order)->limit($limit)->select();
        }
        return $list;
    }

}
