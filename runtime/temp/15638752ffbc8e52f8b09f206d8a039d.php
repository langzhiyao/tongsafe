<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:84:"/home/www/chenganxjh/public/../application/admin/view/membercommon/childrenbind.html";i:1558681245;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
      <?php if(!(empty($childs) || (($childs instanceof \think\Collection || $childs instanceof \think\Paginator ) && $childs->isEmpty()))): if(is_array($childs) || $childs instanceof \think\Collection || $childs instanceof \think\Paginator): $i = 0; $__LIST__ = $childs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
        <thead>
          <tr>
            <th style="width: 100px;" colspan='10'></th>
            <th></th>
          </tr> 
        </thead>
        <tbody>
          <tr>
            <td>学生姓名</td>
            <td><?php echo $v['s_name']; ?></td>
          </tr>
          <tr>
            <td>学生性别</td>
            <td><?php echo SexFomat($v['s_sex']); ?></td>
          </tr>
          <tr>
            <td>学生生日</td>
            <td><?php echo Fomat($v['s_birthday']); ?></td>
          </tr>
          <tr>
            <td>学生身份证号</td>
            <td><?php echo empty($v['s_card'])?'未设置':$v['s_card']; ?></td>
          </tr>
          <tr>
            <td>学校类型</td>
            <td><?php echo schooltype($v['typeid']); ?></td>
          </tr>
          <tr>
            <td>学校名称</td>
            <td><?php echo $v['schoolname']; ?></td>
          </tr>
          <tr>
            <td>所在班级</td>
            <td><?php echo $v['classname']; ?></td>
          </tr>
          <tr>
            <td>学校所在地区</td>
            <td><?php echo $v['region']; ?></td>
          </tr>
          <tr>
            <td>绑定硬件设置</td>
            <td>未绑定</td>
          </tr>
          <tr>
            <td>备注说明</td>
            <td><?php echo empty($v['remark'])?'无':$v['remark']; ?></td>
          </tr>
          <tr>
        </tr>
      </tbody>
        <?php endforeach; endif; else: echo "" ;endif; else: ?>
        <tbody>
        <tr class="no_data">
            <td colspan="10"><?php echo \think\Lang::get('ds_no_record'); ?></td>
        </tr>
        </tbody>
        <?php endif; ?>
    </table>
        
</div>








