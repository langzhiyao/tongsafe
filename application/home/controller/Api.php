<?php

namespace app\home\controller;


class Api
{
    /*QQ登录*/
    public function oa_qq()
    {
        if (input('param.step') == 'callback') {
            include APP_PATH.'mobile/api/qq/oauth/qq_callback.php';
        }else{
            include APP_PATH.'mobile/api/qq/oauth/qq_login.php';
        }
    }
    /*sina Login*/
    public function oa_sina(){
        if (input('param.step') == 'callback'){
            include APP_PATH.'mobile/api/sina/callback.php';
        }else{
            include APP_PATH.'mobile/api/sina/index.php';
        }
    }


}


