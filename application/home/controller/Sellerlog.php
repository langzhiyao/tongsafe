<?php


namespace app\home\controller;


class Sellerlog extends BaseSeller
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
    }

    public function log_list()
    {
        $model_seller_log = Model('sellerlog');
        $condition = array();
        $condition['log_store_id'] = session('store_id');
        $seller_name = input('seller_name');
        $log_content = input('log_content');
        $add_time_from = input('add_time_from');
        $add_time_to = input('add_time_to');
        if (!empty($seller_name)) {
            $condition['log_seller_name'] = array(
                'like',
                '%' . input('seller_name') . '%'
            );
        }
        if (!empty($log_content)) {
            $condition['log_content'] = array(
                'like',
                '%' . $log_content . '%'
            );
        }
        if(!empty($add_time_from)||$add_time_to){
        $condition['log_time'] = array(
            [
                '>',
                strtotime($add_time_from)
            ],
            [
                '<',
                strtotime($add_time_to)
            ]

        );
        }
        $log_list = $model_seller_log->getSellerLogList($condition, 10, 'log_id desc');
        $this->assign('log_list', $log_list);
         $this->assign('show_page', $model_seller_log->page_info->render());

        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('sellerlog');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem('log_list');
        return $this->fetch($this->template_dir.'seller_log');
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string $menu_key 当前导航
     * @return
     */
    public function getSellerItemList()
    {
        $menu_array = array();
        $menu_array[] = array(
            'name' => 'log_list',
            'text' => '日志列表',
            'url' => url('Sellerlog/log_list')
        );
        return $menu_array;
    }
}