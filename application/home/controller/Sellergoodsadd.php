<?php

namespace app\home\controller;

use think\Validate;
use think\Lang;

class Sellergoodsadd extends BaseSeller
{

    public function _initialize()
    {
        parent::_initialize();
        error_reporting(E_ERROR | E_WARNING);
        Lang::load(APP_PATH . 'mobile/lang/zh-cn/sellergoodsadd.lang.php');
    }

    /**
     * 三方店铺验证，商品数量，有效期
     */
    private function checkStore()
    {
        $goodsLimit = (int)$this->store_grade['sg_goods_limit'];
        if ($goodsLimit > 0) {
            // 是否到达商品数上限
            $goods_num = Model('goods')->getGoodsCommonCount(array('store_id' => session('store_id')));
            if ($goods_num >= $goodsLimit) {
                $this->error(lang('store_goods_index_goods_limit') . $goodsLimit . lang('store_goods_index_goods_limit1'), url('Sellergoodsonline/goods_list'));
            }
        }
    }

    public function index()
    {
        $this->checkStore();
        $this->add_step_one();
    }

    /**
     * 添加商品
     */
    public function add_step_one()
    {
        // 实例化商品分类模型
        $model_goodsclass = model('goodsclass');
        // 商品分类
        $goods_class = $model_goodsclass->getGoodsClass(session('store_id'));
        //halt($goods_class);

        // 常用商品分类
        $model_staple = model('goodsclassstaple');
        $param_array = array();
        $param_array['member_id'] = session('member_id');
        $staple_array = $model_staple->getStapleList($param_array);

        $this->assign('staple_array', $staple_array);
        $this->assign('goods_class', $goods_class);
        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('sellergoodsadd');
        $this->setSellerCurItem();
        echo $this->fetch($this->template_dir . 'store_goods_add_step1');
        exit;
    }

    /**
     * 添加商品
     */
    public function add_step_two()
    {
        // 实例化商品分类模型
        $model_goodsclass = model('goodsclass');
        // 现暂时改为从匿名“自营店铺专属等级”中判断
        $editor_multimedia = false;
        if ($this->store_grade['sg_function'] == 'editor_multimedia') {
            $editor_multimedia = true;
        }
        $this->assign('editor_multimedia', $editor_multimedia);

        $gc_id = intval($_GET['class_id']);

        // 验证商品分类是否存在且商品分类是否为最后一级
        $data = model('goodsclass')->getGoodsClassForCacheModel();
        if (!isset($data[$gc_id]) || isset($data[$gc_id]['child']) || isset($data[$gc_id]['childchild'])) {
            showDialog(lang('store_goods_index_again_choose_category1'));
        }

        // 如果不是自营店铺或者自营店铺未绑定全部商品类目，读取绑定分类
        if (!checkPlatformStoreBindingAllGoodsClass()) {
            //商品分类  by 33 hao.com 支持批量显示分类
            $model_bind_class = Model('storebindclass');
            $goods_class = model('goodsclass')->getGoodsClassForCacheModel();
            $where['store_id'] = session('store_id');
            $class_2 = $goods_class[$gc_id]['gc_parent_id'];
            $class_1 = $goods_class[$class_2]['gc_parent_id'];
            $where['class_1'] = $class_1;
            $where['class_2'] = $class_2;
            $where['class_3'] = $gc_id;
            $bind_info = $model_bind_class->getStoreBindClassInfo($where);
            if (empty($bind_info)) {
                $where['class_3'] = 0;
                $bind_info = $model_bind_class->getStoreBindClassInfo($where);
                if (empty($bind_info)) {
                    $where['class_2'] = 0;
                    $where['class_3'] = 0;
                    $bind_info = $model_bind_class->getStoreBindClassInfo($where);
                    if (empty($bind_info)) {
                        $where['class_1'] = 0;
                        $where['class_2'] = 0;
                        $where['class_3'] = 0;
                        $bind_info = Model('storebindclass')->getStoreBindClassInfo($where);
                        if (empty($bind_info)) {
                            showDialog(lang('store_goods_index_again_choose_category2'));
                        }
                    }
                }
            }
        }

        // 更新常用分类信息
        $goods_class = $model_goodsclass->getGoodsClassLineForTag($gc_id);
        $this->assign('goods_class', $goods_class);
        model('goodsclassstaple')->autoIncrementStaple($goods_class, session('member_id'));

        // 获取类型相关数据
        $typeinfo = Model('type')->getAttribute($goods_class['type_id'], session('store_id'), $gc_id);
        list($spec_json, $spec_list, $attr_list, $brand_list) = $typeinfo;
        $this->assign('sign_i', count($spec_list));
        $this->assign('spec_list', $spec_list);
        $this->assign('attr_list', $attr_list);
        $this->assign('brand_list', $brand_list);

        // 实例化店铺商品分类模型
        $store_goods_class = model('storegoodsclass')->getClassTree(array(
                                                                        'store_id' => session('store_id'),
                                                                        'stc_state' => '1'
                                                                    ));
        $this->assign('store_goods_class', $store_goods_class);

        // 小时分钟显示
        $hour_array = array(
            '00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17',
            '18', '19', '20', '21', '22', '23'
        );
        $this->assign('hour_array', $hour_array);
        $minute_array = array('05', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55');
        $this->assign('minute_array', $minute_array);

        // 关联版式
        $plate_list = Model('storeplate')->getStorePlateList(array('store_id' => session('store_id')), 'plate_id,plate_name,plate_position');
        $plate_list = array_under_reset($plate_list, 'plate_position', 2);
        $this->assign('plate_list', $plate_list);
        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('sellergoodsadd');
        $this->setSellerCurItem();
        return $this->fetch($this->template_dir . 'store_goods_add_step2');
    }

    /**
     * 保存商品（商品发布第二步使用）
     */
    public function save_goods()
    {
        if (request()->isPost()) {
            $model_goods = Model('goods');
            $model_type = Model('type');

            // 分类信息
            $goods_class = model('goodsclass')->getGoodsClassLineForTag(intval(input('post.cate_id')));

            $common_array = array();
            $common_array['goods_name'] = input('post.g_name');
            $common_array['goods_jingle'] = input('post.g_jingle');
            $common_array['gc_id'] = intval(input('post.cate_id'));
            $common_array['gc_id_1'] = intval($goods_class['gc_id_1']);
            $common_array['gc_id_2'] = intval($goods_class['gc_id_2']);
            $common_array['gc_id_3'] = intval($goods_class['gc_id_3']);
            $common_array['gc_name'] = input('post.cate_name');
            $common_array['brand_id'] = input('post.b_id');
            $common_array['brand_name'] = input('post.b_name');
            $common_array['type_id'] = intval(input('post.type_id'));
            $common_array['goods_image'] = input('post.image_path');
            $common_array['goods_price'] = floatval(input('post.g_price'));
            $common_array['goods_marketprice'] = floatval(input('post.g_marketprice'));
            $common_array['goods_costprice'] = floatval(input('post.g_costprice'));
            $common_array['goods_discount'] = floatval(input('post.g_discount'));
            $common_array['goods_serial'] = input('post.g_serial');
            $common_array['goods_storage_alarm'] = intval(input('post.g_alarm'));
            $common_array['goods_attr'] = serialize($_POST['attr']);
            $common_array['goods_body'] = input('post.g_body');

            // 序列化保存手机端商品描述数据
            if ($_POST['m_body'] != '') {
                $_POST['m_body'] = str_replace('&quot;', '"', $_POST['m_body']);
                $_POST['m_body'] = json_decode($_POST['m_body'], true);
                if (!empty($_POST['m_body'])) {
                    $_POST['m_body'] = serialize($_POST['m_body']);
                }
                else {
                    $_POST['m_body'] = '';
                }
            }
            $common_array['mobile_body'] = $_POST['m_body'];
            $common_array['goods_commend'] = intval($_POST['g_commend']);
            $common_array['goods_state'] = ($this->store_info['store_state'] != 1) ? 0 : intval($_POST['g_state']);            // 店铺关闭时，商品下架
            $common_array['goods_addtime'] = TIMESTAMP;
            $common_array['goods_selltime'] = strtotime(input('post.starttime')) + intval(input('post.starttime_H')) * 3600 + intval(input('post.starttime_i')) * 60;
            $common_array['goods_verify'] = (config('goods_verify') == 1) ? 10 : 1;
            $common_array['store_id'] = session('store_id');
            $common_array['store_name'] = session('store_name');
            $common_array['spec_name'] = is_array($_POST['spec']) ? serialize($_POST['sp_name']) : serialize(null);
            $common_array['spec_value'] = is_array($_POST['spec']) ? serialize($_POST['sp_val']) : serialize(null);
            $common_array['goods_vat'] = intval($_POST['g_vat']);
            $common_array['areaid_1'] = intval($_POST['province_id']);
            $common_array['areaid_2'] = intval($_POST['city_id']);
            $common_array['transport_id'] = ($_POST['freight'] == '0') ? '0' : intval($_POST['transport_id']); // 售卖区域
            $common_array['transport_title'] = $_POST['transport_title'];
            $common_array['goods_freight'] = floatval($_POST['g_freight']);

            //验证数据  BEGIN
            $rule = [
                ['goods_name', 'require', lang('store_goods_index_goods_name_null')],
                ['goods_price', 'require', lang('store_goods_index_goods_price_null')],
            ];
            $validate = new Validate($rule);
            $validate_result = $validate->check($common_array);
            if (!$validate_result) {
                $this->error($validate->getError());
            }
            //验证数据  END


            //查询店铺商品分类
            $goods_stcids_arr = array();
            if (!empty($_POST['sgcate_id'])) {
                $sgcate_id_arr = array();
                foreach ($_POST['sgcate_id'] as $k => $v) {
                    $sgcate_id_arr[] = intval($v);
                }
                $sgcate_id_arr = array_unique($sgcate_id_arr);
                $store_goods_class = model('storegoodsclass')->getStoreGoodsClassList(array(
                                                                                          'store_id' => session('store_id'),
                                                                                          'stc_id' => array(
                                                                                              'in', $sgcate_id_arr
                                                                                          ), 'stc_state' => '1'
                                                                                      ));
                if (!empty($store_goods_class)) {
                    foreach ($store_goods_class as $k => $v) {
                        if ($v['stc_id'] > 0) {
                            $goods_stcids_arr[] = $v['stc_id'];
                        }
                        if ($v['stc_parent_id'] > 0) {
                            $goods_stcids_arr[] = $v['stc_parent_id'];
                        }
                    }
                    $goods_stcids_arr = array_unique($goods_stcids_arr);
                    sort($goods_stcids_arr);
                }
            }
            if (empty($goods_stcids_arr)) {
                $common_array['goods_stcids'] = '';
            }
            else {
                $common_array['goods_stcids'] = ',' . implode(',', $goods_stcids_arr) . ','; // 首尾需要加,
            }

            $common_array['plateid_top'] = intval($_POST['plate_top']) > 0 ? intval($_POST['plate_top']) : '';
            $common_array['plateid_bottom'] = intval($_POST['plate_bottom']) > 0 ? intval($_POST['plate_bottom']) : '';
            $common_array['is_virtual'] = intval(input('post.is_gv'));
            $common_array['virtual_indate'] = input('post.g_vindate') != '' ? (strtotime(input('post.g_vindate')) + 24 * 60 * 60 - 1) : 0;  // 当天的最后一秒结束
            $common_array['virtual_limit'] = intval(input('post.g_vlimit')) > 10 || intval(input('post.g_vlimit')) < 0 ? 10 : intval(input('post.g_vlimit'));
            $common_array['virtual_invalid_refund'] = intval(input('post.g_vinvalidrefund'));
            $common_array['is_fcode'] = intval(input('post.is_fc'));
            $common_array['is_appoint'] = intval(input('post.is_appoint'));     // 只有库存为零的商品可以预约
            $common_array['appoint_satedate'] = $common_array['is_appoint'] == 1 ? strtotime(input('post.g_saledate')) : '';   // 预约商品的销售时间
            $common_array['is_presell'] = $common_array['goods_state'] == 1 ? intval(input('post.is_presell')) : 0;     // 只有出售中的商品可以预售
            $common_array['presell_deliverdate'] = $common_array['is_presell'] == 1 ? strtotime(input('post.g_deliverdate')) : ''; // 预售商品的发货时间
            $common_array['is_own_shop'] = in_array(session('store_id'), model('store')->getOwnShopIds()) ? 1 : 0;

            // 保存数据
            $common_id = $model_goods->addGoodsCommon($common_array);
            if ($common_id) {
                // 生成的商品id（SKU）
                $goodsid_array = array();
                // 商品规格
                if (is_array($_POST['spec'])) {
                    foreach ($_POST['spec'] as $value) {
                        $goods = array();
                        $goods['goods_commonid'] = $common_id;
                        $goods['goods_name'] = $common_array['goods_name'] . ' ' . implode(' ', $value['sp_value']);
                        $goods['goods_jingle'] = $common_array['goods_jingle'];
                        $goods['store_id'] = $common_array['store_id'];
                        $goods['store_name'] = session('store_name');
                        $goods['gc_id'] = $common_array['gc_id'];
                        $goods['gc_id_1'] = $common_array['gc_id_1'];
                        $goods['gc_id_2'] = $common_array['gc_id_2'];
                        $goods['gc_id_3'] = $common_array['gc_id_3'];
                        $goods['brand_id'] = $common_array['brand_id'];
                        $goods['goods_price'] = $value['price'];
                        $goods['goods_promotion_price'] = $value['price'];
                        $goods['goods_marketprice'] = $value['marketprice'] == 0 ? $common_array['goods_marketprice'] : $value['marketprice'];
                        $goods['goods_serial'] = $value['sku'];
                        $goods['goods_storage_alarm'] = intval($value['alarm']);
                        $goods['goods_spec'] = serialize($value['sp_value']);
                        $goods['goods_storage'] = $value['stock'];
                        $goods['goods_image'] = $common_array['goods_image'];
                        $goods['goods_state'] = $common_array['goods_state'];
                        $goods['goods_verify'] = $common_array['goods_verify'];
                        $goods['goods_addtime'] = TIMESTAMP;
                        $goods['goods_edittime'] = TIMESTAMP;
                        $goods['areaid_1'] = $common_array['areaid_1'];
                        $goods['areaid_2'] = $common_array['areaid_2'];
                        $goods['color_id'] = isset($value['color']) ? intval($value['color']) : '';
                        $goods['transport_id'] = $common_array['transport_id'];
                        $goods['goods_freight'] = $common_array['goods_freight'];
                        $goods['goods_vat'] = $common_array['goods_vat'];
                        $goods['goods_commend'] = $common_array['goods_commend'];
                        $goods['goods_stcids'] = $common_array['goods_stcids'];
                        $goods['is_virtual'] = $common_array['is_virtual'];
                        $goods['virtual_indate'] = $common_array['virtual_indate'];
                        $goods['virtual_limit'] = $common_array['virtual_limit'];
                        $goods['virtual_invalid_refund'] = $common_array['virtual_invalid_refund'];
                        $goods['is_fcode'] = $common_array['is_fcode'];
                        $goods['is_appoint'] = $common_array['is_appoint'];
                        $goods['is_presell'] = $common_array['is_presell'];
                        $goods['is_own_shop'] = $common_array['is_own_shop'];
                        $goods_id = $model_goods->addGoods($goods);
                        $model_type->addGoodsType($goods_id, $common_id, array(
                            'cate_id' => $_POST['cate_id'], 'type_id' => $_POST['type_id'], 'attr' => $_POST['attr']
                        ));

                        $goodsid_array[] = $goods_id;
                    }
                }
                else {
                    $goods = array();
                    $goods['goods_commonid'] = $common_id;
                    $goods['goods_name'] = $common_array['goods_name'];
                    $goods['goods_jingle'] = $common_array['goods_jingle'];
                    $goods['store_id'] = $common_array['store_id'];
                    $goods['store_name'] = session('store_name');
                    $goods['gc_id'] = $common_array['gc_id'];
                    $goods['gc_id_1'] = $common_array['gc_id_1'];
                    $goods['gc_id_2'] = $common_array['gc_id_2'];
                    $goods['gc_id_3'] = $common_array['gc_id_3'];
                    $goods['brand_id'] = $common_array['brand_id'];
                    $goods['goods_price'] = $common_array['goods_price'];
                    $goods['goods_promotion_price'] = $common_array['goods_price'];
                    $goods['goods_marketprice'] = $common_array['goods_marketprice'];
                    $goods['goods_serial'] = $common_array['goods_serial'];
                    $goods['goods_storage_alarm'] = $common_array['goods_storage_alarm'];
                    $goods['goods_spec'] = serialize(null);
                    $goods['goods_storage'] = intval($_POST['g_storage']);
                    $goods['goods_image'] = $common_array['goods_image'];
                    $goods['goods_state'] = $common_array['goods_state'];
                    $goods['goods_verify'] = $common_array['goods_verify'];
                    $goods['goods_addtime'] = TIMESTAMP;
                    $goods['goods_edittime'] = TIMESTAMP;
                    $goods['areaid_1'] = $common_array['areaid_1'];
                    $goods['areaid_2'] = $common_array['areaid_2'];
                    $goods['color_id'] = 0;
                    $goods['transport_id'] = $common_array['transport_id'];
                    $goods['goods_freight'] = $common_array['goods_freight'];
                    $goods['goods_vat'] = $common_array['goods_vat'];
                    $goods['goods_commend'] = $common_array['goods_commend'];
                    $goods['goods_stcids'] = $common_array['goods_stcids'];
                    $goods['is_virtual'] = $common_array['is_virtual'];
                    $goods['virtual_indate'] = $common_array['virtual_indate'];
                    $goods['virtual_limit'] = $common_array['virtual_limit'];
                    $goods['virtual_invalid_refund'] = $common_array['virtual_invalid_refund'];
                    $goods['is_fcode'] = $common_array['is_fcode'];
                    $goods['is_appoint'] = $common_array['is_appoint'];
                    $goods['is_presell'] = $common_array['is_presell'];
                    $goods['is_own_shop'] = $common_array['is_own_shop'];
                    $goods_id = $model_goods->addGoods($goods);
                    $model_type->addGoodsType($goods_id, $common_id, array(
                        'cate_id' => $_POST['cate_id'], 'type_id' => $_POST['type_id'], 'attr' => $_POST['attr']
                    ));

                    $goodsid_array[] = $goods_id;
                }


                // 商品加入上架队列
                if (isset($_POST['starttime'])) {
                    $selltime = strtotime($_POST['starttime']) + intval($_POST['starttime_H']) * 3600 + intval($_POST['starttime_i']) * 60;
                    if ($selltime > TIMESTAMP) {
                        $this->addcron(array('exetime' => $selltime, 'exeid' => $common_id, 'type' => 1), true);
                    }
                }

                // 记录日志
                $this->recordSellerLog('添加商品，平台货号:' . $common_id);

                // 生成F码
                if ($common_array['is_fcode'] == 1) {
                    \mall\queue\QueueClient::push('createGoodsFCode', array(
                        'goods_commonid' => $common_id, 'fc_count' => intval($_POST['g_fccount']),
                        'fc_prefix' => $_POST['g_fcprefix']
                    ));
                }
                $this->redirect(url('/Home/Sellergoodsadd/add_step_three', ['commonid' => $common_id]));
            }
            else {
                $this->error(lang('store_goods_index_goods_add_fail'), getReferer());
            }
        }
    }

    /**
     * 第三步添加颜色图片
     */
    public function add_step_three()
    {
        $common_id = input('param.commonid');
        if ($common_id <= 0) {
            $this->error(lang('wrong_argument'), url('Home/Seller/index'));
        }

        $model_goods = Model('goods');
        $img_array = $model_goods->getGoodsList(array('goods_commonid' => $common_id), 'color_id,goods_image', 'color_id');
        // 整理，更具id查询颜色名称
        $colorid_array = array();
        if (!empty($img_array)) {
            $image_array = array();
            foreach ($img_array as $val) {
                $image_array[$val['color_id']][0]['goods_image'] = $val['goods_image'];
                $image_array[$val['color_id']][0]['is_default'] = 1;
                $colorid_array[] = $val['color_id'];
            }
            $this->assign('img', $image_array);
        }

        $common_list = $model_goods->getGoodeCommonInfoByID($common_id, 'spec_value');
        $spec_value = unserialize($common_list['spec_value']);
        $this->assign('value', $spec_value['1']);

        $model_spec = Model('spec');
        $value_array = $model_spec->getSpecValueList(array(
                                                         'sp_value_id' => array('in', $colorid_array),
                                                         'store_id' => session('store_id')
                                                     ), 'sp_value_id,sp_value_name');
        if (empty($value_array)) {
            $value_array[] = array('sp_value_id' => '0', 'sp_value_name' => '无颜色');
        }
        $this->assign('value_array', $value_array);

        $this->assign('commonid', $common_id);


        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('sellergoodsadd');
        $this->setSellerCurItem();
        return $this->fetch($this->template_dir . 'store_goods_add_step3');
    }

    /**
     * 保存商品颜色图片
     */
    public function save_image()
    {
        if (request()->isPost()) {
            $common_id = intval(input('param.commonid'));
            if ($common_id <= 0 || empty($_POST['img'])) {
                $this->error(lang('wrong_argument'));
            }
            $model_goods = Model('goods');
            // 保存
            $insert_array = array();
            foreach ($_POST['img'] as $key => $value) {
                foreach ($value as $v) {
                    if ($v['name'] == '') {
                        continue;
                    }
                    //$k = 0;
                    // 商品默认主图
                    $update_array = array();        // 更新商品主图
                    $update_where = array();
                    $update_array['goods_image'] = $v['name'];
                    $update_where['goods_commonid'] = $common_id;
                    $update_where['color_id'] = $key;
                    if ($k == 0 || $v['default'] == 1) {
                        $k++;
                        $update_array['goods_image'] = $v['name'];
                        $update_where['goods_commonid'] = $common_id;
                        $update_where['color_id'] = $key;
                        // 更新商品主图
                        $model_goods->editGoods($update_array, $update_where);
                    }
                    $tmp_insert = array();
                    $tmp_insert['goods_commonid'] = $common_id;
                    $tmp_insert['store_id'] = session('store_id');
                    $tmp_insert['color_id'] = $key;
                    $tmp_insert['goods_image'] = $v['name'];
                    $tmp_insert['goods_image_sort'] = ($v['default'] == 1) ? 0 : intval($v['sort']);
                    $tmp_insert['is_default'] = $v['default'];
                    $insert_array[] = $tmp_insert;
                }
            }
            $rs = $model_goods->addGoodsImagesAll($insert_array);
            if ($rs) {
                $this->redirect(url('Home/Sellergoodsadd/add_step_four', ['commonid' => $common_id]));
            }
            else {
                $this->error(lang('ds_common_save_fail'));
            }
        }
    }

    /**
     * 商品发布第四步
     */
    public function add_step_four()
    {
        $commonid = input('param.commonid');
        // 单条商品信息
        $goods_info = Model('goods')->getGoodsInfo(array('goods_commonid' => $commonid));

        // 自动发布动态
        $data_array = array();
        $data_array['goods_id'] = $goods_info['goods_id'];
        $data_array['store_id'] = $goods_info['store_id'];
        $data_array['goods_name'] = $goods_info['goods_name'];
        $data_array['goods_image'] = $goods_info['goods_image'];
        $data_array['goods_price'] = $goods_info['goods_price'];
        $data_array['goods_transfee_charge'] = $goods_info['goods_freight'] == 0 ? 1 : 0;
        $data_array['goods_freight'] = $goods_info['goods_freight'];


        //自动发布店铺动态
        $this->storeAutoShare($data_array, 'new');

        $this->assign('allow_gift', Model('goods')->checkGoodsIfAllowGift($goods_info));
        $this->assign('allow_combo', Model('goods')->checkGoodsIfAllowCombo($goods_info));
        $this->assign('goods_id', $goods_info['goods_id']);

        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('sellergoodsadd');
        $this->setSellerCurItem();
        return $this->fetch($this->template_dir . 'store_goods_add_step4');
    }

    /**
     * 上传图片
     */
    public function image_upload()
    {
        // 判断图片数量是否超限
        $model_album = Model('album');
        $album_limit = $this->store_grade['sg_album_limit'];
        if ($album_limit > 0) {
            $album_count = $model_album->getCount(array('store_id' => session('store_id')));

            if ($album_count >= $album_limit) {
                $error = lang('store_goods_album_climit');
                exit(json_encode(array('error' => $error)));
            }
        }
        $class_info = $model_album->getOne(array('store_id' => session('store_id'), 'is_default' => 1), 'albumclass');


        $store_id = session('store_id');
        /**
         * 上传图片
         */
        //上传文件保存路径
        $upload_file = ATTACH_GOODS . '/' . $store_id;
        $save_name = session('store_id') . '_' . date('YmdHis') . rand(10000, 99999);
        $file_name = $_POST['name'];

        $result = upload_goods_image($upload_file, $file_name, $save_name);
        if($result['code']=='200'){
            $img_path=$result['result'];
            list($width, $height, $type, $attr) = getimagesize($img_path);
            $img_path=substr(strrchr($img_path, "/"), 1);
        }else{
            //未上传图片或出错不做后面处理
            exit;
        }

        // 存入相册
        $insert_array = array();
        $insert_array['apic_name'] = $img_path;
        $insert_array['apic_tag'] = '';
        $insert_array['aclass_id'] = $class_info['aclass_id'];
        $insert_array['apic_cover'] = $img_path;
        $insert_array['apic_size'] = intval($_FILES[$file_name]['size']);
        $insert_array['apic_spec'] = $width . 'x' . $height;
        $insert_array['upload_time'] = time();
        $insert_array['store_id'] = $store_id;
        $result = Model('uploadalbum')->add($insert_array);


        $data = array();
        $data ['thumb_name'] = cthumb($img_path, 240, session('store_id'));
        $data ['name'] = $img_path;

        // 整理为json格式
        $output = json_encode($data);
        echo $output;
        exit();
    }

    /**
     * ajax获取商品分类的子级数据
     */
    public function ajax_goods_class()
    {
        $gc_id = intval(input('get.gc_id'));
        $deep = intval(input('get.deep'));
        if ($gc_id <= 0 || $deep <= 0 || $deep >= 4) {
            exit(json_encode(array()));
        }
        $model_goodsclass = model('goodsclass');
        $list = $model_goodsclass->getGoodsClass(session('store_id'), $gc_id, $deep);
        if (empty($list)) {
            exit(json_encode(array()));
        }
        echo json_encode($list);
    }

    /**
     * ajax删除常用分类
     */
    public function ajax_stapledel()
    {
        $staple_id = intval($_GET ['staple_id']);
        if ($staple_id < 1) {
            echo json_encode(array(
                                 'done' => false, 'msg' => lang('wrong_argument')
                             ));
            die();
        }
        /**
         * 实例化模型
         */
        $model_staple = model('goodsclassstaple');

        $result = $model_staple->delStaple(array('staple_id' => $staple_id, 'member_id' => session('member_id')));
        if ($result) {
            echo json_encode(array(
                                 'done' => true
                             ));
            die();
        }
        else {
            echo json_encode(array(
                                 'done' => false, 'msg' => ''
                             ));
            die();
        }
    }

    /**
     * ajax选择常用商品分类
     */
    public function ajax_show_comm()
    {
        $staple_id = intval($_GET['stapleid']);

        /**
         * 查询相应的商品分类id
         */
        $model_staple = model('goodsclassstaple');
        $staple_info = $model_staple->getStapleInfo(array('staple_id' => intval($staple_id)), 'gc_id_1,gc_id_2,gc_id_3');
        if (empty($staple_info) || !is_array($staple_info)) {
            echo json_encode(array(
                                 'done' => false, 'msg' => ''
                             ));
            die();
        }

        $list_array = array();
        $list_array['gc_id'] = 0;
        $list_array['type_id'] = $staple_info['type_id'];
        $list_array['done'] = true;
        $list_array['one'] = '';
        $list_array['two'] = '';
        $list_array['three'] = '';

        $gc_id_1 = intval($staple_info['gc_id_1']);
        $gc_id_2 = intval($staple_info['gc_id_2']);
        $gc_id_3 = intval($staple_info['gc_id_3']);

        /**
         * 查询同级分类列表
         */
        $model_goods_class = model('goodsclass');
        // 1级
        if ($gc_id_1 > 0) {
            $list_array['gc_id'] = $gc_id_1;
            $class_list = $model_goods_class->getGoodsClass(session('store_id'));
            if (empty($class_list) || !is_array($class_list)) {
                echo json_encode(array(
                                     'done' => false, 'msg' => ''
                                 ));
                die();
            }
            foreach ($class_list as $val) {
                if ($val ['gc_id'] == $gc_id_1) {
                    $list_array ['one'] .= '<li class="" onclick="selClass($(this));" data-param="{gcid:' . $val ['gc_id'] . ', deep:1, tid:' . $val ['type_id'] . '}" nctype="selClass"> <a class="classDivClick" href="javascript:void(0)"><span class="has_leaf"><i class="icon-double-angle-right"></i>' . $val ['gc_name'] . '</span></a> </li>';
                }
                else {
                    $list_array ['one'] .= '<li class="" onclick="selClass($(this));" data-param="{gcid:' . $val ['gc_id'] . ', deep:1, tid:' . $val ['type_id'] . '}" nctype="selClass"> <a class="" href="javascript:void(0)"><span class="has_leaf"><i class="icon-double-angle-right"></i>' . $val ['gc_name'] . '</span></a> </li>';
                }
            }
        }
        // 2级
        if ($gc_id_2 > 0) {
            $list_array['gc_id'] = $gc_id_2;
            $class_list = $model_goods_class->getGoodsClass(session('store_id'), $gc_id_1, 2);
            if (empty($class_list) || !is_array($class_list)) {
                echo json_encode(array(
                                     'done' => false, 'msg' => ''
                                 ));
                die();
            }
            foreach ($class_list as $val) {
                if ($val ['gc_id'] == $gc_id_2) {
                    $list_array ['two'] .= '<li class="" onclick="selClass($(this));" data-param="{gcid:' . $val ['gc_id'] . ', deep:2, tid:' . $val ['type_id'] . '}" nctype="selClass"> <a class="classDivClick" href="javascript:void(0)"><span class="has_leaf"><i class="icon-double-angle-right"></i>' . $val ['gc_name'] . '</span></a> </li>';
                }
                else {
                    $list_array ['two'] .= '<li class="" onclick="selClass($(this));" data-param="{gcid:' . $val ['gc_id'] . ', deep:2, tid:' . $val ['type_id'] . '}" nctype="selClass"> <a class="" href="javascript:void(0)"><span class="has_leaf"><i class="icon-double-angle-right"></i>' . $val ['gc_name'] . '</span></a> </li>';
                }
            }
        }
        // 3级
        if ($gc_id_3 > 0) {
            $list_array['gc_id'] = $gc_id_3;
            $class_list = $model_goods_class->getGoodsClass(session('store_id'), $gc_id_2, 3);
            if (empty($class_list) || !is_array($class_list)) {
                echo json_encode(array(
                                     'done' => false, 'msg' => ''
                                 ));
                die();
            }
            foreach ($class_list as $val) {
                if ($val ['gc_id'] == $gc_id_3) {
                    $list_array ['three'] .= '<li class="" onclick="selClass($(this));" data-param="{gcid:' . $val ['gc_id'] . ', deep:3, tid:' . $val ['type_id'] . '}" nctype="selClass"> <a class="classDivClick" href="javascript:void(0)"><span class="has_leaf"><i class="icon-double-angle-right"></i>' . $val ['gc_name'] . '</span></a> </li>';
                }
                else {
                    $list_array ['three'] .= '<li class="" onclick="selClass($(this));" data-param="{gcid:' . $val ['gc_id'] . ', deep:3, tid:' . $val ['type_id'] . '}" nctype="selClass"> <a class="" href="javascript:void(0)"><span class="has_leaf"><i class="icon-double-angle-right"></i>' . $val ['gc_name'] . '</span></a> </li>';
                }
            }
        }
        echo json_encode($list_array);
        die();
    }

    /**
     * AJAX添加商品规格值
     */
    public function ajax_add_spec()
    {
        $name = trim($_GET['name']);
        $gc_id = intval($_GET['gc_id']);
        $sp_id = intval($_GET['sp_id']);
        if ($name == '' || $gc_id <= 0 || $sp_id <= 0) {
            echo json_encode(array('done' => false));
            die();
        }
        $insert = array(
            'sp_value_name' => $name, 'sp_id' => $sp_id, 'gc_id' => $gc_id, 'store_id' => session('store_id'),
            'sp_value_color' => null, 'sp_value_sort' => 0,
        );
        $value_id = Model('spec')->addSpecValue($insert);
        if ($value_id) {
            echo json_encode(array('done' => true, 'value_id' => $value_id));
            die();
        }
        else {
            echo json_encode(array('done' => false));
            die();
        }
    }

    /**
     * AJAX查询品牌
     */
    public function ajax_get_brand()
    {
        $type_id = intval(input('tid'));
        $initial = trim(input('letter'));
        $keyword = trim(input('keyword'));
        $type = trim(input('type'));
        if (!in_array($type, array(
                'letter', 'keyword'
            )) || ($type == 'letter' && empty($initial)) || ($type == 'keyword' && empty($keyword))) {
            echo json_encode(array());
            die();
        }

        // 实例化模型
        $model_type = Model('type');
        $where = array();
        $where['type_id'] = $type_id;
        // 验证类型是否关联品牌
        $count = $model_type->getTypeBrandCount($where);
        if ($type == 'letter') {
            switch ($initial) {
                case 'all':
                    break;
                case '0-9':
                    $where['brand_initial'] = array('in', array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9));
                    break;
                default:
                    $where['brand_initial'] = $initial;
                    break;
            }
        }
        else {
            $where['brand_name|brand_initial'] = array('like', '%' . $keyword . '%');
        }
        if ($count > 0) {
            $brand_array = $model_type->typeRelatedJoinList($where, 'brand', 'brand.brand_id,brand.brand_name,brand.brand_initial');
        }
        else {
            unset($where['type_id']);
            $brand_array = Model('brand')->getBrandPassedList($where, 'brand_id,brand_name,brand_initial', 0, 'brand_initial asc, brand_sort asc');
        }
        echo json_encode($brand_array);
        die();
    }

}

?>
