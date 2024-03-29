<?php

namespace app\home\controller;


class Sellerpromotionbooth extends BaseSeller
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub

        if (intval(config('promotion_allow')) !== 1) {
            $this->error(lang('promotion_unavailable'), url('Seller/index'));
        }
    }

    /**
     * 套餐商品列表
     */
    public function index()
    {
        $model_booth = Model('pbooth');
        // 更新套餐状态
        $where = array();
        $where['store_id'] = session('store_id');
        $where['booth_quota_endtime'] = array('lt', TIMESTAMP);
        $model_booth->editBoothClose($where);

            $isOwnShop=checkPlatformStore() ? true:false;
            $this->assign('isOwnShop', $isOwnShop);
            $hasList = $isOwnShop;
        if(!$isOwnShop){
            // 检查是否已购买套餐
            $where = array();
            $where['store_id'] = session('store_id');
            $booth_quota = $model_booth->getBoothQuotaInfo($where);
            $this->assign('booth_quota', $booth_quota);
            if (!empty($booth_quota)) {
                $hasList = true;
            }
        }

        if ($hasList) {
            // 查询已选择商品
            $boothgoods_list = $model_booth->getBoothGoodsList(array('store_id' => session('store_id')), 'goods_id');
            if (!empty($boothgoods_list)) {
                $goodsid_array = array();
                foreach ($boothgoods_list as $val) {
                    $goodsid_array[] = $val['goods_id'];
                }
                $goods_list = Model('goods')->getGoodsList(array(
                                                               'goods_id' => array(
                                                                   'in', $goodsid_array
                                                               )
                                                           ), 'goods_id,goods_name,goods_image,goods_price,store_id,gc_id');
                if (!empty($goods_list)) {
                    $gcid_array = array();  // 商品分类id
                    foreach ($goods_list as $key => $val) {
                        $gcid_array[] = $val['gc_id'];
                        $goods_list[$key]['goods_image'] = thumb($val);
                        $goods_list[$key]['url'] = url('goods/index', array('goods_id' => $val['goods_id']));
                    }
                    $goodsclass_list = Model('goodsclass')->getGoodsClassListByIds($gcid_array);
                    $goodsclass_list = array_under_reset($goodsclass_list, 'gc_id');
                    $this->assign('goods_list', $goods_list);
                    $this->assign('goodsclass_list', $goodsclass_list);
                }
            }
        }
        $this->setSellerCurMenu('Sellerpromotionbooth');
        $this->setSellerCurItem('index');
        return $this->fetch($this->template_dir.'index');
    }

    /**
     * 选择商品
     */
    public function booth_select_goods()
    {
        $model_goods = Model('goods');
        $condition = array();
        $condition['store_id'] = session('store_id');
        if ($_POST['goods_name'] != '') {
            $condition['goods_name'] = array('like', '%' . $_POST['goods_name'] . '%');
        }
        $goods_list = $model_goods->getGoodsOnlineList($condition, '*', 10);

        $this->assign('goods_list', $goods_list);
        $this->assign('show_page', $model_goods->page_info->render());
        echo $this->fetch($this->template_dir.'select_goods');
    }

    /**
     * 购买套餐
     */
    public function booth_quota_add()
    {
        if (request()->isPost()) {
            $quantity = intval($_POST['booth_quota_quantity']); // 购买数量（月）
            $price_quantity = $quantity * intval(config('promotion_booth_price')); // 扣款数
            if ($quantity <= 0 || $quantity > 12) {
                showDialog('参数错误，购买失败。', url('Sellerpromotionbooth/booth_quota_add'), '', 'error');
            }
            // 实例化模型
            $model_booth = Model('pbooth');

            $data = array();
            $data['store_id'] = session('store_id');
            $data['store_name'] = session('store_name');
            $data['booth_quota_starttime'] = TIMESTAMP;
            $data['booth_quota_endtime'] = TIMESTAMP + 60 * 60 * 24 * 30 * $quantity;
            $data['booth_state'] = 1;

            $return = $model_booth->addBoothQuota($data);
            if ($return) {
                // 添加店铺费用记录
                $this->recordStoreCost($price_quantity, '购买推荐展位');

                // 添加任务队列
                $end_time = TIMESTAMP + 60 * 60 * 24 * 30 * $quantity;
                $this->addcron(array('exetime' => $end_time, 'exeid' => session('store_id'), 'type' => 4), true);
                $this->recordSellerLog('购买' . $quantity . '套推荐展位，单位元');
                showDialog('购买成功', url('Sellerpromotionbooth/index'), 'succ');
            }
            else {
                showDialog('购买失败', url('Sellerpromotionbooth/booth_quota_add'));
            }
        }
        // 输出导航
        $this->setSellerCurMenu('Sellerpromotionbooth');
        $this->setSellerCurItem('booth_quota_add');
        return $this->fetch($this->template_dir.'quota_add');
    }

    /**
     * 套餐续费
     */
    public function booth_renew()
    {
        if (request()->isPost()) {
            $model_booth = Model('pbooth');
            $quantity = intval($_POST['booth_quota_quantity']); // 购买数量（月）
            $price_quantity = $quantity * intval(config('promotion_booth_price')); // 扣款数
            if ($quantity <= 0 || $quantity > 12) {
                showDialog('参数错误，购买失败。', url('Sellerpromotionbooth/booth_quota_add'), '', 'error');
            }
            $where = array();
            $where['store_id'] = session('store_id');
            $booth_quota = $model_booth->getBoothQuotaInfo($where);
            if ($booth_quota['booth_quota_endtime'] > TIMESTAMP) {
                // 套餐未超时(结束时间+购买时间)
                $update['booth_quota_endtime'] = intval($booth_quota['booth_quota_endtime']) + 60 * 60 * 24 * 30 * $quantity;
            }
            else {
                // 套餐已超时(当前时间+购买时间)
                $update['booth_quota_endtime'] = TIMESTAMP + 60 * 60 * 24 * 30 * $quantity;
            }
            $return = $model_booth->editBoothQuotaOpen($update, $where);

            if ($return) {
                // 添加店铺费用记录
                $this->recordStoreCost($price_quantity, '购买推荐展位');

                // 添加任务队列
                $end_time = TIMESTAMP + 60 * 60 * 24 * 30 * $quantity;
                $this->addcron(array('exetime' => $end_time, 'exeid' => session('store_id'), 'type' => 4), true);
                $this->recordSellerLog('续费' . $quantity . '套推荐展位，单位元');
                showDialog('购买成功', url('Sellerpromotionbooth/index'), 'succ');
            }
            else {
                showDialog('购买失败', url('Sellerpromotionbooth/booth_quota_add'));
            }
        }
        $this->setSellerCurMenu('Sellerpromotionbooth');
        $this->setSellerCurItem('booth_renew');
        return $this->fetch($this->template_dir.'quota_add');
    }

    /**
     * 选择商品
     */
    public function choosed_goods()
    {
        $gid = input('param.gid');
        if ($gid <= 0) {
            $data = array('result' => 'false', 'msg' => '参数错误');
            $this->_echoJson($data);
        }

        // 验证商品是否存在
        $goods_info = Model('goods')->getGoodsInfoByID($gid, 'goods_id,goods_name,goods_image,goods_price,store_id,gc_id');
        if (empty($goods_info) || $goods_info['store_id'] != session('store_id')) {
            $data = array('result' => 'false', 'msg' => '参数错误');
            $this->_echoJson($data);
        }

        $model_booth = Model('pbooth');

        if (!checkPlatformStore()) {
            // 验证套餐时候过期
            $booth_info = $model_booth->getBoothQuotaInfo(array(
                                                              'store_id' => session('store_id'),
                                                              'booth_quota_endtime' => array('gt', TIMESTAMP)
                                                          ), 'booth_quota_id');
            if (empty($booth_info)) {
                $data = array('result' => 'false', 'msg' => '套餐过期请重新购买套餐');
                $this->_echoJson($data);
            }
        }

        // 验证已添加商品数量，及选择商品是否已经被添加过
        $bootgoods_info = $model_booth->getBoothGoodsList(array('store_id' => session('store_id')), 'goods_id');
        // 已添加商品总数
        if (count($bootgoods_info) >= config('promotion_booth_goods_sum')) {
            $data = array('result' => 'false', 'msg' => '只能添加' . config('promotion_booth_goods_sum') . '个商品');
            $this->_echoJson($data);
        }
        // 商品是否已经被添加
        $bootgoods_info = array_under_reset($bootgoods_info, 'goods_id');
        if (isset($bootgoods_info[$gid])) {
            $data = array('result' => 'false', 'msg' => '商品已经添加，请选择其他商品');
            $this->_echoJson($data);
        }

        // 保存到推荐展位商品表
        $insert = array();
        $insert['store_id'] = session('store_id');
        $insert['goods_id'] = $goods_info['goods_id'];
        $insert['gc_id'] = $goods_info['gc_id'];
        $model_booth->addBoothGoods($insert);

        $this->recordSellerLog('添加推荐展位商品，商品id：' . $goods_info['goods_id']);

        // 输出商品信息
        $goods_info['goods_image'] = thumb($goods_info);
        $goods_info['url'] = url('goods', 'index', array('goods_id' => $goods_info['goods_id']));
        $goods_class = Model('goodsclass')->getGoodsClassInfoById($goods_info['gc_id']);
        $goods_info['gc_name'] = $goods_class['gc_name'];
        $goods_info['result'] = 'true';
        $this->_echoJson($goods_info);
    }

    /**
     * 删除选择商品
     */
    public function del_choosed_goods()
    {
        $gid = input('param.gid');
        if ($gid <= 0) {
            $data = array('result' => 'false', 'msg' => '参数错误');
            $this->_echoJson($data);
        }

        $result = Model('pbooth')->delBoothGoods(array('goods_id' => $gid, 'store_id' => session('store_id')));
        if ($result) {
            $this->recordSellerLog('删除推荐展位商品，商品id：' . $gid);
            $data = array('result' => 'true');
        }
        else {
            $data = array('result' => 'false', 'msg' => '删除失败');
        }
        $this->_echoJson($data);
    }

    /**
     * 输出JSON
     * @param array $data
     */
    private function _echoJson($data)
    {
        echo json_encode($data);
        exit();
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string $menu_type 导航类型
     * @param string $name 当前导航的name
     * @return
     */
    protected function getSellerItemList()
    {
        $menu_array = array();
        switch (request()->action()) {
            case 'index':
                $menu_array = array(
                    array(
                        'name' => 'index', 'text' => '商品列表',
                        'url' => url('Sellerpromotionbooth/index')
                    )
                );
                break;
            case 'booth_quota_add':
                $menu_array = array(
                    array(
                        'name' => 'index', 'text' => '商品列表',
                        'url' => url('Sellerpromotionbooth/index')
                    ), array(
                        'name' => 'booth_quota_add', 'text' => '购买套餐',
                        'url' => url('Sellerpromotionbooth/booth_quota_add')
                    )
                );
                break;
            case 'booth_renew':
                $menu_array = array(
                    array(
                        'name' => 'index', 'text' => '商品列表',
                        'url' => url('Sellerpromotionbooth/index')
                    ), array(
                        'name' => 'booth_renew', 'text' => '套餐续费', 'url' => url('Sellerpromotionbooth/booth_renew')
                    )
                );
                break;
        }
        return $menu_array;
    }

}