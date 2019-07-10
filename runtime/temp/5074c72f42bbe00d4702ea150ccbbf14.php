<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:70:"/home/www/chenganxjh/public/../application/admin/view/index/index.html";i:1558338271;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/topnav.html";i:1558338271;s:70:"/home/www/chenganxjh/public/../application/admin/view/public/left.html";i:1558338271;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/footer.html";i:1558338271;}*/ ?>
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
        
    

        


<div class="admincp-header">
    <div class="logo">
        <img src="<?php echo \think\Config::get('url_domain_root'); ?>/static/admin/images/logo11.png"/>
    </div>
    <div class="navbar">
        <ul class="fl" style="float:left;">
            <?php if(is_array($menu_list) || $menu_list instanceof \think\Collection || $menu_list instanceof \think\Paginator): if( count($menu_list)==0 ) : echo "" ;else: foreach($menu_list as $key=>$menu): ?>
            <li id="nav_<?php echo $menu['name']; ?>">
                <a href="javascript:void(0)" onclick="openItem('<?php echo $menu['name']; ?>')"><?php echo $menu['text']; ?></a>
                <dl>
                    <?php if(is_array($menu['children']) || $menu['children'] instanceof \think\Collection || $menu['children'] instanceof \think\Paginator): if( count($menu['children'])==0 ) : echo "" ;else: foreach($menu['children'] as $key=>$submenu): ?>
                    <dd><a href="javascript:void(0)" onclick="openItem('<?php echo $submenu['args']; ?>')"><?php echo $submenu['text']; ?></a></dd>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </dl>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <ul class="fr" style="float:right">
            <li>
                <span>您好,<?php echo \think\Session::get('admin_name'); ?></span>
                <dl>
                    <dd><a href="<?php echo url('Index/modifypw'); ?>" target="main-frame">修改密码</a></dd>
                    <dd><a href="<?php echo url('Login/logout'); ?>">安全退出</a></dd>
                </dl>
            </li>
            <!--<li><a href="<?php echo url('Index/modifypw'); ?>" target="main-frame">修改密码</a></li>
            <li><a href="<?php echo url('Login/logout'); ?>">安全退出</a></li>
            <li><a href="<?php echo url('Cache/clear'); ?>" target="main-frame">更新缓存</a></li>-->
            <!--<li><a href="<?php echo url('/Home/Index/index'); ?>" target="_blank">访问首页</a></li>-->
        </ul>
    </div>
</div>

<div class="admincp-container">
    <div class="admincp-container-left">
        <div id="mainMenu">
<?php if(is_array($menu_list) || $menu_list instanceof \think\Collection || $menu_list instanceof \think\Paginator): if( count($menu_list)==0 ) : echo "" ;else: foreach($menu_list as $menu_k=>$menu): ?>
<ul id="sort_<?php echo $menu['name']; ?>" <?php if($menu_k != 'dashboard'): ?>style="display:none"<?php endif; ?>>
    <?php if(is_array($menu['children']) || $menu['children'] instanceof \think\Collection || $menu['children'] instanceof \think\Paginator): if( count($menu['children'])==0 ) : echo "" ;else: foreach($menu['children'] as $submenu_key=>$submenu): $args_array = explode(",",$submenu['args']); ?>
    <li id="left_<?php echo $args_array[2].$args_array[1].$args_array[0] ?>"><a href="javascript:void(0)"  onclick="openItem('<?php echo $submenu['args']; ?>')" ><?php echo $submenu['text']; ?></a></li>
    <?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
<?php endforeach; endif; else: echo "" ;endif; ?>
</div>


    </div>
    <div class="admincp-container-right">
        <div class="top-border"></div>
        <iframe src="<?php echo url('/Admin/Dashboard/index'); ?>" id="main-frame" name="main-frame" style="overflow: visible;" frameborder="0" width="100%" height="94%" scrolling="yes" onload="window.parent"></iframe>
    </div>
</div>
<script>
            $(function() {
                $('#welcome,dashboard,dashboard').addClass('active');
                if ($.cookie('now_location_controller') != null) {
                    openItem($.cookie('now_location_action') + ',' + $.cookie('now_location_controller') + ',' + $.cookie('now_location_module'));
                } else {
                    $('#mainMenu>ul').first().css('display', 'block');
                    //第一次进入后台时，默认定到欢迎界面
                    $('#item_welcome').addClass('selected');
                    $('#workspace').attr('src', ADMIN_URL+'dashboard/welcome');
                }
                $('#iframe_refresh').click(function() {
                    var fr = document.frames ? document.frames("workspace") : document.getElementById("workspace").contentWindow;
                    fr.location.reload();
                });
            });


            function openItem(args) {
                spl = args.split(',');
                action = spl[0];
                try {
                    controller = spl[1];
                    module = spl[2];
                }
                catch (ex) {
                }
                if (typeof(controller) == 'undefined') {
                    var module = args;
                }
                //顶部导航样式处理
                $('.actived').removeClass('actived');
                $('#nav_' + module).addClass('actived');
                //清除左侧样式
                $('.selected').removeClass('selected');

                //show
                $('#mainMenu ul').css('display', 'none');
                $('#sort_' + module).css('display', 'block');
                if (typeof(controller) == 'undefined') {
                    //顶部菜单事件
                    html = $('#sort_' + module + '>li').first().html();
                    str = html.match(/openItem\('(.*)'\)/ig);
                    arg = str[0].split("'");
                    spl = arg[1].split(',');
                    action = spl[0];
                    controller = spl[1];
                    module = spl[2];
                    first_obj = $('#sort_' + module + '>li').first();
                    $(first_obj).addClass('selected');
                } else {
                    //左侧菜单事件
                    //location
                    $.cookie('now_location_module', module);
                    $.cookie('now_location_controller', controller);
                    $.cookie('now_location_action', action);
                    $("#left_"+ module + controller + action).addClass('selected');
                    
                }
                src = SITE_URL+'index.php/Admin/' + controller + '/' + action + '/';
                $('#main-frame').attr('src', src);
            }
</script>

 


