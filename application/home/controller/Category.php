<?php

namespace app\home\controller;

use think\Lang;
use think\Validate;

class Category extends BaseMall {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/zh-cn/category.lang.php');
    }

    /*
     * 显示商品分类列表
     */

    public function goods() {
        //获取全部的商品分类
        //导航
        $nav_link = array(
            '0' => array('title' => lang('homepage'), 'link' => config('url_domain_root')),
            '1' => array('title' => lang('category_index_goods_class'))
        );
        $this->assign('nav_link_list', $nav_link);

        $this->assign('html_title', config('site_name') . ' - ' . lang('category_index_goods_class'));
        return $this->fetch($this->template_dir . 'goods_category');
    }

    /*
     * 显示店铺分类列表
     */

    public function store() {
        $sc_list = db('storeclass')->order('sc_sort asc,sc_id asc')->select();
        $this->assign('sc_list', $sc_list);
        return $this->fetch($this->template_dir . 'store_category');
    }

}
