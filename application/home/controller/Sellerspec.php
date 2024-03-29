<?php

/*
 * 店铺规格值
 * 每个店铺都有对应分类下保存的规格值
 */

namespace app\home\controller;

use think\Lang;

class Sellerspec extends BaseSeller
{

    var $_store_id;

    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'mobile/lang/zh-cn/sellerspec.lang.php');
        $this->_store_id = session('store_id');
    }

    /**
     * 选择分类
     */
    public function index()
    {
        // 获取商品分类
        $model_goodsclass = Model('goodsclass');
        $gc_list = $model_goodsclass->getGoodsClass($this->_store_id);
        $this->assign('gc_list', $gc_list);
        $this->setSellerCurItem('spec');
        $this->setSellerCurMenu('sellerspec');
        return $this->fetch($this->template_dir.'index');
    }

    /**
     * 添加规格值
     */
    public function add_spec()
    {
        $sp_id = intval(input('param.spid'));
        $gc_id = intval(input('param.gcid'));
        // 验证参数
        if ($sp_id <= 0) {
            $this->error(lang('wrong_argument'));
        }
        // 分类信息
        $gc_info = Model('goodsclass')->getGoodsClassInfoById($gc_id);
        $this->assign('gc_info', $gc_info);
        // 规格信息
        $model_spec = Model('spec');
        $sp_info = $model_spec->getSpecInfo($sp_id, 'sp_id,sp_name');
        //halt($sp_info);
        $this->assign('sp_info', $sp_info);
        // 规格值信息
        $sp_value_list = $model_spec->getSpecValueList(array(
                                                           'store_id' => $this->_store_id, 'sp_id' => $sp_id,
                                                           'gc_id' => $gc_id
                                                       ));
        $this->assign('sp_value_list', $sp_value_list);

        return $this->fetch($this->template_dir.'spec_add');
    }

    /**
     * 保存规格值
     */
    public function save_spec()
    {
        $sp_id = intval($_POST['sp_id']);
        $gc_id = intval($_POST['gc_id']);
        if ($sp_id <= 0 || $gc_id <= 0 ) {
            showDialog(lang('wrong_argument'));
        }

        $model_spec = Model('spec');
        // 更新原规格值
        if (isset($_POST['sv']['old'])&&is_array($_POST['sv']['old'])) {
            foreach ($_POST['sv']['old'] as $key => $value) {
                if (empty($value['name'])) {
                    continue;
                }
                $where = array('sp_value_id' => $key);
                $update = array(
                    'sp_value_name' => $value['name'], 'sp_id' => $sp_id, 'gc_id' => $gc_id,
                    'store_id' => $this->_store_id, 'sp_value_color' => isset($value['color'])?$value['color']:'',
                    'sp_value_sort' => intval($value['sort'])
                );
                $model_spec->editSpecValue($update, $where);
            }
        }

        // 添加新规格值
        if (isset($_POST['sv']['new'])&&is_array($_POST['sv']['new'])) {
            $insert_array = array();
            foreach ($_POST['sv']['new'] as $value) {
                if (empty($value['name'])) {
                    continue;
                }
                $tmp_insert = array(
                    'sp_value_name' => $value['name'], 'sp_id' => $sp_id, 'gc_id' => $gc_id,
                    'store_id' => $this->_store_id, 'sp_value_color' => $value['color'],
                    'sp_value_sort' => intval($value['sort'])
                );
                $insert_array[] = $tmp_insert;
            }
            $model_spec->addSpecValueALL($insert_array);
        }

        showDialog(lang('ds_common_op_succ'), 'reload', 'succ');
    }

    /**
     * ajax删除规格值
     */
    public function ajax_delspec()
    {
        $sp_value_id = intval(input('param.id'));
        if ($sp_value_id <= 0) {
            echo 'false';
            exit();
        }
        $rs = Model('spec')->delSpecValue(array('sp_value_id' => $sp_value_id, 'store_id' => $this->_store_id));
        if ($rs) {
            echo 'true';
            exit();
        }
        else {
            echo 'false';
            exit();
        }
    }

    /**
     * AJAX获取商品分类
     */
    public function ajax_class()
    {
        $id = intval(input('param.id'));
        $deep = intval(input('param.deep'));
        if ($id <= 0 || $deep <= 0 || $deep >= 4) {
            echo 'false';
            exit();
        }
        $deep += 1;
        $model_goodsclass = Model('goodsclass');

        // 验证分类是否存在
        $gc_info = $model_goodsclass->getGoodsClassInfoById($id);
        if (empty($gc_info)) {
            echo 'false';
            exit();
        }

        // 读取商品分类
        if ($deep != 4) {
            $gc_list = $model_goodsclass->getGoodsClass($this->_store_id, $id, $deep);
        }
        // 分类不为空输出分类信息
        if (!empty($gc_list)) {
            $data = array('type' => 'class', 'data' => $gc_list, 'deep' => $deep);
        }
        else {
            // 查询类型
            $model_type = Model('type');
            $spec_list = $model_type->getSpecByType(array('type_id' => $gc_info['type_id']), 't.type_id, s.*');

            $data = array('type' => 'spec', 'data' => $spec_list, 'gcid' => $id, 'deep' => $deep);
        }
        echo json_encode($data);
        exit();
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string $menu_type 导航类型
     * @param string $menu_key 当前导航的menu_key
     * @return
     */
    protected function getSellerItemList()
    {
        $menu_array = array(
            array('name' => 'spec', 'text' => '编辑商品规格', 'url' => 'index')
        );
        return $menu_array;
    }
}

?>
