<?php

/**
 * 积分
 */

namespace app\common\model;

use think\Model;

class Points extends Model {

    public $page_info;

    /**
     * 操作积分
     * @param  string $stage 操作阶段 regist(注册),login(登录),comments(评论),order(下单),system(系统),other(其他),pointorder(积分礼品兑换),app(同步积分兑换)
     * @param  array $insertarr 该数组可能包含信息 array('pl_memberid'=>'会员编号','pl_membername'=>'会员名称','pl_adminid'=>'管理员编号','pl_adminname'=>'管理员名称','pl_points'=>'积分','pl_desc'=>'描述','orderprice'=>'订单金额','order_sn'=>'订单编号','order_id'=>'订单序号','point_ordersn'=>'积分兑换订单编号');
     * @param  bool $if_repeat 是否可以重复记录的信息,true可以重复记录，false不可以重复记录，默认为true
     * @return bool
     */
    function savePointsLog($stage, $insertarr, $if_repeat = true) {
        if (!$insertarr['pl_memberid']) {
            return false;
        }

        //记录原因文字
        switch ($stage) {
            case 'regist':
                if (!isset($insertarr['pl_desc'])) {
                    $insertarr['pl_desc'] = '注册会员';
                }
                $insertarr['pl_points'] = intval(config('points_reg'));
                break;
            case 'login':
                if (!isset($insertarr['pl_desc'])) {
                    $insertarr['pl_desc'] = '会员登录';
                }
                $insertarr['pl_points'] = intval(config('points_login'));
                break;
            case 'comments':
                if (!isset($insertarr['pl_desc'])) {
                    $insertarr['pl_desc'] = '评论商品';
                }
                $insertarr['pl_points'] = intval(config('points_comments'));
                break;
            case 'order':
                if (!isset($insertarr['pl_desc'])) {
                    $insertarr['pl_desc'] = '订单' . $insertarr['order_sn'] . '购物消费';
                }
                $insertarr['pl_points'] = 0;
                if ($insertarr['orderprice']) {
                    $insertarr['pl_points'] = @intval($insertarr['orderprice'] / config('points_orderrate'));
                    if ($insertarr['pl_points'] > intval(config('points_ordermax'))) {
                        $insertarr['pl_points'] = intval(config('points_ordermax'));
                    }
                }
                //订单添加赠送积分列
                $obj_order = Model('order');
                $data = array();
                $data['order_pointscount'] = array('exp', 'order_pointscount+' . $insertarr['pl_points']);
                $obj_order->editOrderCommon($data, array('order_id' => $insertarr['order_id']));
                break;
            case 'system':
                break;
            case 'pointorder':
                if (!isset($insertarr['pl_desc'])) {
                    $insertarr['pl_desc'] = '兑换礼品信息' . $insertarr['point_ordersn'] . '消耗积分';
                }
                break;
            case 'app':
                if (!isset($insertarr['pl_desc'])) {
                    $insertarr['pl_desc'] = lang('points_pointorderdesc_app');
                }
                //邀请积分返利 33 hao.co m v3
                break;
            case 'signin':
                if (!isset($insertarr['pl_desc'])) {
                    $insertarr['pl_desc'] = '签到得到积分';
                }
                break;
            case 'inviter':
                if (!isset($insertarr['pl_desc'])) {
                    $insertarr['pl_desc'] = '邀请新会员[' . $insertarr['invited'] . ']注册';
                }
                $insertarr['pl_points'] = intval(config('points_invite'));
                break;
            case 'rebate':
                if (!isset($insertarr['pl_desc'])) {
                    $insertarr['pl_desc'] = '被邀请人[' . session('member_name') . ']消费';
                }
                //$insertarr['pl_points'] = $insertarr['rebate_amount'];
                break;
            case 'other':
                break;
        }
        $save_sign = true;
        if ($if_repeat == false) {
            //检测是否有相关信息存在，如果没有，入库
            $condition['pl_memberid'] = $insertarr['pl_memberid'];
            $condition['pl_stage'] = $stage;
            $log_array = self::getPointsInfo($condition);
            if (!empty($log_array)) {
                $save_sign = false;
            }
        }
        if ($save_sign == false) {
            return true;
        }
        //新增日志
        $value_array = array();
        $value_array['pl_memberid'] = $insertarr['pl_memberid'];
        $value_array['pl_membername'] = $insertarr['pl_membername'];
        if (isset($insertarr['pl_adminid'])) {
            $value_array['pl_adminid'] = $insertarr['pl_adminid'];
        }
        if (isset($insertarr['pl_adminname'])) {
            $value_array['pl_adminname'] = $insertarr['pl_adminname'];
        }
        $value_array['pl_points'] = $insertarr['pl_points'];
        $value_array['pl_addtime'] = time();
        $value_array['pl_desc'] = $insertarr['pl_desc'];
        $value_array['pl_stage'] = $stage;
        $result = false;
        if ($value_array['pl_points'] != '0') {
            $result = self::addPointsLog($value_array);
        }
        if ($result) {
            //更新member内容
            $obj_member = Model('member');
            $upmember_array = array();
            $upmember_array['member_points'] = array('exp', 'member_points+' . $insertarr['pl_points']);
            $obj_member->editMember(array('member_id' => $insertarr['pl_memberid']), $upmember_array);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 添加积分日志信息
     * @param array $param 添加信息数组
     */
    public function addPointsLog($param) {
        if (empty($param)) {
            return false;
        }
        $result = db('pointslog')->insert($param);
        return $result;
    }

    /**
     * 积分日志列表
     *
     * @param array $condition 条件数组
     * @param array $page   分页
     * @param array $field   查询字段
     * @param array $page   分页
     */
    public function getPointsLogList($condition, $page = '', $field = '*') {
        $order = isset($condition['order']) ? $condition['order'] : 'pl_id desc';
        if ($page) {
            $result = db('pointslog')->where($condition)->field($field)->order($order)->paginate($page,false,['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        } else {
            return db('pointslog')->where($condition)->field($field)->order($order)->select();
        }
    }

    /**
     * 积分日志详细信息
     *
     * @param array $condition 条件数组
     * @param array $field   查询字段
     */
    public function getPointsInfo($condition, $field = '*') {
        //得到条件语句
        return db('pointslog')->field($field)->where($condition)->find();
    }

    /**
     * 将条件数组组合为SQL语句的条件部分
     *
     * @param	array $condition_array
     * @return	string
     */
    private function getCondition($condition_array) {
        $condition_sql = '1=1';
        //积分日志会员编号
        if ($condition_array['pl_memberid']) {
            $condition_sql .= " and pl_memberid = '{$condition_array['pl_memberid']}'";
        }
        //操作阶段
        if (isset($condition_array['pl_stage'])) {
            $condition_sql .= " and pl_stage = '{$condition_array['pl_stage']}'";
        }
        //会员名称
        if (isset($condition_array['pl_membername_like'])) {
            $condition_sql .= " and pl_membername like '%{$condition_array['pl_membername_like']}%'";
        }
        //管理员名称
        if (isset($condition_array['pl_adminname_like'])) {
            $condition_sql .= " and pl_adminname like '%{$condition_array['pl_adminname_like']}%'";
        }
        //添加时间
        if (!empty($condition_array['saddtime'])) {
            $condition_sql .= " and pl_addtime >= '{$condition_array['saddtime']}'";
        }
        if (!empty($condition_array['eaddtime'])) {
            $condition_sql .= " and pl_addtime <= '{$condition_array['eaddtime']}'";
        }
        //描述
        if (isset($condition_array['pl_desc_like'])) {
            $condition_sql .= " and pl_desc like '%{$condition_array['pl_desc_like']}%'";
        }
        return $condition_sql;
    }

}
