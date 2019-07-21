<?php

namespace app\admin\controller;

use think\Lang;
use think\Validate;
use vomont\Vomont;

class School extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/zh-cn/school.lang.php');
        Lang::load(APP_PATH . 'admin/lang/zh-cn/admin.lang.php');
        Lang::load(APP_PATH . 'admin/lang/zh-cn/look.lang.php');
        //获取当前角色对当前子目录的权限
        $class_name=explode('\\',__CLASS__);
        $class_name = strtolower(end($class_name));
        $perm_id = $this->get_permid($class_name);
        $this->action = $action = $this->get_role_perms(session('admin_gid') ,$perm_id);
        $this->assign('action',$action);
    }

    public function member() {
        if(session('admin_is_super') !=1 && !in_array(4,$this->action )){
            $this->error(lang('ds_assign_right'));
        }
        $model_school = model('School');
        $condition = array();
        $schoolname = input('param.schoolname');//学校名称
        if ($schoolname) {
            $condition['name'] = array('like', "%" . $schoolname . "%");
        }
        $school_type = input('param.school_type');//学校类型
        if ($school_type) {
            $condition['typeid'] = $school_type;
        }

        if(!empty($_GET['province'])){
            $province_id=input('param.province');
            $condition['provinceid']=$province_id;
        }
        if(!empty($_GET['city'])) {
            $city_id = input('param.city');
            $condition['cityid'] =$city_id;
        }
        if(!empty($_GET['area'])){
            $area_id = input('param.area');
            $condition['areaid'] =$area_id;
        }
        $condition['isdel'] = 1;
        $school_list = $model_school->getSchoolList($condition, 15);
        //地区信息
        $region_list = db('area')->where('area_parent_id','0')->select();
        //类型
        $model_schooltype = model('Schooltype');
        $schoolType = $model_schooltype->get_sctype_List(array('sc_enabled'=>1));
        $this->assign('region_list', $region_list);
        $this->assign('schoolType', $schoolType);
        $this->assign('page', $model_school->page_info->render());
        $this->assign('school_list', $school_list);
        $this->setAdminCurItem('member');
        return $this->fetch();
    }

    public function add() {
        if(session('admin_is_super') !=1 && !in_array(1,$this->action )){
            $this->error(lang('ds_assign_right'));
        }
        if (!request()->isPost()) {
            //地区信息
            $region_list = db('area')->where('area_parent_id','0')->select();
            //类型
            $model_schooltype = model('Schooltype');
            $schoolType = $model_schooltype->get_sctype_List(array('sc_enabled'=>1));
            $this->assign('region_list', $region_list);
            $this->assign('schoolType', $schoolType);
            $this->setAdminCurItem('add');
            return $this->fetch();
        } else {
            $admininfo = $this->getAdminInfo();
            $model_school = model('School');
            $data = array(
                'name' => input('post.school_name'),
                'provinceid' => input('post.province'),
                'cityid' => input('post.city'),
                'areaid' => input('post.area'),
                'region' => input('post.area_info'),
                'typeid' => implode(",",$_POST['school_type']),
                'address' => input('post.school_address'),
                'common_phone' => input('post.school_phone'),
                'username' => input('post.school_username'),
                'dieline' => input('post.school_dieline'),
                'desc' => input('post.school_desc'),
                'option_id' => $admininfo['admin_id'],
                'admin_company_id' => $admininfo['admin_company_id'],
                'createtime' => date('Y-m-d H:i:s',time())
            );
            $province_id = db('area')->where('area_id',input('post.province'))->find();
            if($province_id['area_shortname']){
                $uniqueCard = "";
                for($i=0;$i<strlen($province_id['area_shortname']);$i=$i+3){
                    $uniqueCard .= $model_school->getFirstCharter(substr($province_id['area_shortname'],$i,3));
                }
            }
            $number = $model_school -> getNumber($uniqueCard);
            $data['schoolCard'] = $uniqueCard.$number;
            //物盟学校添加
            $vlink = new Vomont();
            $res= $vlink->SetLogin();
            $accountid=$res['accountid'];
            $vlinker=$vlink->AddResources($accountid,$data['name'],$data['areaid']);
            $data['res_group_id']=$vlinker['groupres']['id'];
            //验证数据  END
            $result = $model_school->addSchool($data);
            if ($result) {
                $this->success(lang('school_add_succ'), 'School/member');
            } else {
                $this->error(lang('school_add_fail'));
            }
        }
    }



    public function edit() {
        if(session('admin_is_super') !=1 && !in_array(3,$this->action )){
            $this->error(lang('ds_assign_right'));
        }
        $school_id = input('param.school_id');
        if (empty($school_id)) {
            $this->error(lang('param_error'));
        }
        $model_school = Model('school');

        $condition['schoolid'] = $school_id;
        $school_array = $model_school->getSchoolInfo($condition);
        if (!request()->isPost()) {
            $school_array['typeid']=explode(',',$school_array['typeid']);
            //地区信息
            $region_list = db('area')->where('area_parent_id','0')->select();
            //类型
            $model_schooltype = model('Schooltype');
            $schoolType = $model_schooltype->get_sctype_List(array('sc_enabled'=>1));
            $this->assign('region_list', $region_list);
            $this->assign('school_array', $school_array);
            $this->assign('schoolType', $schoolType);
            $this->setAdminCurItem('edit');
            return $this->fetch();
        } else {
            $data = array(
                'name' => input('post.school_name'),
                'typeid' => implode(",",$_POST['school_type']),
                'address' => input('post.school_address'),
                'common_phone' => input('post.school_phone'),
                'username' => input('post.school_username'),
                'dieline' => input('post.school_dieline'),
                'desc' => input('post.school_desc'),
                'createtime' => date('Y-m-d H:i:s',time())
            );
            //物盟学校修改
            if($school_array['res_group_id'] == ''){
                $this->error('物盟学校不存在');
            }
            $vlink = new Vomont();
            $res= $vlink->SetLogin();
            $accountid=$res['accountid'];
            $vlinker=$vlink->ModifyResources($accountid,$data['name'],$school_array['res_group_id']);
            if($vlinker['result'] != 0){
                $this->error('修改失败，物盟学校名称修改失败');
            }
            //验证数据  END
            $result = $model_school->editSchool($data,array('schoolid'=>$school_id));
            //修改学校信息的同时 要修改班级和学生的地区
            $model_class = Model('classes');
            $data_class = array("school_provinceid"=>$data['provinceid'],"school_cityid"=>$data['cityid'],"school_areaid"=>input('post.area_id'),"school_region"=>input('post.area_info'));
            $model_class->editClass($data_class,array('schoolid'=>$school_id));
            $model_student = Model('student');
            $data_student = array("s_provinceid"=>$data['provinceid'],"s_cityid"=>$data['cityid'],"s_areaid"=>input('post.area_id'),"s_region"=>input('post.area_info'));
            $model_student->editStudent($data_student,array('s_schoolid'=>$school_id));
            if ($result) {
                $this->success('编辑成功', 'School/member');
            } else {
                $this->error('编辑失败');
            }
        }
    }

    /**
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @desc 添加房间
     *
     */
    public function addposition() {
        if(session('admin_is_super') !=1 && !in_array(10,$this->action )){
            $this->error(lang('ds_assign_right'));
        }
        $school_id = input('param.school_id');
        $model_school = model('School');
        if (empty($school_id)) {
            $this->error(lang('param_error'));
        }
        $schoolinfo = $model_school->getSchoolInfo(array('schoolid'=>$school_id));
        if (!request()->isPost()) {
            /*$schooltype = db('schooltype')->where('sc_enabled','1')->select();
            $typeids = explode(',',$schoolinfo['typeid']);
            foreach ($schooltype as $k=>$v){
                foreach ($typeids as $key=>$item){
                    if($item ==$v['sc_id']){
                        $type[$item] = $v['sc_type'];
                    }
                }
            }
            $this->assign('schooltype', $type);*/
            $this->assign('schoolid', $school_id);
            $this->setAdminCurItem('addposition');
            return $this->fetch();
        } else {
            $model_class = model('position');

            $data = array(
                'school_id' => $school_id,
//                'type_id' => input('post.school_type'),
                'position' => input('post.school_position_name'),
                'create_time'=>time()
            );
            $data['province_id'] = $schoolinfo['provinceid'];
            $data['city_id'] = $schoolinfo['cityid'];
            $data['area_id'] = $schoolinfo['areaid'];
            $data['region'] = $schoolinfo['region'];
            //物盟房间位置添加
            $vlink = new Vomont();
            $res= $vlink->SetLogin();
            $accountid=$res['accountid'];
            $vlinker=$vlink->AddResources($accountid,$data['position'],$schoolinfo['res_group_id']);
            if($vlinker['result'] != 0){
                $this->error('物盟房间位置添加失败');
            }
            $data['res_group_id']=$vlinker['groupres']['id'];
            //验证数据  END
            $result = $model_class->insertGetId($data);
            if ($result) {
                $this->success(lang('school_position_add_succ'), 'School/member');
            } else {
                $this->error(lang('school_position_add_fail'));
            }
        }
    }
    /**
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @desc 添加班级
     *
     */
    public function addclass() {
        if(session('admin_is_super') !=1 && !in_array(10,$this->action )){
            $this->error(lang('ds_assign_right'));
        }
        $school_id = input('param.school_id');
        $model_school = model('School');
        if (empty($school_id)) {
            $this->error(lang('param_error'));
        }
        $schoolinfo = $model_school->getSchoolInfo(array('schoolid'=>$school_id));
        if (!request()->isPost()) {
            $schooltype = db('schooltype')->where('sc_enabled','1')->select();
            $typeids = explode(',',$schoolinfo['typeid']);
            foreach ($schooltype as $k=>$v){
                foreach ($typeids as $key=>$item){
                    if($item ==$v['sc_id']){
                        $type[$item] = $v['sc_type'];
                    }
                }
            }
            $this->assign('schooltype', $type);
            //房间列表
            $position_list = db('position')->where(array('school_id'=>$school_id,'is_bind'=>1))->select();
            $this->assign('position_list',$position_list);
            $this->assign('schoolid', $school_id);
            $this->setAdminCurItem('addclass');
            return $this->fetch();
        } else {
            $admininfo = $this->getAdminInfo();
            $schoolInfo = db('school')->where('schoolid',$school_id)->find();
            $model_class = model('Classes');
            $grade_id = input('post.school_type');
            $position_id = input('post.position');
            if (empty($grade_id)) {
                $this->error('请选择学校类型');
            }
            if (empty($position_id)) {
                $this->error('请选择绑定房间');
            }
            $data = array(
                'schoolid' => $school_id,
                'typeid' => $grade_id,
                'position_id' => $position_id,
                'classname' => input('post.school_class_name'),
                'desc' => input('post.class_desc'),
                'option_id' => $admininfo['admin_id'],
                'admin_company_id' => $schoolInfo['admin_company_id'],
                'createtime' => date('Y-m-d H:i:s',time())
            );
            if(empty($data['typeid'])){
                $this->error('请选择学校类型');
            }
            if(empty($data['position_id'])){
                $this->error('请选择房间位置');
            }
            $schoolinfo = $model_school->find(array("schoolid"=>$school_id));
            $data['school_provinceid'] = $schoolinfo['provinceid'];
            $data['school_cityid'] = $schoolinfo['cityid'];
            $data['school_areaid'] = $schoolinfo['areaid'];
            $data['school_region'] = $schoolinfo['region'];
            //查询房间资源ID
            $position = db('position')->where(array('position_id'=>$position_id))->find();
            if(!$position){
                $this->error('房间不存在');
            }
            if(empty($position['res_group_id'])){
                $this->error('物盟资源组ID为空');
            }
            $data['res_group_id'] = $position['res_group_id'];
            //学校识别码
            $data['classCard'] = $schoolInfo['schoolCard'].($model_class -> getNumber($schoolInfo['schoolCard']));
            //生成二维码
            import('qrcode.index',EXTEND_PATH);
            $PhpQRCode = new \PhpQRCode();
            $PhpQRCode->set('pngTempDir', BASE_UPLOAD_PATH . DS . ATTACH_STORE . DS . 'class' .DS. $schoolInfo['schoolCard'].DS);
            // 生成商品二维码
            $PhpQRCode->set('date', $data['classCard']);
            $PhpQRCode->set('pngTempName', $data['classCard'] . '.png');
            $qr=$PhpQRCode->init();
            $data['qr']='/home/store/class/'.$schoolInfo['schoolCard'].'/'.$qr;
            //验证数据  END
            $result = $model_class->addClasses($data);
            if ($result) {
                //修改房间位置状态
                db('position')->where(array('position_id'=>$position_id))->update(array('is_bind'=>2));
                $this->success(lang('school_class_add_succ'), 'School/member');
            } else {
                $this->error(lang('school_class_add_fail'));
            }
        }
    }
    /**
     * ajax操作
     */
    public function ajax() {
        $branch = input('param.branch');

        switch ($branch) {
            //管理人员名称验证
            case 'check_admin_name':
                $model_admin = Model('admin');
                $condition['admin_name'] = input('get.admin_name');
                $condition['admin_del_status']=1;
                $list = $model_admin->where($condition)->find();
                if (!empty($list)) {
                    exit('false');
                } else {
                    exit('true');
                }
                break;
            /**
             * 验证学校名是否重复
             */
            case 'check_user_name':
                $school_member = Model('school');
                $condition['name'] = input('param.school_name');
                $condition['areaid'] = array('eq', intval(input('get.area_id')));
                $condition['isdel'] = 1;
                $list = $school_member->getSchoolInfo($condition);
                if (empty($list)) {
                    echo 'true';
                    exit;
                } else {
                    echo 'false';
                    exit;
                }
                break;
            /**
             * 验证班级名是否重复
             */
            case 'check_class_name':
                $class_member = Model('classes');
                $condition['classname'] = input('param.class_name');
                $condition['schoolid'] = input('param.school_id');
                $condition['isdel'] = 1;
                $list = $class_member->getClassInfo($condition);
                if (empty($list)) {
                    echo 'true';
                    exit;
                } else {
                    echo 'false';
                    exit;
                }
                break;
            /**
             * 验证班级名是否重复
             */
            case 'check_position_name':
                $class_member = Model('position');
                $condition['position'] = input('param.position');
                $condition['school_id'] = input('param.school_id');
                $condition['type_id'] = input('param.school_type');
                $list = $class_member->where($condition)->find();
                if (empty($list)) {
                    echo 'true';
                    exit;
                } else {
                    echo 'false';
                    exit;
                }
                break;
        }
    }

    /**
     * 重要提示，删除
     */
    public function drop() {
        if(session('admin_is_super') !=1 && !in_array(2,$this->action )){
            $this->error(lang('ds_assign_right'));
        }
        $school_id = input('param.school_id');
        if (empty($school_id)) {
            $this->error(lang('param_error'));
        }
        $classes = db('class')->where(['schoolid'=>$school_id,'isdel'=>1])->limit(1)->find();
        if($classes){
            $this->error('该学校下存在正在使用的班级，不能删除，请将使用的班级移除后进行删除');
        }
        $model_school = Model('school');
        $result = $model_school->editSchool(array('isdel'=>2),array('schoolid'=>$school_id));
        if ($result) {
            $this->success(lang('ds_common_del_succ'), 'School/member');
        } else {
            $this->error('删除失败');
        }
    }
    /**
     * 学校管理员添加
     */
    public function admin_add() {
        if(session('admin_is_super') !=1 && !in_array(6,$this->action )){
            $this->error(lang('ds_assign_right'));
        }
        $admin_id = $this->admin_info['admin_id'];
        $model_admin = Model('admin');
        $param['admin_name'] = $_POST['admin_name'];
        $param['admin_school_id'] = $_POST['role'];
        $param['admin_company_id'] = $_POST['admin_company_id'];
        $param['admin_gid'] = 5;
        $param['admin_password'] = md5($_POST['admin_password']);
        $param['create_uid'] = $admin_id;
        $param['admin_status'] = 1;
        $rs = $model_admin->addAdmin($param);
        if ($rs) {
            $this->log(lang('ds_add').lang('limit_admin') . '[' . $_POST['admin_name'] . ']', 1);
            echo json_encode(['m'=>true,'ms'=>lang('co_organize_succ')]);
        } else {
            echo json_encode(['m'=>true,'ms'=>lang('co_organize_succ')]);
        }

    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'member',
                'text' => '管理',
                'url' => url('Admin/School/member')
            ),
        );
        if(session('admin_is_super') ==1 || in_array(1,$this->action )){
            if (request()->action() == 'add' || request()->action() == 'member') {
                $menu_array[] = array(
                    'name' => 'add',
                    'text' => '添加学校',
                    'url' => url('Admin/School/add')
                );
            }
        }
        if (request()->action() == 'edit') {
            $school_id= trim($_GET['school_id']);
            $menu_array[] = array(
                'name' => 'edit',
                'text' => '编辑',
                'url' => url('Admin/School/edit',array('school_id'=>$school_id))
            );
        }
        if (request()->action() == 'addclass') {
            $school_id= trim($_GET['school_id']);
            $menu_array[] = array(
                'name' => 'addclass',
                'text' => '添加班级',
                'url' => url('Admin/School/addclass',array('school_id'=>$school_id))
            );
        }
        if (request()->action() == 'addposition') {
            $school_id= trim($_GET['school_id']);
            $menu_array[] = array(
                'name' => 'addposition',
                'text' => '添加房间位置',
                'url' => url('Admin/School/addposition',array('school_id'=>$school_id))
            );
        }
        return $menu_array;
    }

}

?>
