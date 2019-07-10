<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:85:"/home/www/chenganxjh/public/../application/admin/view/membercommon/membercapital.html";i:1558681245;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
        <tbody>
          <tr>
            <td><?php echo $member_name; ?></td>
            <td>账户余额         <?php echo ncPriceFormatb($available_predeposit); ?> 元</td>
            <td>默认银行卡信息   <?php echo $bank_name; ?> <?php echo getHideBankCardNum($bank_card); ?></td>
          </tr>
          <tr>
        </tr>
      </tbody>
    </table>

    <div class="demoTable">
        <form class="layui-form" onsubmit="return false;">
            <div class="layui-form-item" >
                <div class="layui-inline">
                  <div class="layui-input-inline">
                    <input type="text" name="desc" lay-verify="required|phone" autocomplete="off" class="layui-input" placeholder="说明相关" id="desc">
                  </div>
                  <input type="hidden" name="member_id" class="layui-input" value='<?php echo $_GET["member_id"];?>'>
                </div>
                <div class="layui-inline">
                  <label class="layui-form-label">请选择范围</label>
                  <div class="layui-input-inline">
                    <input type="text" class="layui-input" id="test16" placeholder="开始 到 结束" name="timearund" >
                  </div>
                </div>
                <button class="layui-btn layui-btn-radius" data-type="reload">搜索</button>
            </div>
        </form>
        <script type="text/javascript">
            layui.use(['form', 'laydate'], function(){
                  var form = layui.form
                  ,laydate = layui.laydate;
                  laydate.render({
                    elem: '#test16'
                    // ,type: 'datetime'
                    ,range: '/'
                    ,format: 'yyyy-M-d'
                  });
            });
        </script>
    </div>
  
 </div>
 
<table class="layui-hide" id="LAY_table_user" lay-filter="user"></table> 
          
<script>
layui.use('table', function(){
  var table = layui.table;
  var member_id = '<?php echo $_GET["member_id"];?>';
  var urls=ADMIN_URL+'Membercommon/MemberCapital?member_id='+member_id+'&t=1';
  //方法级渲染
  table.render({
    elem: '#LAY_table_user'
    ,url: urls
    ,cols: [[
      {checkbox: true, fixed: true}
      ,{field:'lg_id', title: 'ID', width:80, sort: true, fixed: true}
      ,{field:'lg_add_time', title: '创建时间', width:200, sort: true}
      ,{field:'lg_av_amountin', title: '收入(元)', width:120}
      ,{field:'lg_av_amountout', title: '支出(元)', width:120}
      ,{field:'lg_freeze_amount', title: '冻结(元) ',width:120}
      ,{field:'lg_desc', title: '变更说明'}
    ]]
    ,id: 'testReload'
    ,page: true
    ,height: 315
  });
  
  var $ = layui.$, active = {
    reload: function(){
      //执行重载
      table.reload('testReload', {
        page: {
          curr: 1 //重新从第 1 页开始
        }
        ,where: {
          timearund:$('#test16').val(),
          desc:$('#desc').val()
        }
      });
    }
  };
  
  $('.demoTable .layui-btn').on('click', function(){
    var type = $(this).data('type');
    active[type] ? active[type].call(this) : '';
  });
});
</script>

</div>








