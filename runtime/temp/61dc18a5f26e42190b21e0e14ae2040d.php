<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:68:"/home/www/tongsafe/public/../application/admin/view/login/index.html";i:1558338271;s:70:"/home/www/tongsafe/public/../application/admin/view/public/header.html";i:1558338271;s:70:"/home/www/tongsafe/public/../application/admin/view/public/footer.html";i:1558338271;}*/ ?>
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
        
    

        

 
<body style="background-image:url(<?php echo \think\Config::get('url_domain_root'); ?>/static/admin/images/wallpage/bg_<?php echo rand(1,8)?>.jpg););background-size: cover;">
    <div class="login">
        <div class="login_body">
            <div class="login_header">
                <img src="<?php echo \think\Config::get('url_domain_root'); ?>/static/admin/images/logo.png"/>
            </div>
            <div class="login_content">
                <form method="post">
                    <div class="form-group">
                        <input type="text" name="admin_name" placeholder="用户名" required class="text">
                    </div>
                    <div class="form-group">
                        <input type="password" name="admin_password" placeholder="密码" required  class="text">
                    </div>
                    <div class="form-group">
                        <input type="text" name="captcha" placeholder="验证码" required  class="text" style="width:60%;float:left;">
                        <img src="<?php echo captcha_src(); ?>" style="width:30%;height:38px;" id="change_captcha"/>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn" value="登录" style="width:100%"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $('#change_captcha').click(function () {
            $(this).attr('src', '<?php echo \think\Config::get('url_domain_root'); ?>index.php/captcha.html');
        });
    </script>
</body>
 




