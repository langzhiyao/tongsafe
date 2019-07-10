<?php

namespace app\common\model;

use think\Model;

class Offlineorder extends Model {

    /**
     * 获取所有线下订单上传信息
     * @创建时间   2018-12-04T17:40:06+0800
     * @param  [type]                   $condition [description]
     * @return [type]                              [description]
     */
    public function getAllOfflineOrders($condition){
        return db('offlineorder')->where($condition)->order('updatetime desc')->select();
    }


    public function getOfflineOrderlList($condition, $page = '', $field = '*', $class = 'o.id desc', $limit = '', $extend = array(), $master = false) {
        $list_paginate = db('offlineorder')
                         ->alias('o')
                         ->join('__SCHOOL__ S','S.schoolid=o.school_id','LEFT')
                         ->field('o.*,S.name')
                         ->where($condition)
                         ->order($class)
                         ->paginate($page,false,['query' => request()->param()]);
        $this->page_info = $list_paginate;
        $list = $list_paginate->items();

        if (empty($list))
            return array();
        return $list;
    }

    /**
     * 取数量
     * @param unknown $condition
     */
    public function getOfflineOrdersCount($condition = array()) {
        return db('offlineorder')->where($condition)->count();
    }

    /**
     * 新增线下订单上传
     *
     * @param array $param 参数内容
     * @return bool 布尔类型的返回结果
     */
    public function addOfflineOrders($param) {
        return db('offlineorder')->insertGetId($param);
    }

    /**
     * 取单个线下订单上传信息
     *
     * @param int $id 线下订单上传ID
     * @return array 数组类型的返回结果
     */
    public function getOneOfflineOrders($id) {
        if (intval($id) > 0) {
            
            $result = db('offlineorder')->where('id',intval($id))->find();
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 根据卡号获取线下订单上传信息
     * @创建时间   2018-12-04T18:29:55+0800
     * @param  [type]                   $card [description]
     * @return [type]                         [description]
     */
    public function getOneOfflineOrdersByCard($condition,$order='id ASC') {
        return db('offlineorder')->where($condition)->order($order)->find();
    }

    /**
     * 更新线下订单上传信息
     *
     * @param array $param 更新数据
     * @return bool 布尔类型的返回结果
     */
    public function editOfflineOrders($update, $condition) {
        return db('offlineorder')->where($condition)->update($update);
    }

    /**
     * 修改单个字段
     * @创建时间  2018-12-04T19:05:19+0800
     * @param [type]                   $member_id [description]
     * @param [type]                   $key       [description]
     * @param [type]                   $value     [description]
     */
    public function SetOfflineOrders($condition,$key,$value){
        return db('offlineorder')->where($condition)->setField($key, $value);   
    }


    /**
     * 删除线下订单上传
     *
     * @param int $id 记录ID
     * @return bool 布尔类型的返回结果
     */
    public function delOfflineOrders($condition) {
        return db('offlineorder')->where($condition)->delete();
    }

}

?>
