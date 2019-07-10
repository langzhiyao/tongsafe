<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:73:"/home/www/chenganxjh/public/../application/admin/view/mbpayment/edit.html";i:1558338271;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>想见孩系统后台</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="<?php echo \think\Config::get('url_domain_root'); ?>static/admin/css/admin.css">
        <link rel="stylesheet" href="<?php echo \think\Config::get('url_domain_root'); ?>static/plugins/js/jquery-ui/jquery-ui.min.css">
        <script src="<?php echo \think\Config::get('url_domain_root'); ?>static/plugins/jquery-2.1.4.min.js"></script>
        <script src="<?php echo \think\Config::get('url_domain_root'); ?>static/plugins/jquery.validate.min.js"></script>
        <script src="<?php echo \think\Config::get('url_domain_root'); ?>static/plugins/jquery.cookie.js"></script>
        <script src="<?php echo \think\Config::get('url_domain_root'); ?>static/admin/js/admin.js"></script>
        <script src="<?php echo \think\Config::get('url_domain_root'); ?>static/plugins/js/jquery-ui/jquery-ui.min.js"></script>

        <script src="<?php echo \think\Config::get('url_domain_root'); ?>static/plugins/layer/layui.all.js"></script>
        <script src="<?php echo \think\Config::get('url_domain_root'); ?>static/plugins/layer/layui.js"></script>
        <script src="<?php echo \think\Config::get('url_domain_root'); ?>static/plugins/layer/layer.js"></script>
        <link rel="stylesheet" href="<?php echo \think\Config::get('url_domain_root'); ?>static/plugins/font-awesome/css/font-awesome.min.css">
        <script type="text/javascript">
            var SITE_URL = "<?php echo \think\Config::get('url_domain_root'); ?>";
            var ADMIN_URL = "<?php echo \think\Config::get('url_domain_root'); ?>index.php/Admin/";
        </script>
    </head>
    <body>
        
    

        


<div id="append_parent"></div>
<div id="ajaxwaitid"></div>

<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>手机支付</h3>
                <h5></h5>
            </div>
            <?php if($admin_item): ?>
<ul class="tab-base ds-row">
    <?php if(is_array($admin_item) || $admin_item instanceof \think\Collection || $admin_item instanceof \think\Paginator): if( count($admin_item)==0 ) : echo "" ;else: foreach($admin_item as $key=>$item): ?>
    <li><a href="<?php echo $item['url']; ?>" <?php if($item['name'] == $curitem): ?>class="current"<?php endif; ?>><span><?php echo $item['text']; ?></span></a></li>
    <?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
<?php endif; ?>
        </div>
    </div>

    <div class="fixed-empty"></div>
    <form id="post_form" method="post" name="form1" action="<?php echo url('mbpayment/payment_save'); ?>">
        <input type="hidden" name="payment_id" value="<?php echo $payment['payment_id']; ?>" />
        <input type="hidden" name="payment_code" value="<?php echo $payment['payment_code']; ?>" />
        <table class="ds-default-table nobdb">
            <tbody>
            <tr class="noborder">
                <td class="vatop rowform"><?php echo $payment['payment_name']; ?></td>
                <td class="vatop tips"></td>
            </tr>
            <?php if($payment['payment_code'] == 'alipay'): ?>
            <tr>
                <td colspan="2" class="required"><label class="validation">支付宝AppId:</label></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform"><input name="alipay_appid" id="alipay_appid" value="<?php echo $payment['payment_config']['alipay_appid']; ?>" class="txt" type="text"></td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2" class="required"><label class="validation">商户公钥（alipay_public_key）:</label></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform">
                    <textarea name="public_key" id="public_key"><?php echo $payment['payment_config']['public_key']; ?></textarea>
                </td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2" class="required"><label class="validation">商户私钥（alipay_private_key）:</label></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform">
                    <textarea name="private_key" id="private_key"><?php echo $payment['payment_config']['private_key']; ?></textarea>
                </td>
                <td class="vatop tips"></td>
            </tr>
           <?php endif; if($payment['payment_code'] == 'alipay_app'): ?>
            <tr>
                <td colspan="2" class="required"><label class="validation">支付宝AppId:</label></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform"><input name="app_alipay_appid" id="app_alipay_appid" value="<?php echo $payment['payment_config']['app_alipay_appid']; ?>" class="txt" type="text"></td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2" class="required"><label class="validation">商户公钥（alipay_public_key）:</label></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform">
                    <textarea name="app_public_key" id="app_public_key"><?php echo $payment['payment_config']['app_public_key']; ?></textarea>
                </td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2" class="required"><label class="validation">商户私钥（alipay_private_key）:</label></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform">
                    <textarea name="app_private_key" id="app_private_key"><?php echo $payment['payment_config']['app_private_key']; ?></textarea>
                </td>
                <td class="vatop tips"></td>
            </tr>
           <?php endif; if($payment['payment_code'] == 'wxpay_app'): ?>
            <tr>
                <td colspan="2" class="required"><label class="validation">APP唯一凭证(appid):</label> </td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform"><input name="wxpay_appid" id="wxpay_appid" value="<?php echo $payment['payment_config']['wxpay_appid']; ?>" class="txt" type="text"></td>
                <td class="vatop tips">APP唯一凭证，需要到微信开放平台进行申请</td>
            </tr>
            <tr>
                <td colspan="2" class="required"><label class="validation">商户号（mch_id）: </label></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform"><input name="wxpay_partnerid" id="wxpay_partnerid" value="<?php echo $payment['payment_config']['wxpay_partnerid']; ?>" class="txt" type="text"></td>
                <td class="vatop tips"></td>
            </tr>

            <tr>
                <td colspan="2" class="required"><label class="validation">商户密钥(APIKEY/partnerkey): </label></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform"><input name="wxpay_partnerkey" id="wxpay_partnerkey" value="<?php echo $payment['payment_config']['wxpay_partnerkey']; ?>" class="txt" type="text"></td>
                <td class="vatop tips">到微信商户平台(账户设置-安全设置-API安全)进行设置</td>
            </tr>
            <?php endif; if($payment['payment_code'] == 'wxpay_jsapi'): ?>
            <tr>
                <td colspan="2" class="required"><label class="validation">APP唯一凭证(appid):</label></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform"> <input name="appId" id="appId" value="<?php echo $payment['payment_config']['appId']; ?>" class="txt" type="text"></td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2" class="required"><label class="validation">应用密钥(appsecret): </label></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform"><input name="appSecret" id="appSecret" value="<?php echo $payment['payment_config']['appSecret']; ?>" class="txt" type="text"></td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2" class="required"><label class="validation">微信支付商户号(partner ID): </label></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform"><input name="partnerId" id="partnerId" value="<?php echo $payment['payment_config']['partnerId']; ?>" class="txt" type="text"></td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2" class="required"><label class="validation">API密钥: </label></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform"><input name="apiKey" id="apiKey" value="<?php echo $payment['payment_config']['apiKey']; ?>" class="txt" type="text"></td>
                <td class="vatop tips"></td>
            </tr>
           <?php endif; ?>
            <tr>
                <td colspan="2" class="required">启用: </td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform onoff"><label for="payment_state1" class="cb-enable <?php if($payment['payment_state'] == '1'): ?>selected<?php endif; ?>" ><span><?php echo \think\Lang::get('ds_yes'); ?></span></label>
                    <label for="payment_state2" class="cb-disable <?php if($payment['payment_state'] == '0'): ?>selected<?php endif; ?>" ><span><?php echo \think\Lang::get('ds_no'); ?></span></label>
                    <input type="radio" <?php if($payment['payment_state'] == '1'): ?>checked="checked"<?php endif; ?> value="1" name="payment_state" id="payment_state1">
                    <input type="radio" <?php if($payment['payment_state'] == '0'): ?>checked="checked"<?php endif; ?> value="0" name="payment_state" id="payment_state2"></td>
                <td class="vatop tips"></td>
            </tr>
            </tbody>
            <tfoot>
            <tr class="tfoot">
                <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="btn_submit" ><span><?php echo \think\Lang::get('ds_submit'); ?></span></a></td>
            </tr>
            </tfoot>
        </table>
    </form>
    
</div>

<script>
    $(document).ready(function(){
        $('#post_form').validate({
            errorPlacement: function(error, element){
                error.appendTo(element.parentsUntil('tr').parent().prev().find('td:first'));
            },
        <?php if($payment['payment_code'] == 'alipay'): ?>
            rules : {
                alipay_account : {
                    required   : true
                },
                alipay_key : {
                    required   : true
                },
                alipay_partner : {
                    required   : true
                }
            },
            messages : {
                alipay_account  : {
                    required  : '支付宝账号不能为空'
                },
                alipay_key  : {
                    required  : '交易安全校验码不能为空'
                },
                alipay_partner  : {
                    required  : '合作者身份不能为空'
                }
            }
        <?php endif; if($payment['payment_code'] == 'alipay_mb'): ?>
            rules : {
                mb_alipay_account : {
                    required   : true
                },
                mb_alipay_partner : {
                    required   : true
                }
            },
            messages : {
                mb_alipay_account  : {
                    required : '<i class="fa fa-exclamation-circle"></i>支付宝账号不能为空'
                },
                mb_alipay_partner  : {
                    required : '<i class="fa fa-exclamation-circle"></i>合作者身份不能为空'
                }
            }
        <?php endif; if($payment['payment_code']== 'wxpay'): ?>
            rules : {
                wxpay_appid : {
                    required   : true
                },
                wxpay_partnerid : {
                    required   : true
                }
                wxpay_partnerkey : {
                    required   : true
                }
            },
            messages : {
                wxpay_appid  : {
                    required : 'APP唯一凭证（appid）不能为空'
                },
                wxpay_partnerid  : {
                    required : '商户号（mch_id）不能为空'
                }
                wxpay_partnerkey  : {
                    required : '商户密钥Key不能为空'
                }

            }
        <?php endif; if($payment['payment_code'] == 'wxpay_jsapi'): ?>
            rules : {
                appId : {
                    required   : true
                },
                appSecret : {
                    required   : true
                },
                partnerId : {
                    required   : true
                }
            },
            messages : {
                appId  : {
                    required : 'APP唯一凭证不能为空'
                },
                appSecret  : {
                    required : '应用密钥不能为空'
                },
                partnerId  : {
                    required : '合作者身份不能为空'
                }
            }
        <?php endif; ?>
    });


        $('#btn_submit').on('click', function() {
            $('#post_form').submit();
        });
    });
</script> 