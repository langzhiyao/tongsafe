<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:70:"/home/www/chenganxjh/public/../application/admin/view/school/edit.html";i:1562141320;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
                <h3>学校管理</h3>
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
    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom">
            <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
            <span id="explanationZoom" title="收起提示" class="arrow"></span>
        </div>
        <ul>
            <li>修改学校信息。</li>
        </ul>
    </div>

    <form id="user_form" enctype="multipart/form-data" method="post" class="layui-form">
        <input type="hidden" name="form_submit" value="ok" />
        <input type="hidden" name="school_id" value="<?php echo $school_array['schoolid'];?>" />
        <div class="ncap-form-default">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('school_index_name'); ?>：</label>
                    <div class="layui-input-inline">
                        <input type="text" id="school_name" name="school_name" value="<?php echo $school_array['name'];?>" class="layui-input">
                        <span class="err"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('school_index_region'); ?>：</label>
                    <div class="layui-inline">
                        <div class="layui-input-inline">
                            <select  lay-filter="province"  class="select"  lay-verify="type" name="province" id="province">
                                <option value="" selected><?php echo \think\Lang::get('look_address_province'); ?></option>
                                <?php if(is_array($region_list) || $region_list instanceof \think\Collection || $region_list instanceof \think\Paginator): $i = 0; $__LIST__ = $region_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo $vo['area_id']; ?>" <?php if($school_array['provinceid'] == $vo['area_id']){echo 'selected';}?>><?php echo $vo['area_name']; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                        <div class="layui-input-inline">
                            <select name="city" lay-filter="city"  class="select"  lay-verify="type"  id="city">
                                <option value=""><?php echo \think\Lang::get('look_address_city'); ?></option>
                            </select>
                        </div>
                        <div class="layui-input-inline">
                            <select name="area" lay-filter="area"  class="select"  lay-verify="type"  id="area">
                                <option value=""><?php echo \think\Lang::get('look_address_area'); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="area_info" id="area_info" value="<?php echo $school_array['region'];?>" />
            <div class="layui-form-item">
                <label class="layui-form-label"><?php echo \think\Lang::get('school_index_type'); ?>：</label>
                <div class="layui-input-block">
                    <?php if(is_array($schoolType) || $schoolType instanceof \think\Collection || $schoolType instanceof \think\Paginator): $i = 0; $__LIST__ = $schoolType;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?>
                    <input type="checkbox" name="school_type[]" <?php if(is_array($school_array['typeid']) || $school_array['typeid'] instanceof \think\Collection || $school_array['typeid'] instanceof \think\Paginator): $i = 0; $__LIST__ = $school_array['typeid'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;if($v == $type['sc_id']): ?> checked <?php endif; endforeach; endif; else: echo "" ;endif; ?> value="<?php echo $type['sc_id']; ?>" > <?php echo $type['sc_type']; endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('address'); ?>：</label>
                    <div class="layui-input-inline">
                        <input type="text" id="school_address" value="<?php echo $school_array['address'];?>" name="school_address" class="layui-input">
                        <span class="err"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('mob_phone'); ?>：</label>
                    <div class="layui-input-inline">
                        <input type="text" id="school_phone" value="<?php echo $school_array['common_phone'];?>" name="school_phone" class="layui-input">
                        <span class="err"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('organize_index_leading'); ?>：</label>
                    <div class="layui-input-inline">
                        <input type="text" id="school_username" value="<?php echo $school_array['username'];?>" name="school_username" class="layui-input">
                        <span class="err"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('organize_index_enddate'); ?>：</label>
                    <div class="layui-input-inline">
                        <input type="text" id="school_dieline" value="<?php echo $school_array['dieline'];?>" name="school_dieline" class="layui-input date">
                        <span class="err"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('organize_index_remark'); ?>：</label>
                    <div class="layui-input-inline">
                        <textarea id="school_desc" name="school_desc" class="layui-text"><?php echo $school_array['desc'];?></textarea>
                        <span class="err"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"></label>
                <div class="layui-input-block">
                    <a href="JavaScript:void(0);" class="btn" id="submitBtn">确认提交</a>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="<?php echo \think\Config::get('url_domain_root'); ?>static/common/js/mlselection.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo \think\Config::get('url_domain_root'); ?>static/home/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    layui.use(['form','laypage', 'layer'], function(){
        var form = layui.form,
            laypage = layui.laypage
            ,layer = layui.layer;
        //省 市 区
        var province = '<?php if(!empty($school_array["provinceid"])){echo $school_array["provinceid"];}?>';
        var city = '<?php if(!empty($school_array["cityid"])){echo $school_array["cityid"];}?>';
        var area = '<?php if(!empty($school_array["areaid"])){echo $school_array["areaid"];}?>';
        if(province != 0){
            $.ajax({
                type:'POST',
                url:ADMIN_URL+'Common/get_address_school?province='+province+'&city='+city+'&area='+area,
                success:function(data){
                    data = jQuery.parseJSON(data);
                    //改变市区
                    $('#city').html(data.city);
                    //改变县区
                    $('#area').html(data.area);
                    form.render('select');//select是固定写法 不是选择器
                }
            })
        }

        //省
        form.on('select(province)', function(data){
            //改变市区
            $('#city').html('<option value="0"><?php echo \think\Lang::get('look_address_city'); ?></option>');
            //改变县区
            $('#area').html('<option value="0"><?php echo \think\Lang::get('look_address_area'); ?></option>');

            $.ajax({
                type:'POST',
                url:ADMIN_URL+'Common/get_address_school?province='+data.value,
                success:function(data){
                    var province_html = $('#province').find('option:selected').val();
                    $('#area_info').val(province_html);
                    data = jQuery.parseJSON(data);
                    //改变市区
                    $('#city').html(data.city);
                    //改变县区
                    $('#area').html(data.area);
                    form.render('select');//select是固定写法 不是选择器
                }
            })
        });
        //市
        form.on('select(city)', function(data){
            //改变县区
            $('#area').html('<option value="0"><?php echo \think\Lang::get('look_address_area'); ?></option>');
            var province = $('#province').find('option:selected').val();
            $.ajax({
                type:'POST',
                url:ADMIN_URL+'Common/get_address_school?province='+province+'&city='+data.value,
                success:function(data){
                    var province_html = $('#province').find('option:selected').html();
                    var city_html = $('#city').find('option:selected').html();
                    $('#area_info').val(province_html+city_html);
                    data = jQuery.parseJSON(data);
                    //改变县区
                    $('#area').html(data.area);
                    form.render('select');//select是固定写法 不是选择器
                }
            })
        });
        //县/区
        form.on('select(area)', function(data){
            var province = $('#province').find('option:selected').val();
            var city = $('#city').find('option:selected').val();
            $.ajax({
                type:'POST',
                url:ADMIN_URL+'Common/get_address_school?province='+province+'&city='+city+'&area='+data.value,
                success:function(data){
                    var province_html = $('#province').find('option:selected').html();
                    var city_html = $('#city').find('option:selected').html();
                    var area_html = $('#area').find('option:selected').html();
                    $('#area_info').val(province_html+city_html+area_html);
                    data = jQuery.parseJSON(data);
                    form.render('select');//select是固定写法 不是选择器
                }
            })
        });

    });
    $(function() {
        $("#submitBtn").click(function() {
            if ($("#user_form").valid()) {
                $("#user_form").submit();
            }
        });
    });
    $(function() {
        //按钮先执行验证再提交表单
        $("#submitBtn").click(function() {
            if ($("#user_form").valid()) {
                $("#user_form").submit();
            }
        });
        $.datepicker.regional["zh-CN"] = { closeText: "关闭", prevText: "&#x3c;上月", nextText: "下月&#x3e;", currentText: "今天", monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"], monthNamesShort: ["一", "二", "三", "四", "五", "六", "七", "八", "九", "十", "十一", "十二"], dayNames: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"], dayNamesShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"], dayNamesMin: ["日", "一", "二", "三", "四", "五", "六"], weekHeader: "周", dateFormat: "yy-mm-dd", firstDay: 1, isRTL: !1, showMonthAfterYear: !0, yearSuffix: "年" }
        $.datepicker.setDefaults($.datepicker.regional["zh-CN"]);

        $("#activity_start_date").datepicker({dateFormat: 'yy-mm-dd'});
        $("#activity_end_date").datepicker({dateFormat: 'yy-mm-dd'});
        $('#user_form').validate({

            errorPlacement: function(error, element) {
                error.appendTo(element.parent().parent().prev().find('td:first'));
            },
            rules: {
                school_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
//                    remote: {
//                        url: "<?php echo url('Admin/school/ajax',['branch'=>'check_user_name']); ?>",
//                        type: 'get',
//                        data: {
//                            user_name: function() {
//                                return $('#school_name').val();
//                            },
//                            area_id: function () {
//                                return $('#area_id').val();
//                            }
//                        }
//                    }
                },
                school_phone:{
                    required: true,
                    minlength: 8,
                    maxlength: 12
                },
                school_username:{
                    required: true
                },
                school_address:{
                    required: true
                },
                school_type:{
                    required: true
                },
                school_dieline:{
                    required: true
                },
                typeid:{
                    required: true
                }
            },
            messages: {
                school_name: {
                    required: '<?php echo \think\Lang::get('school_add_sname_null'); ?>',
                    maxlength: '<?php echo \think\Lang::get('school_add_name_length'); ?>',
                    minlength: '<?php echo \think\Lang::get('school_add_name_length'); ?>',
                    //remote: '<?php echo \think\Lang::get('school_add_name_exists'); ?>'
                },
                school_phone: {
                    required: '<?php echo \think\Lang::get('school_add_phone_null'); ?>',
                    maxlength: '<?php echo \think\Lang::get('school_add_phone_length'); ?>',
                    minlength: '<?php echo \think\Lang::get('school_add_phone_length'); ?>',
                },
                school_username: {
                    required: '<?php echo \think\Lang::get('school_add_name_null'); ?>',
                },
                school_address: {
                    required: '<?php echo \think\Lang::get('school_add_address_null'); ?>',
                },
                school_type: {
                    required: '<?php echo \think\Lang::get('school_add_type_null'); ?>',
                },
                school_dieline: {
                    required: '<?php echo \think\Lang::get('school_dieline_null'); ?>',
                },
                typeid: {
                    required: '<?php echo \think\Lang::get('school_add_area_null'); ?>',
                }
            }
        });
    });
    $(function(){
        $('#school_dieline').datepicker({dateFormat: 'yy-mm-dd'});
    });

    $(function() {
        regionInit("region");
    });
</script>