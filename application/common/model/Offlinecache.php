<?php

namespace app\common\model;

use think\Model;

class Offlinecache extends Model {

    /**
     * 获取所有线下订单缓存信息
     * @创建时间   2018-12-04T17:40:06+0800
     * @param  [type]                   $condition [description]
     * @return [type]                              [description]
     */
    public function getAllOfflineCache($condition){
        return db('offlinecache')->where($condition)->order('updatetime desc')->select();
    }

    

    /**
     * 取数量
     * @param unknown $condition
     */
    public function getOfflineCacheCount($condition = array()) {
        return db('offlinecache')->where($condition)->count();
    }

    /**
     * 多个数据添加
     * @Author 老王
     * @创建时间   2019-06-24
     * @param  [type]     $param [description]
     * @return [type]            [description]
     */
    public function allCacheAdd($param) {
        return db('offlinecache')->insertAll($param);
    }

    /**
     * 新增线下订单缓存
     *
     * @param array $param 参数内容
     * @return bool 布尔类型的返回结果
     */
    public function addOfflineCache($param) {
        return db('offlinecache')->insertGetId($param);
    }

    /**
     * 取单个线下订单缓存信息
     *
     * @param int $id 线下订单缓存ID
     * @return array 数组类型的返回结果
     */
    public function getOneOfflineCache($id) {
        if (intval($id) > 0) {
            $result = db('offlinecache')->where('id',intval($id))->find();
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 根据卡号获取线下订单缓存信息
     * @创建时间   2018-12-04T18:29:55+0800
     * @param  [type]                   $card [description]
     * @return [type]                         [description]
     */
    public function getOneOfflineCacheByCard($condition,$order='id ASC') {
        return db('offlinecache')->where($condition)->order($order)->find();
    }

    /**
     * 更新线下订单缓存信息
     *
     * @param array $param 更新数据
     * @return bool 布尔类型的返回结果
     */
    public function editOfflineCache($update, $condition) {
        return db('offlinecache')->where($condition)->update($update);
    }

    /**

     * 修改单个字段
     * @创建时间  2018-12-04T19:05:19+0800
     * @param [type]                   $member_id [description]
     * @param [type]                   $key       [description]
     * @param [type]                   $value     [description]
     */
    public function SetOfflineCache($condition,$key,$value){
        return db('offlinecache')->where($condition)->setField($key, $value);   
    }


    /**
     * 删除线下订单缓存
     *
     * @param int $id 记录ID
     * @return bool 布尔类型的返回结果
     */
    public function delOfflineCache($condition) {
        return db('offlinecache')->where($condition)->delete();
    }

}

?>
