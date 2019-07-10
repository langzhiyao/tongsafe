<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:82:"/home/www/chenganxjh/public/../application/admin/view/membercommon/memberinfo.html";i:1558681245;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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

 <link rel="stylesheet" href="<?php echo \think\Config::get('url_domain_root'); ?>static/plugins/layer/css/layui.css">


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

    <table class="layui-table">
        <thead>
          <tr>
            <th style="width: 100px;"></th>
            <th></th>
          </tr> 
        </thead>
        <tbody>
          <tr>
            <td>姓名</td>
            <td><?php echo $member_name; ?></td>
          </tr>
          <tr>
            <td>手机号(同账号)</td>
            <td><?php echo $member_mobile; ?></td>
          </tr>
          <tr>
            <td>邮箱</td>
            <td><?php echo $member_email; ?></td>
          </tr>
          <tr>
            <td>性别</td>
            <td><?php echo SexFomat($member_sex); ?></td>
          </tr>
          <tr>
            <td>生日</td>
            <td><?php echo Fomat($member_birthday); ?></td>
          </tr>
          <tr>
            <td>所在地区</td>
            <td><?php echo $member_areainfo; ?></td>
          </tr>
          <tr>
            <td>注册时间</td>
            <td><?php echo Fomat($member_add_time); ?></td>
          </tr>
          <tr>
            <td>账号状态</td>
            <td><?php echo $member_state==1?'开启':'禁用'; ?></td>
          </tr>
          
          <tr>
        </tr>
      </tbody>
    </table>

</div>








