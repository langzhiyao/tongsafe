<?php

namespace app\home\controller;

use think\Lang;

class Link extends BaseMall {

    public function _initialize() {
        parent::_initialize(); // TODO: Change the autogenerated stub
        Lang::load(APP_PATH . 'mobile/lang/zh-cn/article.lang.php');
    }

    public function index() {
        //把加密的用户id写入cookie
        $uid = input('uid');
        cookie('uid', $uid);

        //友情连接内容
        $model_link = Model('link');
        $link_list = $model_link->getLinkList();
        /**
         * 整理图片链接
         */
        if (is_array($link_list)) {
            foreach ($link_list as $k => $v) {
                if (!empty($v['link_pic'])) {
                    $link_list[$k]['link_pic'] = UPLOAD_SITE_URL . '/' . DIR_ADMIN . '/link' . '/' . $v['link_pic'];
                }
            }
        }
       $this->assign('link_list', $link_list);
        $this->assign('link', 'index');
        return $this->fetch($this->template_dir.'link');
    }

    //json输出商品分类
    public function josn_class() {
        /**
         * 实例化商品分类模型
         */
        $model_class = Model('goods_class');
        $goods_class = $model_class->getGoodsClassListByParentId(intval($_GET['gc_id']));
        $array = array();
        if (is_array($goods_class) and count($goods_class) > 0) {
            foreach ($goods_class as $val) {
                $array[$val['gc_id']] = array('gc_id' => $val['gc_id'], 'gc_name' => htmlspecialchars($val['gc_name']), 'gc_parent_id' => $val['gc_parent_id'], 'commis_rate' => $val['commis_rate'], 'gc_sort' => $val['gc_sort']);
            }
        }

            $array = array_values($array);
        echo $_GET['callback'] . '(' . json_encode($array) . ')';
    }

    /**
     * json输出地址数组 原data/resource/js/area_array.js
     */
    public function json_area() {
        echo $_GET['callback'] . '(' . json_encode(Model('area')->getAreaArrayForJson()) . ')';
    }

    /**
     * json输出地址数组 v3-b12
     */
    public function json_area_show() {
        echo $_GET['callback'] . '(' . json_encode(Model('area')->getAreaArrayForJson()) . ')';
    }

    //判断是否登录
    public function login() {
        echo (session('is_login') == '1') ? '1' : '0';
    }

    /**
     * 头部最近浏览的商品
     */
    public function viewed_info() {
        $info = array();
        if (session('is_login') == '1') {
            $member_id = session('member_id');
            $info['m_id'] = $member_id;
            if (config('voucher_allow') == 1) {
                $time_to = time(); //当前日期
                $info['voucher'] = Model()->table('voucher')->where(array('voucher_owner_id' => $member_id, 'voucher_state' => 1,
                            'voucher_start_date' => array('elt', $time_to), 'voucher_end_date' => array('egt', $time_to)))->count();
            }
            $time_to = strtotime(date('Y-m-d')); //当前日期
            $time_from = date('Y-m-d', ($time_to - 60 * 60 * 24 * 7)); //7天前
            $info['consult'] = Model('consult')->where(array('member_id' => $member_id,
                        'consult_reply_time' => array(array('gt', strtotime($time_from)), array('lt', $time_to + 60 * 60 * 24), 'and')))->count();
        }
        $goods_list = Model('goodsbrowse')->getViewedGoodsList(session('member_id'), 5);
        if (is_array($goods_list) && !empty($goods_list)) {
            $viewed_goods = array();
            foreach ($goods_list as $key => $val) {
                $goods_id = $val['goods_id'];
                $val['url'] = url('goods/index', array('goods_id' => $goods_id));
                $val['goods_image'] = thumb($val, 60);
                $viewed_goods[$goods_id] = $val;
            }
            $info['viewed_goods'] = $viewed_goods;
        }
        echo json_encode($info);
    }

    /**
     * 查询每月的周数组
     */
    public function getweekofmonth() {
        import('function.datehelper');
        $year = $_GET['y'];
        $month = $_GET['m'];
        $week_arr = getMonthWeekArr($year, $month);
        echo json_encode($week_arr);
        die;
    }

}

?>
