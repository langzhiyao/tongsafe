<?php

namespace app\home\controller;


use think\Lang;
use think\Validate;

class Sellerbrand extends BaseSeller
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        Lang::load(APP_PATH.'mobile/lang/zh-cn/sellerbrand.lang.php');

    }

    /**
     * 品牌列表
     */
    public function index()
    {
        $model_brand = Model('brand');
        $condition = array();
        $condition['store_id'] = session('store_id');
        if (!empty(input('param.brand_name'))) {
            $condition['brand_name'] = array('like', '%' . input('param.brand_name') . '%');
        }

        $brand_list = $model_brand->getBrandList($condition, '*', 10);
        $this->assign('brand_list', $brand_list);
        $this->assign('show_page', $model_brand->page_info->render());

        $this->setSellerCurMenu('seller_brand');
        $this->setSellerCurItem('brand_list');
        return $this->fetch($this->template_dir.'index');
    }

    /**
     * 品牌添加页面
     */
    public function brand_add()
    {
        $model_brand = Model('brand');
        if (input('param.brand_id') != '') {
            $brand_array = $model_brand->getBrandInfo(array(
                                                          'brand_id' => input('param.brand_id'),
                                                          'store_id' => session('store_id')
                                                      ));
            if (empty($brand_array)) {
                $this->error(lang('wrong_argument'));
            }
            $this->assign('brand_array', $brand_array);
        }

        // 一级商品分类
        $gc_list = Model('goodsclass')->getGoodsClassListByParentId(0);
        $this->assign('gc_list', $gc_list);

        echo $this->fetch($this->template_dir.'add');
    }

    /**
     * 品牌保存
     */
    public function brand_save()
    {

        $model_brand = Model('brand');
        if (request()->isPost()) {
            /**
             * 验证
             */
            $obj_validate = new Validate();
            $date=[
                'brand_name'=>$_POST["brand_name"],
                'brand_initial'=>$_POST["brand_initial"],
            ];
            $rule=[
                ['brand_name','require',lang('store_goods_brand_name_null')],
                ['brand_initial','require','请填写首字母']
            ];

            $error = $obj_validate->check($date,$rule);
            if (!$error) {
                showDialog($obj_validate->getError());
            }

            /**
             * 上传图片
             */
            if (!empty($_FILES['brand_pic']['name'])) {
                $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_BRAND ;
                $file_name = session('store_id') . '_' . date('YmdHis') . rand(10000, 99999);
                $file_object = request()->file('brand_pic');
                $info = $file_object->rule('uniqid')->validate(['ext' => 'jpg,png,gif'])->move($upload_file,$file_name);
                if ($info) {
                    $_POST['brand_pic'] = $info->getFilename();
                } else {
                        showDialog($file_object->getError());
                    }
                }
            $insert_array = array();
            $insert_array['brand_name'] = trim($_POST['brand_name']);
            $insert_array['brand_initial'] = strtoupper($_POST['brand_initial']);
            $insert_array['gc_id'] = $_POST['class_id'];
            $insert_array['brand_class'] = $_POST['brand_class'];
            $insert_array['brand_pic'] = $_POST['brand_pic'];
            $insert_array['brand_apply'] = 0;
            $insert_array['store_id'] = session('store_id');

            $result = $model_brand->addBrand($insert_array);
            if ($result) {
                showDialog(lang('store_goods_brand_apply_success'), url('sellerbrand/index'), 'succ', empty(input('param.inajax')) ? '' : 'CUR_DIALOG.close();');
            }
            else {
                showDialog(lang('ds_common_save_fail'));
            }
        }
    }

    /**
     * 品牌修改
     */
    public function brand_edit()
    {
        $model_brand = Model('brand');
        if ($_POST['form_submit'] == 'ok' and intval($_POST['brand_id']) != 0) {
            /**
             * 验证
             */
            $obj_validate = new Validate();
            $date=[
                'brand_name'=>$_POST["brand_name"],
                'brand_initial'=>$_POST["brand_initial"],
            ];
            $rule=[
                ['brand_name','require',lang('store_goods_brand_name_null')],
                ['brand_initial','require','请填写首字母']
            ];

            $error = $obj_validate->check($date,$rule);
            if (!$error) {
                showValidateError($obj_validate->getError());
            }
            else {
                /**
                 * 上传图片
                 */
                if (!empty($_FILES['brand_pic']['name'])) {
                    $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_BRAND ;
                    $file_name = session('store_id') . '_' . date('YmdHis') . rand(10000, 99999);
                    $file_object = request()->file('brand_pic');
                    $info = $file_object->rule('uniqid')->validate(['ext' => 'jpg,png,gif'])->move($upload_file,$file_name);
                    if ($info) {
                        $_POST['brand_pic'] = $info->getFilename();
                    } else {
                        showDialog($file_object->getError());
                    }
                }
                $where = array();
                $where['brand_id'] = intval($_POST['brand_id']);
                $update_array = array();
                $update_array['brand_initial'] = strtoupper($_POST['brand_initial']);
                $update_array['brand_name'] = trim($_POST['brand_name']);
                $update_array['gc_id'] = $_POST['class_id'];
                $update_array['brand_class'] = $_POST['brand_class'];
                if (!empty($_POST['brand_pic'])) {
                    $update_array['brand_pic'] = $_POST['brand_pic'];
                }

                //查出原图片路径，后面会删除图片
                $brand_info = $model_brand->getBrandInfo($where);
                //halt($brand_info);
                $result = $model_brand->editBrand($where, $update_array);
                if ($result) {
                    //删除老图片
                    if (!empty($brand_info['brand_pic']) && !empty($_POST['brand_pic'])) {
                        @unlink(BASE_UPLOAD_PATH . DS . ATTACH_BRAND . DS . $brand_info['brand_pic']);
                    }
                    showDialog(lang('ds_common_save_succ'), url('sellerbrand/index'), 'succ', empty(input('param.inajax')) ? '' : 'CUR_DIALOG.close();');
                }
                else {
                    showDialog(lang('ds_common_save_fail'));
                }
            }
        }
        else {
            showDialog(lang('ds_common_save_fail'));
        }
    }

    /**
     * 品牌删除
     */
    public function drop_brand()
    {
        $model_brand = Model('brand');
        $brand_id = intval(input('param.brand_id'));
        if ($brand_id > 0) {
            $model_brand->delBrand(array(
                                       'brand_id' => $brand_id, 'brand_apply' => 0, 'store_id' => session('store_id')
                                   ));
            showDialog(lang('ds_common_del_succ'), url('sellerbrand/index'), 'succ');
        }
        else {
            showDialog(lang('ds_common_del_fail'));
        }
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string $menu_type 导航类型
     * @param string $menu_key 当前导航的menu_key
     * @param array $array 附加菜单
     * @return
     */
    protected function getSellerItemList()
    {
        $menu_array = array(
            array(
                'name' => 'brand_list', 'text' => lang('ds_member_path_brand_list'),
                'url' => url('sellerbrand/brand_list')
            )
        );

        return $menu_array;
    }
}