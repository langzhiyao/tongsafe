<?php

/**
 * 系统文章
 */

namespace app\home\controller;

use think\Lang;

class Document extends BaseMall {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/zh-cn/index.lang.php');
    }

    public function index() {
        $code = input('param.code');
        
        if ($code == '') {
            $this->error(lang('para_error'));//'缺少参数:文章标识'
        }
        $model_doc = Model('document');
        $doc = $model_doc->getOneByCode($code);
        $this->assign('doc', $doc);
        /**
         * 分类导航
         */
        $nav_link = array(
            array(
                'title' => $lang['homepage'],
                'link' => SHOP_SITE_URL
            ),
            array(
                'title' => $doc['doc_title']
            )
        );
        $this->assign('nav_link_list', $nav_link);
        return $this->fetch($this->template_dir . 'index');
    }

}

?>
