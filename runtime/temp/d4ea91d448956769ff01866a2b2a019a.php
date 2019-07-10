<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:73:"/home/www/chenganxjh/public/../application/admin/view/mbpayment/list.html";i:1558338271;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
    
    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom">
            <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
            <span id="explanationZoom" title="收起提示" class="arrow"></span>
        </div>
        <ul>
            <li>此处列出了手机支持的支付方式，点击编辑可以设置支付参数及开关状态</li>
        </ul>
    </div>
    
    <table class="ds-default-table">
        <thead>
        <tr class="thead">
            <th>支付方式</th>
            <th class="align-center">启用</th>
            <th class="align-center"><?php echo \think\Lang::get('ds_handle'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php if(!(empty($mb_payment_list) || (($mb_payment_list instanceof \think\Collection || $mb_payment_list instanceof \think\Paginator ) && $mb_payment_list->isEmpty()))): if(is_array($mb_payment_list) || $mb_payment_list instanceof \think\Collection || $mb_payment_list instanceof \think\Paginator): $i = 0; $__LIST__ = $mb_payment_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
        <tr class="hover">
            <td><?php echo $v['payment_name']; ?></td>
            <td class="w25pre align-center"><?php echo $v['payment_state_text']; ?></td>
            <td class="w156 align-center"><a href="<?php echo url('mbpayment/payment_edit',['payment_id'=>$v['payment_id']]); ?>"><?php echo \think\Lang::get('ds_edit'); ?></a></td>
        </tr>
      <?php endforeach; endif; else: echo "" ;endif; endif; ?>
        </tbody>
        <tfoot>
        <tr class="tfoot">
            <td colspan="15"></td>
        </tr>
        </tfoot>
    </table>

</div>