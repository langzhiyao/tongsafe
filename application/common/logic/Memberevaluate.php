<?php

namespace app\common\logic;


use think\Model;

class Memberevaluate extends Model
{
    public function evaluateListDity($goods_eval_list)
    {
        foreach ($goods_eval_list as $key => $value) {
            $goods_eval_list[$key]['member_avatar'] = getMemberAvatarForID($value['geval_frommemberid']);
        }
        return $goods_eval_list;
    }

    /*查询订单信息*/
    public function validation($order_id, $member_id)
    {
        $condition['order_id'] = $order_id;
        $condition['buyer_id'] = $member_id;
        //获取订单信息
        $order_info = \model('order')->getOrderInfo(array('order_id' => $order_id));

        //获取订单商品
        $order_goods = \model('order')->getOrderGoodsList($condition);
        if(empty($order_goods)){
            $info=array('state'=>'0','msg'=>'订单出错');
        }
        foreach ($order_goods as $key=>$value){
            $order_goods[$key]['goods_image_url']=cthumb($value['goods_image']);
        }
        //查询店铺信息
        $store_info = \model('store')->getStoreInfoByID($order_goods[0]['store_id']);

        $info['data']=array('order_goods'=>$order_goods,'store_info'=>$store_info,'order_info'=>$order_info);
        return $info;
    }

    /*保存订单评价信息*/
    public function saveorderevaluate($post,$order_info,$store_info,$order_goods,$member_id,$member_name)
    {
        $evaluate_goods_array = array();
        $goodsid_array = array();
        //halt($order_goods);
        foreach ($order_goods as $value){
            //如果未评分，默认为5分
            $evaluate_score = intval($post['goods'][$value['rec_id']]['score']);
            if($evaluate_score <= 0 || $evaluate_score > 5) {
                $evaluate_score = 5;
            }
            //默认评语
            $evaluate_comment = $post['goods'][$value['rec_id']]['comment'];
            if(empty($evaluate_comment)) {
                $evaluate_comment = '不错哦';
            }

            $evaluate_goods_info = array();
            $evaluate_goods_info['geval_orderid'] = $order_info['order_id'];
            $evaluate_goods_info['geval_orderno'] = $order_info['order_sn'];
            $evaluate_goods_info['geval_ordergoodsid'] = $value['rec_id'];
            $evaluate_goods_info['geval_goodsid'] = $value['goods_id'];
            $evaluate_goods_info['geval_goodsname'] = $value['goods_name'];
            $evaluate_goods_info['geval_goodsprice'] = $value['goods_price'];
            $evaluate_goods_info['geval_goodsimage'] = $value['goods_image'];
            $evaluate_goods_info['geval_scores'] = $evaluate_score;
            $evaluate_goods_info['geval_content'] = $evaluate_comment;
            $evaluate_goods_info['geval_isanonymous'] = isset($post['goods'][$value['rec_id']]['anony'])?1:0;
            $evaluate_goods_info['geval_addtime'] = TIMESTAMP;
            $evaluate_goods_info['geval_storeid'] = $store_info['store_id'];
            $evaluate_goods_info['geval_storename'] = $store_info['store_name'];
            $evaluate_goods_info['geval_frommemberid'] = $member_id;
            $evaluate_goods_info['geval_frommembername'] = $member_name;

            $evaluate_goods_array[] = $evaluate_goods_info;

            $goodsid_array[] = $value['goods_id'];
        }
        model('evaluategoods')->addEvaluateGoodsArray($evaluate_goods_array, $goodsid_array);

        $store_desccredit = intval($post['store_desccredit']);
        if($store_desccredit <= 0 || $store_desccredit > 5) {
            $store_desccredit= 5;
        }
        $store_servicecredit = intval($post['store_servicecredit']);
        if($store_servicecredit <= 0 || $store_servicecredit > 5) {
            $store_servicecredit = 5;
        }
        $store_deliverycredit = intval($post['store_deliverycredit']);
        if($store_deliverycredit <= 0 || $store_deliverycredit > 5) {
            $store_deliverycredit = 5;
        }
        //             //添加店铺评价
        if (!$store_info['is_own_shop']) {
            $evaluate_store_info = array();
            $evaluate_store_info['seval_orderid'] = $order_info['order_id'];
            $evaluate_store_info['seval_orderno'] = $order_info['order_sn'];
            $evaluate_store_info['seval_addtime'] = time();
            $evaluate_store_info['seval_storeid'] = $store_info['store_id'];
            $evaluate_store_info['seval_storename'] = $store_info['store_name'];
            $evaluate_store_info['seval_memberid'] = $member_id;
            $evaluate_store_info['seval_membername'] = $member_name;
            $evaluate_store_info['seval_desccredit'] = $store_desccredit;
            $evaluate_store_info['seval_servicecredit'] = $store_servicecredit;
            $evaluate_store_info['seval_deliverycredit'] = $store_deliverycredit;
        }
        model('evaluatestore')->addEvaluateStore($evaluate_store_info);

        //更新订单信息并记录订单日志
        $state =model('order')->editOrder(array('evaluation_state'=>1), array('order_id' => $order_info['order_id']));
        model('order')->editOrderCommon(array('evaluation_time'=>TIMESTAMP), array('order_id' => $order_info['order_id']));
        if ($state){
            $data = array();
            $data['order_id'] = $order_info['order_id'];
            $data['log_role'] = 'buyer';
            $data['log_msg'] = lang('order_log_eval');
            model('order')->addOrderLog($data);
            $res=array('msg'=>lang('order_log_eval'),'state'=>'1');
        }else{
            $res=array('msg'=>'订单评价出错','state'=>'0');
        }

        //添加会员积分
        if (config('points_isuse') == 1){
            $points_model = model('points');
            $points_model->savePointsLog('comments',array('pl_memberid'=>$member_id,'pl_membername'=>$member_name));
        }
        //添加会员经验值
        model('exppoints')->saveExppointsLog('comments',array('exp_memberid'=>$member_id,'exp_membername'=>$member_name));;
        return $res;
    }
    public function validationVr($order_id, $member_id)
    {
        $condition['order_id'] = $order_id;
        $condition['buyer_id'] = $member_id;
        //获取订单信息
        $order_info = \model('vrorder')->getOrderInfo(array('order_id' => $order_id));
        //查询店铺信息
        $store_info = \model('store')->getStoreInfoByID($order_id);
        $order_info['goods_image_url']=cthumb($order_info['goods_image']);
        if(!$order_info){
            $info=array(
                'state'=>'0','msg'=>'没有权限'
            );
        }
        $info['data']=array('order_info'=>$order_info,'store_info'=>$store_info);
        return $info;
    }
    public function saveVr(){
        $order_id = intval(input('param.order_id'));
        $model_order = Model('vrorder');
        $model_store = Model('store');
        $model_evaluate_goods = Model('evaluategoods');
        $model_evaluate_store = Model('evaluatestore');
        //获取订单信息
        $order_info = $model_order->getOrderInfo(array('order_id' => $order_id));
        //判断订单身份
        if($order_info['buyer_id'] !=session('member_id')) {
            output_error(lang('wrong_argument'));
        }
        //订单为'已收货'状态，并且未评论
        $order_info['evaluate_able'] = $model_order->getOrderOperateState('evaluation',$order_info);
        if (!$order_info['evaluate_able']){
            output_error(lang('member_evaluation_order_notexists'));
        }

        //查询店铺信息
        $store_info = $model_store->getStoreInfoByID($order_info['store_id']);
        if(empty($store_info)){
            output_error(lang('member_evaluation_store_notexists'));
        }
        $order_goods = array($order_info);
        $evaluate_goods_array = array();
        $goodsid_array = array();
        foreach ($order_goods as $value){
            //如果未评分，默认为5分
            $evaluate_score = intval($_POST['goods'][$value['goods_id']]['score']);
            if($evaluate_score <= 0 || $evaluate_score > 5) {
                $evaluate_score = 5;
            }
            //默认评语
            $evaluate_comment = $_POST['goods'][$value['goods_id']]['comment'];
            if(empty($evaluate_comment)) {
                $evaluate_comment = '不错哦';
            }

            $evaluate_goods_info = array();
            $evaluate_goods_info['geval_orderid'] = $order_id;
            $evaluate_goods_info['geval_orderno'] = $order_info['order_sn'];
            $evaluate_goods_info['geval_ordergoodsid'] = $order_id;
            $evaluate_goods_info['geval_goodsid'] = $value['goods_id'];
            $evaluate_goods_info['geval_goodsname'] = $value['goods_name'];
            $evaluate_goods_info['geval_goodsprice'] = $value['goods_price'];
            $evaluate_goods_info['geval_goodsimage'] = $value['goods_image'];
            $evaluate_goods_info['geval_scores'] = $evaluate_score;
            $evaluate_goods_info['geval_content'] = $evaluate_comment;
            $evaluate_goods_info['geval_isanonymous'] = $_POST['anony']?1:0;
            $evaluate_goods_info['geval_addtime'] = TIMESTAMP;
            $evaluate_goods_info['geval_storeid'] = $store_info['store_id'];
            $evaluate_goods_info['geval_storename'] = $store_info['store_name'];
            $evaluate_goods_info['geval_frommemberid'] = session('member_id');
            $evaluate_goods_info['geval_frommembername'] = session('member_name');

            $evaluate_goods_array[] = $evaluate_goods_info;

            $goodsid_array[] = $value['goods_id'];
        }
        $model_evaluate_goods->addEvaluateGoodsArray($evaluate_goods_array, $goodsid_array);

        //更新订单信息并记录订单日志
        $state = $model_order->editOrder(array('evaluation_state'=>1,'evaluation_time'=>TIMESTAMP), array('order_id' => $order_id));

        //添加会员积分
        if (config('points_isuse') == 1){
            $points_model = Model('points');
            $points_model->savePointsLog('comments',array('pl_memberid'=>session('member_id'),'pl_membername'=>session('member_name')));
        }
        //添加会员经验值
        Model('exppoints')->saveExppointsLog('comments',array('exp_memberid'=>session('member_id'),'exp_membername'=>session('member_name')));;

        output_data(1);
    }
}