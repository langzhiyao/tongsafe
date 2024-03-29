<?php 
require_once(APP_PATH.DS.'mobile'.DS.'api'.DS.'qq'.DS.'comm'.DS."config.php");
require_once(APP_PATH.DS.'mobile'.DS.'api'.DS.'qq'.DS.'comm'.DS."utils.php");
function qq_callback()
{
    if(input('param.state') == session('state')) //csrf
    {
        $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
            . "client_id=" . session("appid"). "&redirect_uri=" . urlencode(session("callback"))
            . "&client_secret=" . session("appkey"). "&code=" . input("code");

        $response = get_url_contents($token_url);
        if (strpos($response, "callback") !== false)
        {
            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
            $msg = json_decode($response);
            if (isset($msg->error))
            {
                echo "<h3>error:</h3>" . $msg->error;
                echo "<h3>msg  :</h3>" . $msg->error_description;
                exit;
            }
        }

        $params = array();
        parse_str($response, $params);

        //set access token to session
        session("access_token",$params["access_token"]);

    }
    else 
    {
        echo("The state does not match. You may be a victim of CSRF.");
    }
}

function get_openid()
{
    $graph_url = "https://graph.qq.com/oauth2.0/me?access_token=" 
        . session('access_token');

    $str  = get_url_contents($graph_url);
    if (strpos($str, "callback") !== false)
    {
        $lpos = strpos($str, "(");
        $rpos = strrpos($str, ")");
        $str  = substr($str, $lpos + 1, $rpos - $lpos -1);
    }

    $user = json_decode($str);
    if (isset($user->error))
    {
        echo "<h3>error:</h3>" . $user->error;
        echo "<h3>msg  :</h3>" . $user->error_description;
        exit;
    }

    //set openid to session
    session('openid',$user->openid);
}

//QQ登录成功后的回调地址,主要保存access token

qq_callback();

//获取用户标示id
get_openid();

@header('location: '.SHOP_SITE_URL.'/Connectqq');
exit;
?>
