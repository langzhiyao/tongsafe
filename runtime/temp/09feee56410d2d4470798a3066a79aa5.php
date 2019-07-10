<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:74:"/home/www/chenganxjh/public/../application/admin/view/teachvideo/pass.html";i:1558338271;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
        
    

        


<script src="<?php echo \think\Config::get('url_domain_root'); ?>static/common/js/mlselection_list.js"></script>
<script src="<?php echo \think\Config::get('url_domain_root'); ?>static/home/js/common.js"></script>
<link rel="stylesheet" href="<?php echo \think\Config::get('url_domain_root'); ?>static/plugins/layer/css/layui.css">
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>视频管理</h3>
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
    <form method="post" enctype="multipart/form-data" name="form1" action="">
        <div class="ncap-form-default">
            <dl>
                <dt><?php echo \think\Lang::get('teacher_index_videoname'); ?>：<?php echo $teachinfo['t_title']; ?></dt>
            </dl>
            <dl>
                <dt><?php echo \think\Lang::get('teacher_index_videotype'); ?>：<?php echo $teachinfo['type']; ?></dt>
            </dl>
            <dl>
                <dt><?php echo \think\Lang::get('teacher_index_videoprice'); ?>：<?php echo $teachinfo['t_price']; ?></dt>
            </dl>
            <dl>
                <dt><?php echo \think\Lang::get('teacher_index_videodesc'); ?>：<?php echo $teachinfo['t_profile']; ?></dt>
            </dl>
            <dl>
                <dt>备注：<?php echo $teachinfo['t_desc']; ?></dt>
            </dl>
            <dl>
                <dt>作者：<?php echo $teachinfo['t_author']; ?></dt>
            </dl>
            <dl>
                <dt><?php echo \think\Lang::get('teacher_index_videoupload'); ?>：<?php echo $teachinfo['member_mobile']; ?></dt>
            </dl>
            <dl>
                <dt><?php echo \think\Lang::get('teacher_index_videoteacher'); ?>：<?php if($teachinfo['member_mobile'] == '后台'): ?>
                    后台
                    <?php endif; ?>
                    <?php echo $teachinfo['name']; ?></dt>
            </dl>
            <dl>
                <dt><?php echo \think\Lang::get('teacher_index_uploadtime'); ?>：<?php echo date("Y-m-d H:i:s",$teachinfo['t_maketime']); ?></dt>
            </dl>
            <?php if($teachinfo['t_audit'] == 2): ?>
            <dl>
                <dt>审核不通过原因：<?php echo $teachinfo['t_failreason']; ?></dt>
            </dl>
            <?php endif; ?>
            <!--<dl>-->
                <!--<dt>提醒：请确定视频不存在违法及负面内容再通过！</dt>-->
            <!--</dl>-->
            <dl>
                <dt><?php echo \think\Lang::get('teacher_index_videoimg'); ?>：<?php echo $teachinfo['affiliat']; ?></dt>
            </dl>
            <dl>
                <dt>
                <video width="350" height="260" controls="controls" src="<?php echo $teachinfo['t_url']; ?>"></video>
                </dt>
            </dl>
            <dl>
                <dt>说明：点击审核通过或拒绝审核，系统会发送短信给上传账号进行审核结果的通知。</dt>
            </dl>
            <a href="javascript:dd(<?php echo $teachinfo['t_id']; ?>)" class="layui-btn layui-btn-xs"><?php echo \think\Lang::get('teacher_index_pass'); ?></a>
        </div>
    </form>
    <form class="layui-form" onsubmit="return false;" style="display: none;" id="courForm">
        <input type="hidden" id="role" value="">
        &nbsp;&nbsp;&nbsp;&nbsp;拒绝原因：<input type="text" value="" name="fail_reason" id="fail_reason" class="txt">
        <input type="hidden" id="mit"  value="<?php echo url('/admin/teachvideo/drop',['t_id'=>$teachinfo['t_id'],'t_audit'=>2,'phone'=>$teachinfo['member_mobile'],'reason'=>'']); ?>">
        &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo url('/admin/teachvideo/drop',['t_id'=>$teachinfo['t_id'],'t_audit'=>3,'phone'=>$teachinfo['member_mobile']]); ?>" class="btn" id="submitBtn">审核通过</a>
        <a href="javascript:da()" class="btn" id="">拒绝审核</a>

    </form>
</div>
<script type="text/javascript">
    function da(){
        $a = $("#fail_reason").val();
        var str = $("#mit").val()+   $("#fail_reason").val();
        window.location.href=str;
    }
    function dd(role){
        //多窗口模式，层叠置顶
        layer.open({
            type: 1,
            title: '审核',
            area: ['300px', '150px'],
            fixed: false, //不固定
            shadeClose: true,
            shade: 0.4,
            maxmin: false, //开启最大化最小化按钮
            content: $("#courForm")
        });
    }
</script>