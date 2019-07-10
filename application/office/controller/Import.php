<?php

namespace app\office\controller;

use think\Lang;
use vomont\Vomont;

class Import extends AdminControl
{

    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'office/lang/zh-cn/student.lang.php');
        //获取当前角色对当前子目录的权限
        $class_name=explode('\\',__CLASS__);
        $class_name = strtolower(end($class_name));
        $perm_id = $this->get_permid($class_name);
        $this->action = $action = $this->get_role_perms(session('office_gid') ,$perm_id);
        $this->assign('action',$action);
        //获取省份
        $province = db('area')->field('area_id,area_parent_id,area_name')->where('area_parent_id=0')->select();
        //获取学校
        $school = db('school')->field('schoolid,name')->where('isdel=1')->select();
        $this->assign('school',$school);
        $this->assign('province',$province);
    }

    /**
     * @desc 导入失败
     * @author 郎志耀
     * @time 20180926
     */
    public function index(){
        if(session('admin_is_super') !=1 && !in_array('4',$this->action)){
            $this->error(lang('ds_assign_right'));
        }
        if(!empty(input('school'))){
            $where['o.school_id'] = intval(input('school'));
        }
        if(!empty($_GET['status'])){
            $where['o.status'] = intval(input('status'));
        }
        $model_order = model('offlineorder');
        $list = $model_order->getOfflineOrderlList($where, 10);
        //查询绑定总数
        $this->assign('list',$list);
        $this->assign('page', $model_order->page_info->render());
        $this->setAdminCurItem('index');
        return $this->fetch();
    }   

    /**
     * 续传付款凭证
     * @Author 老王
     * @创建时间   2019-06-26
     * @return [type]     [description]
     */
    public function renewalVoucher(){
        $fileid = intval(input('post.id'));
        $pics = explode(',',str_replace("\\", '/',trim(input('param.pics'),',')));
        //增加上传记录
        $offlineOrderModel = model('offlineorder');

        $offlineSave = $offlineOrderModel->SetOfflineOrders(['id'=>$fileid],'voucherfile',implode(',', $pics));
        if ($offlineSave) {
            exit(json_encode(array('code' => 1, 'msg' => '续传成功！')));
        }else {
            exit(json_encode(array('code' => 0, 'msg' => '续传失败！')));
        }
    }

    public function getVoucherImg(){
        $fileid = intval(input('post.id'));
        //增加上传记录
        $offlineOrderModel = model('offlineorder');
        $offlineSave = $offlineOrderModel->getOneOfflineOrders($fileid);
        $img = explode(',', $offlineSave['voucherfile']); // 凭证图片
        exit(json_encode(['res'=>$img]));

    }

    public function delExcel(){
        $fileid = intval(input('post.id'));
        $orderModel = model('offlineorder');
        $cacheModel = model('offlinecache');
        $order = $orderModel->getOneOfflineOrders($fileid);
        $img = explode(',', $order['voucherfile']); // 凭证图片
        $file = $order['updatefile'];// Excel文档
        $cacheModel->delOfflineCache(['import_id'=>$fileid]);
        if ($orderModel->delOfflineOrders(['id'=>$fileid])) {
            foreach ($img as $key => $i) {
                unlink(ROOT_PATH.'/public'.$i);
            }
            unlink(ROOT_PATH.'/public'.$file);
            exit(json_encode(array('code'=>0,'msg'=>'删除完成！')));    
        }else{
            exit(json_encode(array('code'=>1,'msg'=>'删除失败，请重试！')));    
        }
        

    }

    /**
     * @desc 导入成功
     * @author 郎志耀
     * @time 20180926
     */
    public function successin(){

        if(session('admin_is_super') !=1 && !in_array('4',$this->action)){
            $this->error(lang('ds_assign_right'));
        }
        $where = ' status=1 ';
        if(!empty($_GET)){
            if(!empty($_GET['name'])){
                $where .= ' AND (m_name LIKE "%'.trim($_GET["name"]).'%" OR s_name LIKE "%'.trim($_GET["name"]).'%")';
            }
            if(!empty($_GET['province'])){
                $where .= ' AND province_id = "'.intval($_GET["province"]).'"';
            }
            if(!empty($_GET['city'])){
                $where .= ' AND city_id = "'.intval($_GET["city"]).'"';
            }
            if(!empty($_GET['area'])){
                $where .= ' AND area_id = "'.intval($_GET["area"]).'"';
            }
            if(!empty($_GET['school'])){
                $where .= ' AND school_id = "'.intval($_GET["school"]).'"';
            }
            if(!empty($_GET['grade'])){
                $where .= ' AND sc_id = "'.intval($_GET["grade"]).'"';
            }
            if(!empty($_GET['class'])){
                $where .= ' AND classid = "'.intval($_GET["class"]).'"';
            }
        }
        //查询绑定总数
        $list_count = db('import_student')->where($where)->count();
        $this->assign('list_count',$list_count);
        $this->setAdminCurItem('successin');
        return $this->fetch('success');
    }
    


    /**
     * @desc 确认导入excel表和学校
     * @author langzhiyao
     * @time 20180926
     */
    public function download(){
        if(session('admin_is_super') !=1 && !in_array('8',$this->action)){
            $this->error(lang('ds_assign_right'));
        }
        $this->setAdminCurItem('camera');
        return $this->fetch('download');
    }

    /**
     * @desc 再次确认插入数据表的内容
     * @author langzhiyao
     * @time 20180926
     */
    public function excelTrue(){
        if(session('admin_is_super') !=1 && !in_array('8',$this->action)){
            $this->error(lang('ds_assign_right'));
        }

        $this->setAdminCurItem('camera');
        return $this->fetch('excelTrue');
    }




    /**
     * @desc 摄像头 已录入管理
     * @author 郎志耀
     * @time 20180926
     */
    public function edit(){
        if(session('admin_is_super') !=1 && !in_array('3',$this->action)){
            $this->error(lang('ds_assign_right'));
        }
        $id = input('get.id');
        $import = db('import_student')->where('id="'.$id.'"')->find();

        //学校
        $school_student = db('school')->field('schoolid,name')->where('isdel=1')->select();

        $this->assign('school',$school_student);
        $this->assign('import',$import);
        $this->setAdminCurItem('edit');
        return $this->fetch('edit');
    }





    /**
     * @desc 摄像头 已录入管理
     * @author 郎志耀
     * @time 20180926
     */
    public function editSuccess(){
        if(session('admin_is_super') !=1 && !in_array('3',$this->action)){
            $this->error(lang('ds_assign_right'));
        }
        $id = input('get.id');
        $import = db('import_student')->where('id="'.$id.'"')->find();

        //学校
        $school_student = db('school')->field('schoolid,name')->where('isdel=1')->select();

        $this->assign('school',$school_student);
        $this->assign('import',$import);
        $this->setAdminCurItem('editSuccess');
        return $this->fetch('editSuccess');
    }


    /**
     * @desc 根据ID 获取地址名称
     * @author langzhiyao
     * @time 20180928
     */
    function get_address_name($id){

        $address_info = db('area')->field('area_id,area_name')->where('area_id= '.$id.'')->find();

        return $address_info['area_name'];

    }


    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'index',
                'text' => '线下订单管理',
                'url' => url('Office/import/index')
            ),
            // array(
            //     'name' => 'successin',
            //     'text' => '导入成功列表',
            //     'url' => url('Office/import/successin')
            // )
        );
        return $menu_array;
    }


}