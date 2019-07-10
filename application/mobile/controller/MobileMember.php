<?php

namespace app\mobile\controller;

class MobileMember extends MobileHome {

    public function _initialize() {
        parent::_initialize();
        $agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($agent, "MicroMessenger") && request()->controller() == 'Wxauto') {
            $this->wxconfig = db('wxconfig')->find();
            $this->appId = $this->wxconfig['appid'];
            $this->appSecret =$this->wxconfig['appsecret'];
        } else {
            $model_mb_user_token = Model('mbusertoken');
            $key = input('post.key');
            if (empty($key)) {
                $key = input('param.key');
            }
            $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($key);
            if (empty($mb_user_token_info)) {
                output_error('请登录', array('login' => '0'));
            }
            $model_member = Model('member');
            $this->member_info = $model_member->getMemberInfoByID($mb_user_token_info['member_id']);



            if (empty($this->member_info)) {
                output_error('请登录', array('login' => '0'));
            } else {
                $this->member_info['client_type'] = $mb_user_token_info['client_type'];
                $this->member_info['openid'] = $mb_user_token_info['openid'];
                $this->member_info['token'] = $mb_user_token_info['token'];
                $level_name = $model_member->getOneMemberGrade($mb_user_token_info['member_id']);
                $this->member_info['level_name'] = $level_name['level_name'];
                //读取卖家信息
                $seller_info = Model('seller')->getSellerInfo(array('member_id' => $this->member_info['member_id']));
                $this->member_info['store_id'] = $seller_info['store_id'];
            }
        }
    }

    public function getOpenId() {
        return $this->member_info['openid'];
    }

    public function setOpenId($openId) {
        $this->member_info['openid'] = $openId;
        Model('mbusertoken')->updateMemberOpenId($this->member_info['token'], $openId);
    }
}

?>
