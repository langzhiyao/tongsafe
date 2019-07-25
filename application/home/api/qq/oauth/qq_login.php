<?php
require_once(APP_PATH.DS.'mobile'.DS.'api'.DS.'qq'.DS.'comm'.DS."config.php");


function qq_login($appid, $scope, $callback)
{
    session('state',md5(uniqid(rand(), TRUE))); //CSRF protection
    $login_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" 
        . $appid . "&redirect_uri=" . urlencode($callback)
        . "&state=" . session('state')
        . "&scope=".$scope;
    //halt($login_url);
    header("Location:$login_url");
    exit;
}

//用户点击qq登录按钮调用此函数

qq_login(session("appid"), session("scope"), session("callback"));
?>
