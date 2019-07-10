<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:86:"/home/www/chenganxjh/public/../application/admin/view/membercommon/childrencamera.html";i:1558338271;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
<script src="<?php echo \think\Config::get('url_domain_root'); ?>static/ckplayer/ckplayer.js"></script>


<div class="layui-fluid layui-card-body" id="LAY" style="display: none;">
    <div class="layui-row layui-col-space10 demo-list">
        <div class="layui-col-sm4">
            <!-- 填充内容 -->
            <div class="layui-card">
                <div id="video" style="width: 600px; height: 400px;"></div>
            </div>
        </div>
    </div>
</div>
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
    <ul class="layui-nav" lay-filter="">
      <?php if(!(empty($childs) || (($childs instanceof \think\Collection || $childs instanceof \think\Paginator ) && $childs->isEmpty()))): if(is_array($childs) || $childs instanceof \think\Collection || $childs instanceof \think\Paginator): $i = 0; $__LIST__ = $childs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
        <li class="layui-nav-item"><a href="javascript:;" class="sssss" sid="<?php echo $v['s_id']; ?>"><?php echo $v['s_name']; ?></a></li>
      <?php endforeach; endif; else: echo "" ;endif; else: ?>
        <li class="layui-nav-item">还没有绑定孩子</li>
      <?php endif; ?>
    </ul>
    <table id="camera" lay-filter="test"></table>
    <script>
      function rtmplay(cid){
        addrtmp(cid,2);
        var rtmpInfo= $('#rmt_'+cid).attr('datainfo');
        rtmpInfo =$.parseJSON(rtmpInfo);
        layer.open({
          type: 1,
          title: rtmpInfo.name,
          // shadeClose: true,
          shade: false,
          area: ['644px', '470px'],
          skin: 'layui-layer-rim',
          content: $('#LAY')
          ,cancel: function(){
                addrtmp(cid,1);
          }
        });
        var videoObject = {
                container: '#video', //容器的ID或className
                variable: 'player',//播放函数名称
                autoplay:false,
                live:true,
                debug:true,
                video: rtmpInfo.rtmpplayurl,
                poster:rtmpInfo.imageurl
            };
        var player = new ckplayer(videoObject);
    }
    function addrtmp(cid,is_rtmp){
        $.ajax({
            type:'POST',
            url:ADMIN_URL+'Monitor/addrtmp',
            data:{cid:cid,is_rtmp:is_rtmp},
            success:function(data){
                return(data);
            }
        })
    }
    layui.use(['table', 'element'], function(){
        var table = layui.table;
        $('.sssss').click(function(event) {
            var s_id = $(this).attr('sid');
            GetCamera(s_id);
        });
        function GetCamera(s_id){
          var member_id = '<?php echo $_GET["member_id"];?>';
          var urls=ADMIN_URL+'Membercommon/ChildrenCamera?member_id='+member_id+'&s_id='+s_id;
          //第一个实例
          table.render({
            elem: '#camera'
            ,height: 'full-200'
            ,url: urls //数据接口
            ,page: true //开启分页
            ,cols: [[ //表头
              {field: 'name', title: '名称', width:200,fixed: 'center'}
              ,{field: 'channelid', title: '通道ID', width:80}
              ,{field: 'deviceid', title: '设备id', width:100}
              ,{field: 'id', title: '摄像头id', width:100} 
              ,{field: 'statusess', title: '在线', width: 60}
              ,{field: 'parentid', title: '资源id', width: 80}
              ,{field: 'clic', title: '播放地址', width: 90}
              ,{field: 'is_classrooms', title: '重温课堂', width: 100}
              ,{field: 'statuss', title: '开关', width:60}
              ,{field: 'sq_time', title: '导入时间', width: 180, sort: true}
              ,{field: 'begintime', title: '开启时间', width: 120}
              ,{field: 'endtime', title: '关闭时间', width: 120}
            ]]

          });
        
        }
    });
    
    </script>

</div>








