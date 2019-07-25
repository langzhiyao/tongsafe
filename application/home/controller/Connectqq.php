<?php

namespace app\home\controller;


use think\Lang;

class Connectqq extends BaseMall
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        Lang::load(APP_PATH . 'mobile/lang/zh-cn/connectqq.lang.php');
        Lang::load(APP_PATH . 'mobile/lang/zh-cn/login-register.lang.php');
        /**
         * 判断qq互联功能是否开启
         */
        if (config('qq_isuse') != 1) {
            $this->error(lang('home_qqconnect_unavailable'));//'系统未开启QQ互联功能'
        }
        /**
         * 初始化测试数据
         */
        if (!session('openid')) {
            showMessage(lang('home_qqconnect_error'));//'系统错误'
        }
       $this->assign('hidden_nctoolbar', 1);
        //Tpl::setLayout('login_layout');
    }

    /**
     * 首页
     */
    public function index()
    {
        /**
         * 检查登录状态
         */
        if (session('is_login') == '1') {
            //qq绑定
            $this->bindqq();
        }
        else {
            $this->autologin();
            $this->register();
        }
    }

    private function checkWapQQlogin()
    {
        if ((session('m'))) {
            return true;
        }
        return false;
    }

    /**
     * qq绑定新用户
     */
    public function register()
    {
        //实例化模型
        $model_member = Model('member');
        if (request()->isPost()) {
            $update_info = array();
            $update_info['member_password'] = md5(trim($_POST["password"]));
            if (!empty($_POST["email"])) {
                $update_info['member_email'] = $_POST["email"];
                session('member_email', $_POST["email"]);
            }
            $model_member->editMember(array('member_id' => session('member_id')), $update_info);
            $this->error(lang('ds_common_save_succ'), SHOP_SITE_URL);
        }
        else {
            //检查登录状态
            $model_member->checkloginMember();
            //获取qq账号信息
            require_once(APP_PATH . 'mobile/api/qq/user/get_user_info.php');
            $qquser_info = get_user_info();
           $this->assign('qquser_info', $qquser_info);

            //处理qq账号信息
            $qquser_info['nickname'] = trim($qquser_info['nickname']);
            $user_passwd = rand(100000, 999999);
            /**
             * 会员添加
             */
            $user_array = array();
            $user_array['member_name'] = $qquser_info['nickname'];
            $user_array['member_password'] = $user_passwd;
            $user_array['member_email'] = '';
            $user_array['member_qqopenid'] = session('openid');//qq openid
            $user_array['member_qqinfo'] = serialize($qquser_info);//qq 信息
            $rand = rand(100, 899);
            if (strlen($user_array['member_name']) < 3)
                $user_array['member_name'] = $qquser_info['nickname'] . $rand;
            $check_member_name = $model_member->getMemberInfo(array('member_name' => trim($user_array['member_name'])));
            $result = 0;
            if (empty($check_member_name)) {
                $result = $model_member->addMember($user_array);
            }
            else {
                for ($i = 1; $i < 999; $i++) {
                    $rand += $i;
                    $user_array['member_name'] = trim($qquser_info['nickname']) . $rand;
                    $check_member_name = $model_member->getMemberInfo(array('member_name' => trim($user_array['member_name'])));
                    if (empty($check_member_name)) {
                        $result = $model_member->addMember($user_array);
                        break;
                    }
                }
            }
            if ($result) {
               $this->assign('user_passwd', $user_passwd);
                //v3-b12 修复 QQ登录头像
                $avatar = @copy($qquser_info['figureurl_qq_2'], BASE_UPLOAD_PATH. '/' . ATTACH_AVATAR . "/avatar_$result.jpg");

                $update_info = array();
                if ($avatar) {
                    $update_info['member_avatar'] = "avatar_$result.jpg";
                    $model_member->editMember(array('member_id' => $result), $update_info);
                }
                $member_info = $model_member->getMemberInfo(array('member_name' => $user_array['member_name']));
                $model_member->createSession($member_info, true);
                if ($this->checkWapQQlogin()) {
                    @header('location: ' . MOBILE_SITE_URL . '/index.php/login/qq');
                    exit;
                }
                else {
                    echo $this->fetch($this->template_dir.'connect_register');
                }
            }
            else {
                $this->error(lang('login_usersave_regist_fail'), 'login/register');//"会员注册失败"
            }
        }
    }

    /**
     * 已有用户绑定QQ
     */
    public function bindqq()
    {
        $model_member = Model('member');
        //验证QQ账号用户是否已经存在
        $array = array();
        $array['member_qqopenid'] = session('openid');
        $member_info = $model_member->getMemberInfo($array);
        if (is_array($member_info) && count($member_info) > 0) {
            session('openid',null);
            $this->error(lang('home_qqconnect_binding_exist'), 'memberconnect/qqbind');//'该QQ账号已经绑定其他商城账号,请使用其他QQ账号与本账号绑定'
        }
        //获取qq账号信息
        require_once(APP_PATH . 'mobile/api/qq/user/get_user_info.php');
        $qquser_info = get_user_info();
        $edit_state = $model_member->editMember(array('member_id' => session('member_id')), array(
            'member_qqopenid' => session('openid'), 'member_qqinfo' => serialize($qquser_info)
        ));
        if ($edit_state) {
           $this->success(lang('home_qqconnect_binding_success'), 'memberconnect/qqbind');
        }
        else {
            $this->error(lang('home_qqconnect_binding_fail'), 'memberconnect/qqbind');//'绑定QQ失败'
        }
    }

    /**
     * 绑定qq后自动登录
     */
    public function autologin()
    {
        //查询是否已经绑定该qq,已经绑定则直接跳转
        $model_member = Model('member');
        $array = array();
        $array['member_qqopenid'] = session('openid');
        $member_info = $model_member->getMemberInfo($array);
        if (is_array($member_info) && count($member_info) > 0) {
            if (!$member_info['member_state']) {//1为启用 0 为禁用
                $this->error(lang('ds_notallowed_login'));
            }
            $model_member->createSession($member_info);
            if ($this->checkWapQQlogin()) {
                @header('location: ' . MOBILE_SITE_URL . '/login/type/qq');
                exit;
            }
            else {
                $success_message = lang('login_index_login_success');
                $this->success($success_message, SHOP_SITE_URL);
            }
        }
    }

    /**
     * 更换绑定QQ号码
     */
    public function changeqq()
    {
        //如果用户已经登录，进入此链接则显示错误
        if (session('is_login') == '1') {
            $this->error(lang('home_qqconnect_error'), 'index/index');//'系统错误'
        }
        session('openid',null);
        @header('Location:' . SHOP_SITE_URL . '/api/toqq');
        exit;
    }
}