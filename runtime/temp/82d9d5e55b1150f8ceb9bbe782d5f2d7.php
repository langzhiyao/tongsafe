<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:71:"/home/www/chenganxjh/public/../application/admin/view/classes/edit.html";i:1561518092;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
        
    

        


<script src="<?php echo \think\Config::get('url_domain_root'); ?>static/common/js/mlselection2.js"></script>
<script src="<?php echo \think\Config::get('url_domain_root'); ?>static/home/js/common.js"></script>
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
                <h3>班级管理</h3>
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
            <li>修改班级信息。</li>
        </ul>
    </div>


    <form id="user_form" enctype="multipart/form-data" method="post" class="layui-form">
        <div class="ncap-form-default">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('school_index_schoolregion'); ?>：</label>
                    <div class="layui-input-inline">
                        <select  lay-filter="province" class="select" disabled lay-verify="type" name="province" id="province">
                            <option value=""><?php echo \think\Lang::get('look_address_province'); ?></option>
                            <?php if(is_array($region_list) || $region_list instanceof \think\Collection || $region_list instanceof \think\Paginator): $i = 0; $__LIST__ = $region_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $vo['area_id']; ?>" <?php if($vo['area_id'] == $class_array["school_provinceid"]){echo 'selected';}?> ><?php echo $vo['area_name']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                    <div class="layui-input-inline">
                        <select name="city" lay-filter="city" disabled class="select"  lay-verify="type"  id="city">
                            <option value=""><?php echo \think\Lang::get('look_address_city'); ?></option>
                        </select>
                    </div>
                    <div class="layui-input-inline">
                        <select name="area" lay-filter="area" disabled class="select"  lay-verify="type"  id="area">
                            <option value=""><?php echo \think\Lang::get('look_address_area'); ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <input  name="classid" value="<?php echo $class_array['classid']; ?>" type="hidden">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('school_index_checkname'); ?>：</label>
                    <div class="layui-input-inline">
                        <select  lay-filter="school" disabled class="select"  lay-verify="type" name="school" id="school">
                            <option value=""><?php echo \think\Lang::get('school_index_allschool'); ?></option>
                        </select>
                    </div>
                    <div class="layui-input-inline">
                        <select name="grade" lay-filter="grade"   class="select"  lay-verify="type"  id="grade">
                            <option value=""><?php echo \think\Lang::get('school_index_type'); ?></option>
                        </select>
                    </div>
                    <div class="layui-input-inline">
                        <select name="position" lay-filter="position"  class="select"  lay-verify="type"  id="position">
                            <option value=""><?php echo \think\Lang::get('school_index_positionname'); ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('school_index_classname'); ?>：</label>
                    <div class="layui-input-inline">
                        <input type="text" id="school_class_name" value="<?php echo $class_array['classname'];?>" name="school_class_name" class="layui-input">
                        <span class="err"></span>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('school_index_desc'); ?>：</label>
                    <div class="layui-input-inline">
                        <textarea id="class_desc" name="class_desc" class="layui-text"><?php echo $class_array['desc'];?></textarea>
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
<script type="text/javascript">
    layui.use(['form','laypage', 'layer'], function(){
        var form = layui.form,
            laypage = layui.laypage
            ,layer = layui.layer;
        //省 市 区
        var province = '<?php if(!empty($class_array["school_provinceid"])){echo $class_array["school_provinceid"];}?>';
        var city = '<?php if(!empty($class_array["school_cityid"])){echo $class_array["school_cityid"];}?>';
        var area = '<?php if(!empty($class_array["school_areaid"])){echo $class_array["school_areaid"];}?>';
        //学校 年级 班级
        var school = '<?php if(!empty($class_array["schoolid"])){echo $class_array["schoolid"];}?>';
        var grade = '<?php if(!empty($class_array["typeid"])){echo $class_array["typeid"];}?>';
        var position = '<?php if(!empty($class_array["position_id"])){echo $class_array["position_id"];}?>';
        if(province != 0){
            $.ajax({
                type:'POST',
                url:ADMIN_URL+'Common/get_address_school?province='+province+'&city='+city+'&area='+area+'&school='+school,
                success:function(data){
                    data = jQuery.parseJSON(data);
                    //改变市区
                    $('#city').html(data.city);
                    //改变县区
                    $('#area').html(data.area);
                    //改变学校
                    $('#school').html(data.school);
                    //改变年级
                    $('#grade').html(data.grade);
                    //改变房间位置
                    $('#position').html(data.position);
                    form.render('select');//select是固定写法 不是选择器
                }
            })
        }

        if(school != 0){
            $.ajax({
                type:'POST',
                url:ADMIN_URL+'Common/get_school_info2?school='+school+'&grade='+grade+'&position='+position,
                success:function(data){
                    data = jQuery.parseJSON(data);
                    //改变年级
                    $('#grade').html(data.grade);
                    //改变房间位置
                    $('#position').html(data.position);
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
            //改变年级
            $('#grade').html('<option value="0"><?php echo \think\Lang::get('look_address_grade'); ?></option>');
            //改变房间位置
            $('#position').html('<option value="0"><?php echo \think\Lang::get('school_index_positionname'); ?></option>');
            $.ajax({
                type:'POST',
                url:ADMIN_URL+'Common/get_address_school?province='+data.value,
                success:function(data){
                    data = jQuery.parseJSON(data);
                    var province_name = $('#province').find('option:selected').html();
                    $('#area_info').val(province_name);
                    //改变市区
                    $('#city').html(data.city);
                    //改变县区
                    $('#area').html(data.area);
                    //改变学校
                    $('#school').html(data.school);
                    //改变年级
                    $('#grade').html(data.grade);
                    //改变房间位置
                    $('#position').html(data.position);
                    form.render('select');//select是固定写法 不是选择器
                }
            })
        });
        //市
        form.on('select(city)', function(data){
            //改变县区
            $('#area').html('<option value="0"><?php echo \think\Lang::get('look_address_area'); ?></option>');
            //改变年级
            $('#grade').html('<option value="0"><?php echo \think\Lang::get('look_address_grade'); ?></option>');
            //改变班级
            $('#class').html('<option value="0"><?php echo \think\Lang::get('look_address_class'); ?></option>');
            //改变房间位置
            $('#position').html('<option value="0"><?php echo \think\Lang::get('school_index_positionname'); ?></option>');
            var province = $('#province').find('option:selected').val();
            $.ajax({
                type:'POST',
                url:ADMIN_URL+'Common/get_address_school?province='+province+'&city='+data.value,
                success:function(data){
                    data = jQuery.parseJSON(data);
                    var province_name = $('#province').find('option:selected').html();
                    var city_name = $('#city').find('option:selected').html();
                    $('#area_info').val(province_name+city_name);
                    //改变县区
                    $('#area').html(data.area);
                    //改变学校
                    $('#school').html(data.school);
                    //改变年级
                    $('#grade').html(data.grade);
                    //改变房间位置
                    $('#position').html(data.position);
                    form.render('select');//select是固定写法 不是选择器
                }
            })
        });
        //县/区
        form.on('select(area)', function(data){
            //改变年级
            $('#grade').html('<option value="0"><?php echo \think\Lang::get('look_address_grade'); ?></option>');
            //改变班级
            $('#class').html('<option value="0"><?php echo \think\Lang::get('look_address_class'); ?></option>');
            //改变房间位置
            $('#position').html('<option value="0"><?php echo \think\Lang::get('school_index_positionname'); ?></option>');
            var province = $('#province').find('option:selected').val();
            var city = $('#city').find('option:selected').val();
            $.ajax({
                type:'POST',
                url:ADMIN_URL+'Common/get_address_school?province='+province+'&city='+city+'&area='+data.value,
                success:function(data){
                    data = jQuery.parseJSON(data);
                    var province_name = $('#province').find('option:selected').html();
                    var city_name = $('#city').find('option:selected').html();
                    var area_name = $('#area').find('option:selected').html();
                    $('#area_info').val(province_name+city_name+area_name);
                    //改变学校
                    $('#school').html(data.school);
                    //改变年级
                    $('#grade').html(data.grade);
                    //改变房间位置
                    $('#position').html(data.position);
                    form.render('select');//select是固定写法 不是选择器
                }
            })
        });
        //学校
        form.on('select(school)', function(data){
            //改变年级
            $('#grade').html('<option value="0"><?php echo \think\Lang::get('look_address_grade'); ?></option>');
            //改变班级
            $('#class').html('<option value="0"><?php echo \think\Lang::get('look_address_class'); ?></option>');
            //改变房间位置
            $('#position').html('<option value="0"><?php echo \think\Lang::get('school_index_positionname'); ?></option>');
            $.ajax({
                type:'POST',
                url:ADMIN_URL+'Common/get_school_info2?school='+data.value,
                success:function(data){
                    data = jQuery.parseJSON(data);
                    //改变年级
                    $('#grade').html(data.grade);
                    //改变房间位置
                    $('#position').html(data.position);
                    form.render('select');//select是固定写法 不是选择器
                }
            })
        });

    });
    $(function(){
        $("#region_choose").click(function() {
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
        $('#user_form').validate({
            errorPlacement: function(error, element) {
                error.appendTo(element.nextAll('span.err'));
            },
            rules: {
                school_name: {
                    required: true
                },
                school_class_name: {
                    required: true,
//                    remote: {
//                        url: "<?php echo url('Admin/classes/ajax',['branch'=>'check_user_name']); ?>",
//                        type: 'get',
//                        data: {
//                            class_name: function() {
//                                return $('#school_class_name').val();
//                            },
//                            school_id: function () {
//                                return $('#school_id').val();
//                            }
//                        }
//                    }
                },
                classtype: {
                    required: true
                },
                typeid: {
                    required: true
                }
            },
            messages: {
                school_name: {
                    required: '<?php echo \think\Lang::get('school_add_sname_null'); ?>'
                },
                school_class_name: {
                    required: '<?php echo \think\Lang::get('school_add_class_null'); ?>',
                    //remote: '<?php echo \think\Lang::get('class_add_name_exists'); ?>'
                },
                classtype: {
                    required: '<?php echo \think\Lang::get('school_add_type_null'); ?>'
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
