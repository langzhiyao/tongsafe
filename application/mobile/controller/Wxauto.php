<?php
/**
 * 微信相关接口
 */

namespace app\mobile\controller;


class Wxauto extends MobileMember
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
    }

    public function login()
    {
        $redirect_uri = MOBILE_SITE_URL . "/Wxauto/checkAuth?ref=" . $_GET['ref'];
        $code_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$this->appId&redirect_uri=" . urlencode($redirect_uri) . "&response_type=code&scope=snsapi_base&state=123#wechat_redirect"; // 获取code
        if (cookie('key') && cookie('new_cookie')) {
            //已经登陆
            $ref = WAP_SITE_URL;
            $model_mb_user_token = Model('mbusertoken');
            $model_member = Model('member');
            $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken(cookie('key'));
            $member_info = $model_member->getMemberInfoByID($mb_user_token_info['member_id']);
            if (empty($member_info)) {
                cookie('username', null);
                cookie('key', null);
                cookie('unionid', null);
                cookie('new_cookie', null);
                $this->redirect($code_url);
            }
            $this->redirect($ref);
        }
        else {
            $this->redirect($code_url);
        }

    }


    public function checkAuth()
    {
        $ref = $_GET['ref'];
        if (empty($ref)) {
            $ref = WAP_SITE_URL;
        }
        if (isset($_GET['code'])) {
            $this->code = $_GET['code'];
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$this->appId&secret=$this->appSecret&code=$this->code&grant_type=authorization_code";
            $res = json_decode($this->httpGet($url), true);
            $this->openid = $res['openid'];

            session('openid', $res['openid']);
            $accessToken5 = $this->getAccessToken();
            $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$accessToken5&openid=" . $res['openid'] . "&lang=zh_CN";    //获取用户信息
            $res5 = json_decode($this->httpGet($url), true);
            if (isset($res5['errcode'])) {
                $this->redirect(WAP_SITE_URL);
            }
            if (empty($res5['unionid'])) {
                $res5['unionid'] = $res5['openid'];
            }

            $model_member = Model('member');
            $member_info = $model_member->getMemberInfo(array('weixin_unionid' => $res5['unionid']));

            if (!empty($member_info)) {
                //更新信息
                if ($res5['subscribe'] && !empty($res5['nickname']) && $res5['nickname'] != $member_info['member_name']) {
                    $model_member->editMember(array('weixin_unionid' => $res5['unionid']), array('member_name' => $res5['nickname']));
                }
                $token = $this->_get_token($member_info['member_id'], $member_info['member_name'], 'wap');
                cookie('username', $member_info["member_name"], time() + 3600 * 24, '/');
                cookie('key', $token, time() + 3600 * 24, '/');
                //cookie('unionid',$token,time()+3600*24,'/');
                cookie('new_cookie', '100', time() + 3600 * 24, '/');
                $this->redirect($ref);
            }
            else {
                //注册会员信息
                if ($this->register($res5)) {
                    $this->redirect($ref);
                }
                else {
                    $this->redirect(WAP_SITE_URL);
                }
            }

        }
        else {
            $this->redirect($ref);
        }
    }

    private function register($user_info)
    {
        $unionid = $user_info['unionid'];
        $nickname = $user_info['nickname'];
        if (!empty($unionid)) {
            $rand = rand(100, 899);
            if (empty($nickname))
                $nickname = 'name_' . $rand;
            if (strlen($nickname) < 3)
                $nickname = $nickname . $rand;
            $member_name = $nickname;
            $model_member = Model('member');
            $member_info = $model_member->getMemberInfo(array('member_name' => $member_name));
            $password = rand(100000, 999999);
            $member = array();
            $member['member_password'] = $password;
            $member['member_email'] = '';
            $member['weixin_unionid'] = $unionid;
            $member['member_wxopenid'] = $user_info['openid'];

            $weixin_info = array();
            $weixin_info['unionid'] = $user_info['unionid'];
            $weixin_info['nickname'] = $user_info['nickname'];
            $weixin_info['openid'] = $user_info['openid'];
            $member['weixin_info'] = serialize($weixin_info);

            if (empty($member_info)) {
                $member['member_name'] = $member_name;
                $result = $model_member->addMember($member);
            }
            else {
                for ($i = 1; $i < 999; $i++) {
                    $rand += $i;
                    $member_name = $nickname . $rand;
                    $member_info = $model_member->getMemberInfo(array('member_name' => $member_name));
                    if (empty($member_info)) {//查询为空表示当前会员名可用
                        $member['member_name'] = $member_name;
                        $result = $model_member->addMember($member);
                        break;
                    }
                }
            }
            $headimgurl = $user_info['headimgurl'];//用户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表640*640正方形头像）
            $headimgurl = substr($headimgurl, 0, -1) . '132';
            $avatar = @copy($headimgurl, BASE_UPLOAD_PATH . '/' . ATTACH_AVATAR . "/avatar_$result.jpg");
            if ($avatar) {
                $model_member->editMember(array('member_id' => $result), array('member_avatar' => "avatar_$result.jpg"));
            }
            $member = $model_member->getMemberInfo(array('member_name' => $member_name));
            if (!empty($member)) {
                if (!empty($member_info)) {
                    //$unionid = $member_info['unionid'];
                    $token = $this->_get_token($result, $member_name, 'wap');
                    cookie('username', $member_name);
                    cookie('key', $token);
                    return true;
                }
                else {
                    return false;
                }
            }
        }
    }


    /**
     * 登录生成token
     */
    private function _get_token($member_id, $member_name, $client)
    {
        $model_mb_user_token = Model('mbusertoken');
        //生成新的token
        $mb_user_token_info = array();
        $token = md5($member_name . strval(TIMESTAMP) . strval(rand(0, 999999)));
        $mb_user_token_info['member_id'] = $member_id;
        $mb_user_token_info['member_name'] = $member_name;
        $mb_user_token_info['token'] = $token;
        $mb_user_token_info['login_time'] = TIMESTAMP;
        $mb_user_token_info['client_type'] = $client;

        $result = $model_mb_user_token->addMbUserToken($mb_user_token_info);
        if ($result) {
            return $token;
        }
        else {
            return null;
        }

    }


    //校验AccessToken 是否可用及返回新的
    private function getAccessToken()
    {
        //token过期，重新拉去
        if ($this->wxconfig['expires_in'] < time()) {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
            $res = json_decode($this->httpGet($url));
            $access_token = $res->access_token;
            if ($access_token) {
                $expire_time = time() + 7000;
                db('wxconfig')->where(array('id' => $this->wxconfig['id']))->update(array(
                                                                                        'access_token' => $access_token,
                                                                                        'expires_in' => $expire_time
                                                                                    ));
            }
        }
        else {
            $access_token = $this->wxconfig['access_token'];
        }
        return $access_token;
    }
}