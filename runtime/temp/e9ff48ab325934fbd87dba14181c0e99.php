<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:86:"/home/www/chenganxjh/public/../application/admin/view/membercommon/childrenorders.html";i:1558681245;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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

    <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
      <ul class="layui-tab-title">
        <li class="layui-this">看孩订单</li>
        <li>教孩订单</li>
        <li>重温课堂订单</li>
        <li>商城订单</li>
      </ul>
      <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <blockquote class="layui-elem-quote">看孩订单--(<?php echo intval($package1Order); ?>)条</blockquote>
            <table class="layui-table" lay-data="{height: 'full-200', page: true, limit:30, url:'ChildrenOrders/OrderType/witch/member_id/<?php echo $_GET['member_id']?>'}">
              <thead>
                <tr>
                  <th lay-data="{field:'pkg_name', width:200}">订单名称</th>
                  <!-- <th lay-data="{field:'username', width:60}">单位</th> -->
                  <th lay-data="{field:'order_amount', width:120, sort: true}">价格（元）</th>
                  <th lay-data="{field:'order_state', width:100}">订单状态</th>
                  <th lay-data="{field:'add_time', sort: true}">购买时间</th>
                  <th lay-data="{field:'endTime', sort: true, align: 'right'}">套餐到期（日）</th>
                  <th lay-data="{field:'starTime', sort: true}">支付时间</th>
                  <th lay-data="{field:'order_name'}">备注</th>
                </tr>
              </thead>
            </table> 
        </div> 
        <div class="layui-tab-item">
            <blockquote class="layui-elem-quote">教孩订单--(<?php echo intval($package1Order); ?>)条</blockquote>
            <table class="layui-table" lay-data="{height: 'full-200', page: true, limit:30, url:'ChildrenOrders/OrderType/teach/member_id/<?php echo $_GET['member_id']?>'}">
              <thead>
                <tr>
                  <th lay-data="{field:'order_name', width:100}">订单名称</th>
                  <!-- <th lay-data="{field:'username', width:60}">单位</th> -->
                  <th lay-data="{field:'order_amount', width:120, sort: true}">价格（元）</th>
                  <th lay-data="{field:'order_state', width: 100}">订单状态</th>
                  <th lay-data="{field:'endTime', sort: true, align: 'right'}">套餐到期（日）</th>
                  <th lay-data="{field:'add_time', sort: true}">购买时间</th>
                  <th lay-data="{field:'starTime', sort: true}">支付时间</th>
                  <th lay-data="{field:'order_name'}">备注</th>
                </tr>
              </thead>
            </table> 
        </div>

        <div class="layui-tab-item">
            <blockquote class="layui-elem-quote">重温课堂订单--(<?php echo intval($package1Order); ?>)条</blockquote>
            <table class="layui-table" lay-data="{height: 'full-200', page: true, limit:30, url:'ChildrenOrders/OrderType/rewitch/member_id/<?php echo $_GET['member_id']?>'}">
              <thead>
                <tr>
                  <th lay-data="{field:'pkg_name', width:200}">订单名称</th>
                  <th lay-data="{field:'username', width:60}">单位</th>
                  <th lay-data="{field:'sex', width:100, sort: true}">价格（元）</th>
                  <th lay-data="{field:'sign', minWidth: 150}">订单状态</th>
                  <th lay-data="{field:'experience', sort: true, align: 'right'}">套餐到期（日）</th>
                  <th lay-data="{field:'score', sort: true}">购买时间</th>
                  <th lay-data="{field:'score', sort: true}">支付时间</th>
                  <th lay-data="{field:'pkg_name'}">备注</th>
                </tr>
              </thead>
            </table> 
        </div>
        <div class="layui-tab-item">
            <blockquote class="layui-elem-quote">商城订单--(<?php echo intval($package1Order); ?>)条</blockquote>
            <table class="layui-table" lay-data="{height: 'full-200', page: true, limit:10, url:'ChildrenOrders/OrderType/shoporder/member_id/<?php echo $_GET['member_id']?>'}">
              <thead>
                <tr>
                  <th lay-data="{field:'goods_name', width:200, sort: true}">商品名称</th>
                  <th lay-data="{field:'order_sn', width:180}">订单号</th>
                  <th lay-data="{field:'goods_num', width:70, sort: true}">单位</th>
                  <th lay-data="{field:'pay_amount', width: 120, sort: true}">价格（元）</th>
                  <th lay-data="{field:'state_desc',width: 120}">订单状态</th>
                  <th lay-data="{field:'add_time', sort: true, width: 180}">购买时间</th>
                  <th lay-data="{field:'payment_time', sort: true, width: 180}">支付时间</th>
                  <th lay-data="{field:'payment_name',  minWidth: 100}">备注</th>
                </tr>
              </thead>
            </table> 
        </div>
      </div>
    </div>  



<script>
layui.use('table', function(){
  var table = layui.table;
});
</script>
</div>








