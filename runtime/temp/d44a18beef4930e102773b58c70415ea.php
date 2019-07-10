<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:71:"/home/www/chenganxjh/public/../application/admin/view/config/index.html";i:1561455123;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
        
    

        


<link rel="stylesheet" href="<?php echo \think\Config::get('url_domain_root'); ?>static/plugins/layer/css/layui.css">
<style>
    .layui-form-label{
        width: 200px;
    }
</style>
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>



<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>通用设置/APP</h3>
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
    <!-- 操作说明 -->
    <div class="explanation" id="explanation" style="width:100%;box-sizing: border-box;">
        <div class="title" id="checkZoom">
            <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
            <span id="explanationZoom" title="收起提示" class="arrow"></span>
        </div>
        <ul>
            <li>设置副账号数量后，app的副账户进行按此数量显示。0为无副账户</li>
            <li>分成比例可以填写小数，精确到2位，如果0.25%。</li>
        </ul>
    </div>
    <form method="post" enctype="multipart/form-data" name="form1" class="layui-form">

        <div class="ncap-form-default">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('after_start_password'); ?></label>
                    <div class="layui-input-inline">
                        <input type="tel" name="after_start_password" value="<?php echo $list_config['after_start_password']; ?>" lay-verify="required|number" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('f_account_num'); ?></label>
                    <div class="layui-input-inline">
                        <input type="tel" name="f_account_num" value="<?php echo $list_config['f_account_num']; ?>" lay-verify="required|number" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">个</div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('bind_student_num'); ?></label>
                    <div class="layui-input-inline">
                        <input type="tel" name="bind_student_num" value="<?php echo $list_config['bind_student_num']; ?>" lay-verify="required|number" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">个</div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('video_pay_scale'); ?></label>
                    <div class="layui-form-mid layui-word-aux"><?php echo \think\Lang::get('province_agent'); ?></div>
                    <div class="layui-input-inline" style="width: 100px;">
                        <input type="text" name="province_agent" lay-verify="required|number" value="<?php echo $list_config['video_pay_scale']->province_agent; ?>" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">%</div>
                    <div class="layui-form-mid">-</div>
                    <div class="layui-form-mid layui-word-aux"><?php echo \think\Lang::get('city_agent'); ?></div>
                    <div class="layui-input-inline" style="width: 100px;">
                        <input type="text" name="city_agent" lay-verify="required|number" value="<?php echo $list_config['video_pay_scale']->city_agent; ?>" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">%</div>
                    <div class="layui-form-mid">-</div>
                    <div class="layui-form-mid layui-word-aux"><?php echo \think\Lang::get('area_agent'); ?></div>
                    <div class="layui-input-inline" style="width: 100px;">
                        <input type="text" name="area_agent" lay-verify="required|number" value="<?php echo $list_config['video_pay_scale']->area_agent; ?>" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">%</div>
                    <div class="layui-form-mid">-</div>
                    <div class="layui-form-mid layui-word-aux"><?php echo \think\Lang::get('agent'); ?></div>
                    <div class="layui-input-inline" style="width: 100px;">
                        <input type="text" name="agent" lay-verify="required|number" value="<?php echo $list_config['video_pay_scale']->agent; ?>" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">%</div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                </div>
            </div>
        </div>
    </form>

</div>








