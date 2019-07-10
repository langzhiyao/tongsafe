<?php

namespace app\admin\controller;

use think\Lang;
use think\Validate;

class Vrsorder extends AdminControl {

    /**
     * 每次导出订单数量
     * @var int
     */
    const EXPORT_SIZE = 1000;

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/zh-cn/vrorder.lang.php');
        Lang::load(APP_PATH . 'admin/lang/zh-cn/school.lang.php');
        Lang::load(APP_PATH . 'admin/lang/zh-cn/admin.lang.php');
        //获取当前角色对当前子目录的权限
        $class_name=explode('\\',__CLASS__);
        $class_name = strtolower(end($class_name));
        $perm_id = $this->get_permid($class_name);
        $this->action = $action = $this->get_role_perms(session('admin_gid') ,$perm_id);
        $this->assign('action',$action);
    }

    public function index() {
        if(session('admin_is_super') !=1 && !in_array(4,$this->action )){
            $this->error(lang('ds_assign_right'));
        }
        $order = Model('Packagesorder');
        $condition = array();
        $admininfo = $this->getAdminInfo();
        if($admininfo['admin_id']!=1){
            $model_company = Model("Company");
            $condition = $model_company->getCondition($admininfo['admin_company_id']);
        }
        $condition['pkg_type'] = 1;
        $condition['delete_state'] = 0;
        $buyer_name = input('get.buyer_name');
        if ($buyer_name) {
            $condition['buyer_mobile'] = array('like', "%" . $buyer_name . "%");
        }
        $order_state = input('get.order_state');
        if ($order_state!="") {
            $condition['order_state'] = intval($order_state);
        }
        $payment_code = input('get.payment_code');
        if (!empty($payment_code)) {
            $condition['payment_code'] = $payment_code;
        }
        $order_list = $order->getOrderList($condition, 15);
        foreach ($order_list as $key=>$item) {
            $studentinfo = db('student')->where(array('s_id'=>$item['s_id']))->find();
            $order_list[$key]['student_name'] = $studentinfo['s_name'];
        }
        $payment = db('mbpayment')->select();
        $this->assign('payment', $payment);
        $this->assign('order_list', $order_list);
        
        $this->assign('page', $order->page_info->render());
        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    /**
     * 线下订单列表
     * @Author 老王
     * @创建时间   2019-06-25
     * @return [type]     [description]
     */
    public function offlineorder() {
        if(session('admin_is_super') !=1 && !in_array(4,$this->action )){
            $this->error(lang('ds_assign_right'));
        }
        Lang::load(APP_PATH . 'office/lang/zh-cn/student.lang.php');
        if(!empty(input('school'))){
            $where['o.school_id'] = intval(input('school'));
        }
        if(!empty($_GET['status'])){
            $where['o.status'] = intval(input('status'));
        }
        if(!empty($_GET['addtime'])){
            $where['o.addtime'] = intval(input('addtime'));
        }
        $model_order = model('offlineorder');
        $list = $model_order->getOfflineOrderlList($where, 10);
        //查询绑定总数
        $this->assign('list',$list);
        $this->assign('page', $model_order->page_info->render());
        $this->setAdminCurItem('offlineorder');
        return $this->fetch();
    }

    /**
     * 线下订单审核
     * @Author 老王
     * @创建时间   2019-06-25
     * @return [type]     [description]
     */
    public function checkup(){
        $orderId = intval(input('post.id'));
        $status = intval(input('post.status'));
        $note = trim(input('post.note'));
        $price        = input();
        $should_price = $price['price']['should_price'];
        $now_price    = $price['price']['now_price'];
        $last_price   = $price['price']['last_price'];
        $orderModel = model('offlineorder');
        $order = $orderModel->getOneOfflineOrders($orderId);
        if(!$order)exit(json_encode(array('code'=>1,'msg'=>'当前订单已被删除！')));  
        $update = [
            'status' => $status,
            'note' =>$note,
            'examinetime' =>time(),
            'should_price' => $should_price,
            'now_price'    => $now_price,
            'is_settle'    => (intval($should_price)-intval($now_price))==0?2:1
        ];
        $res = $orderModel->editOfflineOrders($update,['id'=>$orderId]);
        if ($res) {
            $ress = $this->SettleOrder($orderId,$update);
            if ($ress) {
                exit(json_encode(array('code'=>0,'status'=>$status,'msg'=>'审核完成！')));    
            }else{
                exit(json_encode(array('code'=>1,'msg'=>'A-审核失败，请重试！')));    
            }    
        }else{
            exit(json_encode(array('code'=>1,'msg'=>'B-审核失败，请重试！')));    
        }
    }

    public function toSettleOrder(){
        $orderId      = intval(input('post.id'));
        $note         = trim(input('post.note'));
        $price        = input();
        $should_price = $price['price']['should_price'];
        $now_price    = $price['price']['now_price'];
        $last_price   = $price['price']['last_price'];
        $orderModel = model('offlineorder');
        $order = $orderModel->getOneOfflineOrders($orderId);
        if(!$order)exit(json_encode(array('code'=>1,'msg'=>'当前订单已被删除！')));  
        $update = [
            'note'         => $note,
            'examinetime'  => time(),
            'should_price' => $should_price,
            'now_price'    => ($now_price+$last_price),
            'last_price'   => $last_price,
            'is_settle'    => (intval($order['should_price'])-intval($now_price+$last_price))==0?2:1
        ];
        
        $res = $orderModel->editOfflineOrders($update,['id'=>$orderId]);
        if ($res) {
            $ress = $this->SettleOrder($orderId,$update);
            if ($ress) {
                exit(json_encode(array('code'=>0,'status'=>$status,'msg'=>'本次结算完成！')));    
            }else{
                exit(json_encode(array('code'=>1,'msg'=>'A-结算失败，请重试！')));    
            }
        }else{
            exit(json_encode(array('code'=>1,'msg'=>'B-结算失败，请重试！')));    
        }
    }

    /**
     * 组装分润记录
     * @Author 老王
     * @创建时间   2019-06-27
     * @param  [type]     $order   [description]
     * @param  [type]     $company [description]
     */
    public function FormatProfitArray($order,$company){
        if ($company) {
            $officeProfit = [
                'office_id'         => $order['office_id'] ,
                'office_company_id' => $company['o_id'] ,
                'price'             => $order['last_price'] ,
                'scale_price'       => $order['last_price']* (OfficePrifitCalu($company)/100),
                'scale'             => OfficePrifitCalu($company),
                'from'              => $order['addtime'] ,
                'addtime'           => time() ,
                'type'              => 1 
            ];
            return $officeProfit;
        }
    }

    /**
     * 查看公司上级，省市县 递归查询
     * @Author 老王
     * @创建时间   2019-06-28
     * @param  [array]     $order        [订单信息]
     * @param  [array]     $company      [公司信息]
     * @param  [array]     $officeProfit [分润]
     * @return [array]                   [description]
     */
    public function checkUpSuperiors($order,$company,$officeProfit){
        $companyModel = model('company');
        //2，省级代理；3，市级代理；1，县区代理；4，特约代理
        
        if ($company['direct_superiors'] && $company['o_role']==4) {
            //特约代理给直属上级代理商分润
            $company = $companyModel->getOrganizeInfo(['o_id'=>$company['direct_superiors']]);
            $officeProfit[] = $this->FormatProfitArray($order,$company);
            return $this->checkUpSuperiors($order, $company, $officeProfit);

        }elseif($company['o_role']==1){
            //县区给市级代理分润
            $company =  $companyModel->getOrganizeInfo(['o_provinceid'=>$company['o_provinceid'],'o_cityid'=>$company['o_cityid']]);
            $officeProfit[] = $this->FormatProfitArray($order,$company);
            return $this->checkUpSuperiors($order, $company, $officeProfit);

        }elseif($company['o_role']==3){
            //市级代理给省级代理分润
            $company = $companyModel->getOrganizeInfo(['o_provinceid'=>$company['o_provinceid']]);
            $officeProfit[] = $this->FormatProfitArray($order,$company);
            return $officeProfit;
        }elseif($company['o_role']==2){
            //省级代理分润
            $officeProfit[] = $this->FormatProfitArray($order,$company);
            return $officeProfit;
        }else{
            return $officeProfit;
        }
    }

    public function SettleOrder($orderId){
        $orderModel = model('offlineorder');
        $ProfitModel = model('officeprofit');
        $companyModel = model('company');
        $order = $orderModel->getOneOfflineOrders($orderId);
        //2，省级代理；3，市级代理；1，县区代理；4，特约代理
        //当前公司
        $officeCompany = $companyModel->getOrganizeInfo(['o_id'=>$order['office_company_id']]);
        if (!$officeCompany) return false;
        $officeProfit =[];
        //当前公司分润
        // $officeProfit[] =$this->FormatProfitArray($order,$officeCompany);
        $officeProfit = $this->checkUpSuperiors($order,$officeCompany,$officeProfit);
        foreach ($officeProfit as $k => $v) {
            $Com = $companyModel->setValueUpdate($v['office_company_id'],'total_amount',$v['scale_price'],TRUE);
            if (!$Com) return false;
        }
        $res = $ProfitModel->allOfficeProfitAdd($officeProfit);
        if (!$res) return false;
        
        
        return TRUE;
    }




    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'index',
                'text' => '管理',
                'url' => url('Admin/Vrsorder/index')
            ),
            array(
                'name' => 'offlineorder',
                'text' => '线下订单',
                'url' => url('Admin/Vrsorder/offlineorder')
            ),
        );
        return $menu_array;
    }

}
