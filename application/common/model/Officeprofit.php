<?php

namespace app\common\model;

use think\Model;

class Officeprofit extends Model {

    /**
     * 获取所有代理分润记录信息
     * @创建时间   2018-12-04T17:40:06+0800
     * @param  [type]                   $condition [description]
     * @return [type]                              [description]
     */
    public function getAllOfficeProfit($condition){
        return db('officeprofit')->where($condition)->order('updatetime desc')->select();
    }

    

    /**
     * 取数量
     * @param unknown $condition
     */
    public function getOfficeProfitCount($condition = array()) {
        return db('officeprofit')->where($condition)->count();
    }

    /**
     * 多个数据添加
     * @Author 老王
     * @创建时间   2019-06-24
     * @param  [type]     $param [description]
     * @return [type]            [description]
     */
    public function allOfficeProfitAdd($param) {
        return db('officeprofit')->insertAll($param);
    }

    /**
     * 新增代理分润记录
     *
     * @param array $param 参数内容
     * @return bool 布尔类型的返回结果
     */
    public function addOfficeProfit($param) {
        return db('officeprofit')->insertGetId($param);
    }

    /**
     * 取单个代理分润记录信息
     *
     * @param int $bank_id 代理分润记录ID
     * @return array 数组类型的返回结果
     */
    public function getOneOfficeProfit($id) {
        if (intval($id) > 0) {
            $result = db('officeprofit')->where('bank_id',intval($id))->find();
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 根据卡号获取代理分润记录信息
     * @创建时间   2018-12-04T18:29:55+0800
     * @param  [type]                   $card [description]
     * @return [type]                         [description]
     */
    public function getOneOfficeProfitByCard($condition,$order='bank_id ASC') {
        return db('officeprofit')->where($condition)->order($order)->find();
    }

    /**
     * 更新代理分润记录信息
     *
     * @param array $param 更新数据
     * @return bool 布尔类型的返回结果
     */
    public function editOfficeProfit($update, $condition) {
        return db('officeprofit')->where($condition)->update($update);
    }

    /**

     * 修改单个字段
     * @创建时间  2018-12-04T19:05:19+0800
     * @param [type]                   $member_id [description]
     * @param [type]                   $key       [description]
     * @param [type]                   $value     [description]
     */
    public function SetOfficeProfit($condition,$key,$value){
        return db('officeprofit')->where($condition)->setField($key, $value);   
    }


    /**
     * 删除代理分润记录
     *
     * @param int $id 记录ID
     * @return bool 布尔类型的返回结果
     */
    public function delOfficeProfit($condition) {
        return db('officeprofit')->where($condition)->delete();
    }

}

?>
