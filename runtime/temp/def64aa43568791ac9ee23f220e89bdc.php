<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:73:"/home/www/chenganxjh/public/../application/admin/view/pkgs/pkgs_form.html";i:1561530512;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
                <h3><?php echo \think\Lang::get('pkgs_edit'); ?></h3>
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
    <div class="fixed-empty"></div>
    <form id="link_form" enctype="multipart/form-data" method="post" class="layui-form">
        <div  class="ncap-form-default">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('pkg_name'); ?>：</label>
                    <div class="layui-input-inline">
                        <input id="pkg_name" name="pkg_name"  type="text" value="<?php echo (isset($pkg_info['pkg_name']) && ($pkg_info['pkg_name'] !== '')?$pkg_info['pkg_name']:''); ?>"  class="layui-input">
                        <span class="err"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('pkg_type'); ?>：</label>
                    <div class="layui-input-inline">
                        <input name="pkg_type" type="radio" value="1" <?php if($pkg_info['pkg_type'] == 1 || $pkg_info['pkg_type'] != 1): ?>checked="checked"<?php endif; ?> >
                        <label><?php echo \think\Lang::get('witch_manage'); ?></label><br/>
                        <input type="radio" name="pkg_type" value="2" <?php if($pkg_info['pkg_type'] == 2): ?>checked="checked"<?php endif; ?>>
                        <label><?php echo \think\Lang::get('revisit_manage'); ?></label>
                        <span class="err"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('pkg_enabled'); ?>：</label>
                    <div class="layui-input-inline">
                        <input name="pkg_enabled" type="radio" value="1" <?php if($pkg_info['pkg_enabled'] == 1 || $pkg_info['pkg_enabled'] != 2): ?>checked="checked"<?php endif; ?>>
                        <label><?php echo \think\Lang::get('pkg_use_s'); ?></label><br/>
                        <input type="radio" name="pkg_enabled" value="2" <?php if($pkg_info['pkg_enabled'] == 2): ?>checked="checked"<?php endif; ?>>
                        <label><?php echo \think\Lang::get('pkg_not_use_s'); ?></label>
                        <span class="err"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('pkg_axis'); ?>：</label>
                    <div class="layui-input-inline">
                        <input type="text" style="line-height: 32px;" onkeyup="this.value=this.value.replace(/[^\d]/g,'') " onafterpaste="this.value=this.value.replace(/[^\d]/g,'') " placeholder="只能输入数字" name="pkg_length" id="pkg_length" value="<?php echo (isset($pkg_info['pkg_length']) && ($pkg_info['pkg_length'] !== '')?$pkg_info['pkg_length']:'1'); ?>"/>
                        <span class="err"></span>
                    </div>
                </div>
                <div class="layui-inline">
                    <div class="layui-input-inline">
                        <select name="pkg_axis" class="select">
                            <?php foreach($axis_list as $k => $v){ ?>
                            <option <?php if($k == $pkg_info['pkg_axis']): ?>selected<?php endif; ?> value="<?php echo $k;?>"><?php echo $v ; ?></option>
                            <?php } ?>
                        </select>
                        <span class="err"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('pkg_cprice'); ?>：</label>
                    <div class="layui-input-inline">
                        <input id="pkg_cprice" name="pkg_cprice"  type="text" value="<?php echo (isset($pkg_info['pkg_cprice']) && ($pkg_info['pkg_cprice'] !== '')?$pkg_info['pkg_cprice']:''); ?>"  class="layui-input">
                        <span class="err"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('pkg_price'); ?>：</label>
                    <div class="layui-input-inline">
                        <input id="pkg_price" name="pkg_price"  type="text" value="<?php echo (isset($pkg_info['pkg_price']) && ($pkg_info['pkg_price'] !== '')?$pkg_info['pkg_price']:''); ?>"  class="layui-input">
                        <span class="err"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('pkg_sort'); ?>：</label>
                    <div class="layui-input-inline">
                        <input id="pkg_sort" name="pkg_sort"  type="text" value="<?php echo (isset($pkg_info['pkg_sort']) && ($pkg_info['pkg_sort'] !== '')?$pkg_info['pkg_sort']:''); ?>"  class="layui-input">
                        <span class="err"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('pkg_desc'); ?>：</label>
                    <div class="layui-input-inline">
                        <textarea id="pkg_desc" name="pkg_desc" class="layui-text"><?php echo (isset($pkg_info['pkg_desc']) && ($pkg_info['pkg_desc'] !== '')?$pkg_info['pkg_desc']:''); ?></textarea>
                        <span class="err"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <a href="JavaScript:void(0);" class="btn" id="submitBtn">确认提交</a>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use(['form','laypage', 'layer'], function(){
        var form = layui.form,
            laypage = layui.laypage
            ,layer = layui.layer;
    });
//按钮先执行验证再提交表单
    $(function () {
        $("#submitBtn").click(function () {
            if ($("#link_form").valid()) {
                $("#link_form").submit();
            }
        });
    });
//
    $(document).ready(function () {

        $('#link_form').validate({
            errorPlacement: function (error, element) {
                error.appendTo(element.next());
            },
            rules: {
                pkg_name: {
                    required: true
                },
                pkg_price: {
                    required: true
                },
                pkg_cprice: {
                    required: true
                },
            },
            messages: {
                pkg_name: {
                    required: '<?php echo \think\Lang::get('pkg_name_err'); ?>'
                },
                pkg_price: {
                    required: '<?php echo \think\Lang::get('pkg_price_err'); ?>',
                },
                pkg_cprice: {
                    required: '<?php echo \think\Lang::get('pkg_cprice_err'); ?>',
                },
            }
        });
    });
</script>