<?php
session_start();
//判断是否已经登录
if(!empty($_COOKIE['key'])){
	header("Location:".WAP_SITE_URL);
	exit;	
}
include_once(BASE_PATH.DS.'api'.DS.'sina'.DS.'config.php');
include_once(BASE_PATH.DS.'api'.DS.'sina'.DS.'saetv2.ex.class.php' );
$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY);
///////////code需要传递////////////
if (isset($_REQUEST['code'])) {
	$keys = array();
	$keys['code'] = $_REQUEST['code'];
	$keys['redirect_uri'] = WB_CALLBACK_URL;
	try {
		$token = $o->getAccessToken( 'code', $keys ) ;
	} catch (OAuthException $e) {
	}
}

if ($token) {
	$_SESSION['slast_key'] = $token;
	setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
	//转到注册登录页面

	@header('location: ' . MOBILE_SITE_URL . '/index.php/connect_sina/index');
	exit;
} else { echo "授权失败。"; }
