<?php

namespace app\home\controller;
use think\Lang;
class BaseStoreSns extends BaseHome {

    const MAX_RECORDNUM = 20; // 允许插入新记录的最大次数，sns页面该常量是一样的。

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/zh-cn/baseseller.lang.php');
        $this->template_dir = 'store/default/' . strtolower(request()->controller()) . '/';
        $this->assign('store_theme','default');
        
        $this->assign('max_recordnum', self::MAX_RECORDNUM);

        // 自定义导航条
        $this->getStoreNavigation();

        //查询会员信息
        $this->getMemberAndGradeInfo(false);
    }

    // 自定义导航条
    protected function getStoreNavigation() {
        $model_store_navigation = Model('storenavigation');
        $store_navigation_list = $model_store_navigation->getStoreNavigationList(array('sn_store_id' => intval(input('param.sid'))));
        $this->assign('store_navigation_list', $store_navigation_list);
    }

    protected function getStoreInfo($store_id) {
        //得到店铺等级信息
        $store_info = Model('store')->getStoreInfoByID($store_id);
        if (empty($store_info)) {
            $this->error(lang('store_sns_store_not_exists'));
        }
        //处理地区信息
        $area_array = array();
        $area_array = explode("\t", $store_info["area_info"]);
        $map_city = lang('store_sns_city');
        $city = '';
        if (strpos($area_array[0], $map_city) !== false) {
            $city = $area_array[0];
        } else {
            $city = isset($area_array[1])?$area_array[1]:'';
        }
        $store_info['city'] = $city;

        $this->assign('store_theme', $store_info['store_theme']);
        $this->assign('store_info', $store_info);
    }

}

?>
