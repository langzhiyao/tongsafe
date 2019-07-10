<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:75:"/home/www/chenganxjh/public/../application/admin/view/schoolinfo/index.html";i:1558338271;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
            <?php if($admin_item): ?>
<ul class="tab-base ds-row">
    <?php if(is_array($admin_item) || $admin_item instanceof \think\Collection || $admin_item instanceof \think\Paginator): if( count($admin_item)==0 ) : echo "" ;else: foreach($admin_item as $key=>$item): ?>
    <li><a href="<?php echo $item['url']; ?>" <?php if($item['name'] == $curitem): ?>class="current"<?php endif; ?>><span><?php echo $item['text']; ?></span></a></li>
    <?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
<?php endif; ?>
        </div>
    </div>

    <form method="post" enctype="multipart/form-data" name="form1" action="">
        <div class="ncap-form-default">
            <dl>
                <dt><?php echo \think\Lang::get('school_index_name'); ?>：<?php echo $school_array['name']; ?></dt>
            </dl>
            <dl>
                <dt><?php echo \think\Lang::get('school_index_unique'); ?>：<?php echo $school_array['schoolCard']; ?></dt>
            </dl>
            <dl>
                <dt><?php echo \think\Lang::get('school_index_region'); ?>：<?php echo $school_array['region']; ?></dt>
            </dl>
            <dl>
                <dt><?php echo \think\Lang::get('school_index_type'); ?>：<?php if(is_array($schooltype) || $schooltype instanceof \think\Collection || $schooltype instanceof \think\Paginator): $i = 0; $__LIST__ = $schooltype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?>
                    <?php echo $type; endforeach; endif; else: echo "" ;endif; ?></dt>
            </dl>
            <dl>
                <dt><?php echo \think\Lang::get('school_index_address'); ?>：<?php echo $school_array['address']; ?></dt>
            </dl>
            <dl>
                <dt><?php echo \think\Lang::get('school_index_phone'); ?>：<?php echo $school_array['common_phone']; ?></dt>
            </dl>
            <dl>
                <dt><?php echo \think\Lang::get('school_index_username'); ?>：<?php echo $school_array['username']; ?></dt>
            </dl>
            <dl>
                <dt><?php echo \think\Lang::get('school_index_dieline'); ?>：<?php echo $school_array['dieline']; ?></dt>
            </dl>
            <dl>
                <dt><?php echo \think\Lang::get('school_index_desc'); ?>：<?php echo $school_array['desc']; ?></dt>
            </dl>

        </div>
    </form>

</div>








