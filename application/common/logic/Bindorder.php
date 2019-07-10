<?php

namespace app\common\logic;


use think\Model;

class Bindorder extends Model
{
    
    /**
     * 绑定线下订单
     * @Author 老王
     * @创建时间   2019-07-03
     * @param  [type]     $member [description]
     */
    public function BindOfflineOrder($member,$student){
        $memberModel = model('member');

        $member = $memberModel->getMemberInfoByID($member['member_id']);
        $bind = $this->OrderFind($member);
        if ($bind['code']==200) {
            $this->OrderBind($member,$bind,$student);
            exit;
        }else{

        }
        exit;
    }

    /**
     * 查询此账号是否存在线下订单
     * @Author 老王
     * @创建时间   2019-07-03
     * @param  [type]     $memberInfo [description]
     */
    public function OrderFind($memberInfo){
        $return = ['code'=>100];
        $return = ['msg'=>'->'];
        //查看是否存在线下订单
        $OffilneCache = model('offlinecache');
        $orderCache = $OffilneCache->getOneOfflineCacheByCard(['member_phone'=>$memberInfo['member_mobile']]);
        if (!$orderCache) $return['msg'].=' 线下订单不存在或已完成绑定！';
        //查看订单状态
        $OffilneOrder = model('offlineorder');
        $order = $OffilneOrder->getOneOfflineOrdersByCard(['id'=>$orderCache['import_id']]);
        if ($order) {
            //1未审核，2审核成功，3审核失败
            switch ($order['status']) {
                case 1:
                    $return['msg'].=' 线下订单正在审核中！';
                    break;
                case 2:
                    $return['code']=200;
                    $return['order']=$order;
                    $return['cache']=$orderCache;
                    break;
                case 3:
                    $return['msg'].=' 线下订单审核失败！';
                    break;
            }
        }
        return $return;
    }
/**(
cache
    [id] => 64
    [member_phone] => 18514070310
    [member_name] => 老王
    [member_card] => 110105196812272168
    [member_sex] => 1
    [member_age] => 31
    [member_relation] => 父亲
    [member_address] => 北京市朝阳区高碑店乡北花园村南工业区3-1号
    [member_email] => xxx@qq.com
    [pkg_name] => 看孩月套餐
    [pkg_price] => 30.00
    [order_desc] => 无
    [addtime] => 1561544470
    [import_id] => 54
)
*/
    public function OrderBind($member,$order,$child){
        $cache = $order['cache'];
        $order = $order['order'];
        $ChildModel = model('student');
        $student = $ChildModel->getChildrenInfoById($child);

        //获取套餐信息
        $Pkgs=model('Pkgs');
        $packageInfo = $Pkgs->getOnePkg(array('pkg_name'=>$cache['pkg_name'],'pkg_enabled'=>1));
        if ($packageInfo) {
            unset($packageInfo['pkg_sort']);
            unset($packageInfo['pkg_enabled']);
        }else{
            //没有此套餐的信息！
            output_error('没有此套餐的信息！');
        }


        p($member);
        p($cache);
        p($student);
exit;
        $LogicBuy = \model('buy_1','logic');
        $pay_sn = $LogicBuy->makePaySn($member['member_id']);
        $order = array();
        //生成基本订单信息
        $order['pay_sn'] = $pay_sn;
        $order['buyer_id'] = $member['member_id'];
        $order['buyer_name'] = $member['member_name'];
        $order['buyer_mobile'] = $member['member_mobile'];
        $order['add_time'] = TIMESTAMP;
        $order['payment_code'] = 'offline';
        $order['order_from'] = $member['client_type'];
        $order['order_state'] = ORDER_STATE_NEW;
        //加入套餐信息
        if(is_array($packageInfo))$order +=$packageInfo;
        unset($order['up_time']);
        $Children = model('Student');
        $childinfo=$Children->getChildrenInfoById($student['s_id']);
        if (!$childinfo) {
            output_error('没有当前孩子信息！');
        }
        $Relation = $Children->checkParentRelation($member['member_id'],$student['s_id']);
        if($Relation=='false')output_error('您不是此孩子的家长，不能购买当前套餐！');
        //加入学生学校班级信息
        if(is_array($childinfo))$order += $childinfo;
        $order['order_amount'] = $packageInfo['pkg_price'];
        try {
            $model = Model('Packagesorder');
            $model->startTrans();
            //写入订单表
            $order_pay_id = $model->addOrder($order);
            $order['order_id'] = $order_pay_id;
            $model->commit();

        } catch (Exception $e) {
            $model->rollback();
        }
        $order['order_sn'] = $LogicBuy->makeOrderSn($order_pay_id);
        //写入平台流水号
        $model->editOrder(array('order_sn'=>$order['order_sn']), array('order_id'=>$order_pay_id));


        p($student);

        exit;
    }



}