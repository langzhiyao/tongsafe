<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:70:"/home/www/chenganxjh/public/../application/admin/view/member/edit.html";i:1561455123;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>



<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>会员管理</h3>
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


    <form id="user_form" enctype="multipart/form-data" method="post">
        <input type="hidden" name="form_submit" value="ok" />
        <input type="hidden" name="member_id" value="<?php echo $member_array['member_id'];?>" />
        <input type="hidden" name="old_member_avatar" value="<?php echo $member_array['member_avatar'];?>" />
        <input type="hidden" name="member_name" value="<?php echo $member_array['member_name'];?>" />

        <div class="ncap-form-default">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('member_name'); ?></label>
                    <div class="layui-input-inline">
                        <input type="text" name="member_name" value="<?php echo $member_array['member_name'];?>" id="member_name" class="layui-input">
                        <span class="err"></span>
                    </div>
                </div>
            </div>
            <!--<div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('member_index_email'); ?></label>
                    <div class="layui-input-inline">
                        <input type="text" id="member_email" name="member_email" class="layui-input">
                        <span class="err"></span>
                    </div>
                </div>
            </div>-->
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('mob_phone'); ?></label>
                    <div class="layui-input-inline">
                        <input type="tel" id="member_mobile" value="<?php echo $member_array['member_mobile'];?>" name="member_mobile" lay-verify="required|number" autocomplete="off" class="layui-input">
                        <span class="err"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('member_index_true_name'); ?></label>
                    <div class="layui-input-inline">
                        <input type="text" id="member_truename" name="member_truename" value="<?php echo $member_array['member_truename'];?>" class="layui-input">
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><?php echo \think\Lang::get('member_edit_sex'); ?></label>
                <div class="layui-input-inline">
                    <input type="radio" <?php if($member_array['member_sex'] == 0){ ?>checked="checked"<?php } ?> value="0" name="member_sex" ><?php echo \think\Lang::get('member_edit_secret'); ?>
                    <input type="radio" <?php if($member_array['member_sex'] == 1){ ?>checked="checked"<?php } ?> value="1" name="member_sex"><?php echo \think\Lang::get('member_edit_male'); ?>
                    <input type="radio" <?php if($member_array['member_sex'] == 2){ ?>checked="checked"<?php } ?> value="2" name="member_sex"><?php echo \think\Lang::get('member_edit_female'); ?>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><?php echo \think\Lang::get('member_edit_sex'); ?></label>
                <div class="layui-input-block">
                    <input id="memberstate_1" name="memberstate" <?php if($member_array['member_state'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio"><?php echo \think\Lang::get('member_edit_allow'); ?>
                    <input id="memberstate_2" name="memberstate" <?php if($member_array['member_state'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"><?php echo \think\Lang::get('member_edit_deny'); ?>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <a href="JavaScript:void(0);" class="btn" id="submitBtn">确认提交</a>
                </div>
            </div>
        </div>
    </form>

    <script type="text/javascript" src="<?php echo \think\Config::get('url_domain_root'); ?>static/common/js/mlselection.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo \think\Config::get('url_domain_root'); ?>static/home/js/common.js" charset="utf-8"></script>
    <script type="text/javascript">
        $(function(){
            $('#reset_possword').click(function(event) {
                layer.confirm('是否重置用户密码？重置后会以短信的方式发送给用户！', {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    var uid = "<?php echo $member_array['member_id'];?>";
                    $.ajax({
                        url: ADMIN_URL+'member/password_reset',
                        type: 'POST',
                        dataType: 'json',
                        data: {'uid': uid},
                    })
                        .done(function(sb) {
                            console.log(sb);
                            if (sb.state) {
                                layer.msg(sb.msg, {icon: 1});
                            }else{
                                layer.msg(sb.msg, {icon: 2});
                            }
                        })
                });
            });
        })
    </script>
    <script type="text/javascript">
        $(function() {
	         regionInit("region");
            $("#submitBtn").click(function() {
                if ($("#user_form").valid()) {
                    $("#user_form").submit();
                }
            });
            $('#user_form').validate({
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent().parent().prev().find('td:first'));
                },
                rules: {
                    member_password: {
                        maxlength: 20,
                        minlength: 6
                    },
                    member_email: {
                        required: false,
                        email: true,
                        remote: {
                            url: ADMIN_URL+'member/ajax?branch=check_email',
                            type: 'get',
                            data: {
                                user_name: function() {
                                    return $('#member_email').val();
                                },
                                member_id : '<?php echo $member_array['member_id'];?>'
                            }
                        }
                    }
                },
                messages: {
                    member_password: {
                        maxlength: '<?php echo \think\Lang::get('member_edit_password_tip'); ?>',
                        minlength: '<?php echo \think\Lang::get('member_edit_password_tip'); ?>'
                    },
                    member_email: {
                        required: '<?php echo \think\Lang::get('member_edit_email_null'); ?>',
                        email: '<?php echo \think\Lang::get('member_edit_valid_email'); ?>',
                        remote: '<?php echo \think\Lang::get('member_edit_email_exists'); ?>'
                    }
                }
            });
        });
    </script> 
</div>    
