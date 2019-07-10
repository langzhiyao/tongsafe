<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:71:"/home/www/chenganxjh/public/../application/admin/view/import/index.html";i:1558338271;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
                <h3><?php echo \think\Lang::get('student_title'); ?></h3>
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

    <form method="get" id='form_admin' class="layui-form">
        <div class="layui-form-item">
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <input name="name"  autocomplete="off" placeholder="请输入家长/学生姓名" value="<?php echo $_GET['name'];?>" class="layui-input" type="text">
                </div>
            </div>
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <select  lay-filter="province"  class="select"  lay-verify="type" name="province" id="province">
                        <option value="0" selected><?php echo \think\Lang::get('look_address_province'); ?></option>
                        <?php if(is_array($province) || $province instanceof \think\Collection || $province instanceof \think\Paginator): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $vo['area_id']; ?>" <?php if($vo['area_id'] == $_GET['province']){echo 'selected';}?> ><?php echo $vo['area_name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <div class="layui-input-inline">
                    <select name="city" lay-filter="city"  class="select"  lay-verify="type"  id="city">
                        <option value="0"><?php echo \think\Lang::get('look_address_city'); ?></option>
                    </select>
                </div>
                <div class="layui-input-inline">
                    <select name="area" lay-filter="area"  class="select"  lay-verify="type"  id="area">
                        <option value="0"><?php echo \think\Lang::get('look_address_area'); ?></option>
                    </select>
                </div>
            </div>
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <select name="school" lay-filter="school"  class="select"  lay-verify="type"  id="school">
                        <option value="0" selected=""><?php echo \think\Lang::get('look_address_school'); ?></option>
                        <?php if(is_array($school) || $school instanceof \think\Collection || $school instanceof \think\Paginator): $i = 0; $__LIST__ = $school;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $vo['schoolid']; ?>" <?php if($vo['schoolid'] == $_GET['school']){echo 'selected';}?> ><?php echo $vo['name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <div class="layui-input-inline">
                    <select name="grade" lay-filter="grade"  class="select"  lay-verify="type"  id="grade">
                        <option value="0"><?php echo \think\Lang::get('look_address_grade'); ?></option>
                    </select>
                </div>
                <div class="layui-input-inline">
                    <select name="class" lay-filter="class"  class="select"  lay-verify="type"  id="class">
                        <option value="0"><?php echo \think\Lang::get('look_address_class'); ?></option>
                    </select>
                </div>
            </div>
            <div class="layui-inline">
                <button class="layui-btn" data-type="reload"><?php echo \think\Lang::get('look_camera_search'); ?></button>
            </div>

        </div>
        <table class="layui-table">
            <colgroup>
                <col >
                <col >
                <col>
            </colgroup>
            <thead>
            <tr class="thead">
                <th colspan="15">
                    <p class="layui-table-tool-temp" ><?php echo \think\Lang::get('student_fail_number'); ?>：<span style="font-size: 24px;color: #D90909" id="count"></span> </p>
                    <div class="layui-table-tool-self">
                        <?php if(session('admin_is_super')==1 || in_array('9',$action)){?>
                        <a class="layui-btn layui-btn-sm" href="<?php echo \think\Config::get('url_domain_root'); ?>/static/admin/<?php echo \think\Lang::get('look_camera_download_mb'); ?>.xlsx"><?php echo \think\Lang::get('look_camera_download'); ?></a>
                        <?php }if(session('admin_is_super')==1 || in_array('8',$action)){?>
                        <a class="layui-btn layui-btn-sm " lay-event="getCheckData" id="Import"><?php echo \think\Lang::get('look_camera_import'); ?></a>
                        <?php }?>
                    </div>
                </th>
            </tr>
            </thead>
            <thead>
            <tr class="thead">
                <th class="align-center"><?php echo \think\Lang::get('member_mobile'); ?></th>
                <th class="align-center"><?php echo \think\Lang::get('member_name'); ?></th>
                <th class="align-center"><?php echo \think\Lang::get('member_sex'); ?></th>
                <th class="align-center"><?php echo \think\Lang::get('student_name'); ?></th>
                <th class="align-center"><?php echo \think\Lang::get('student_sex'); ?></th>
                <th class="align-center"><?php echo \think\Lang::get('student_card'); ?></th>
                <th class="align-center"><?php echo \think\Lang::get('school_name'); ?></th>
                <th class="align-center"><?php echo \think\Lang::get('school_type'); ?></th>
                <th class="align-center"><?php echo \think\Lang::get('class_name'); ?></th>
                <th class="align-center"><?php echo \think\Lang::get('area_name'); ?></th>
                <th class="align-center"><?php echo \think\Lang::get('import_time'); ?></th>
                <th class="align-center"><?php echo \think\Lang::get('t_name'); ?></th>
                <th class="align-center"><?php echo \think\Lang::get('t_price'); ?></th>
                <th class="align-center"><?php echo \think\Lang::get('t_day'); ?></th>
                <th class="align-center"><?php echo \think\Lang::get('ds_handle'); ?></th>
            </tr>
            </thead>
            <tbody id="html">
            </tbody>
        </table>
        <div style="float: right;">
            <tr class="tfoot">
                <div id="page"></div>
            </tr>
        </div>
    </form>
</div>
<script type="text/javascript">
    layui.use(['form','laypage', 'layer'], function(){
        var form = layui.form,
            laypage = layui.laypage
            ,layer = layui.layer;
        //关键字搜索
        var name = '<?php if(!empty($_GET["name"])){echo $_GET["name"];}?>';
        //省 市 区
        var province = '<?php if(!empty($_GET["province"])){echo $_GET["province"];}?>';
        var city = '<?php if(!empty($_GET["city"])){echo $_GET["city"];}?>';
        var area = '<?php if(!empty($_GET["area"])){echo $_GET["area"];}?>';
        //学校 年级 班级
        var school = '<?php if(!empty($_GET["school"])){echo $_GET["school"];}?>';
        var grade = '<?php if(!empty($_GET["grade"])){echo $_GET["grade"];}?>';
        var class_name = '<?php if(!empty($_GET["class"])){echo $_GET["class"];}?>';
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
                    //改变班级
                    $('#class').html(data.class);
                    form.render('select');//select是固定写法 不是选择器
                }
            })
        }

        if(school != 0){
            $.ajax({
                type:'POST',
                url:ADMIN_URL+'Common/get_import_school_info?school='+school+'&grade='+grade+'&class='+class_name,
                success:function(data){
                    data = jQuery.parseJSON(data);
                    //改变年级
                    $('#grade').html(data.grade);
                    //改变班级
                    $('#class').html(data.class);
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
            //改变班级
            $('#class').html('<option value="0"><?php echo \think\Lang::get('look_address_class'); ?></option>');

            $.ajax({
                type:'POST',
                url:ADMIN_URL+'Common/get_address_school?province='+data.value,
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
                    //改变班级
                    $('#class').html(data.class);
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
            var province = $('#province').find('option:selected').val();
            $.ajax({
                type:'POST',
                url:ADMIN_URL+'Common/get_address_school?province='+province+'&city='+data.value,
                success:function(data){
                    data = jQuery.parseJSON(data);
                    //改变县区
                    $('#area').html(data.area);
                    //改变学校
                    $('#school').html(data.school);
                    //改变年级
                    $('#grade').html(data.grade);
                    //改变班级
                    $('#class').html(data.class);
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
            var province = $('#province').find('option:selected').val();
            var city = $('#city').find('option:selected').val();
            $.ajax({
                type:'POST',
                url:ADMIN_URL+'Common/get_address_school?province='+province+'&city='+city+'&area='+data.value,
                success:function(data){
                    data = jQuery.parseJSON(data);
                    //改变学校
                    $('#school').html(data.school);
                    //改变年级
                    $('#grade').html(data.grade);
                    //改变班级
                    $('#class').html(data.class);
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
            $.ajax({
                type:'POST',
                url:ADMIN_URL+'Common/get_import_school_info?school='+data.value,
                success:function(data){
                    data = jQuery.parseJSON(data);
                    //改变年级
                    $('#grade').html(data.grade);
                    //改变班级
                    $('#class').html(data.class);
                    form.render('select');//select是固定写法 不是选择器
                }
            })
        });
        //年级
        form.on('select(grade)', function(data){
            //改变班级
            $('#class').html('<option value="0"><?php echo \think\Lang::get('look_address_class'); ?></option>');
            var school = $('#school').find('option:selected').val();
            $.ajax({
                type:'POST',
                url:ADMIN_URL+'Common/get_import_school_info?school='+school+'&grade='+data.value,
                success:function(data){
                    data = jQuery.parseJSON(data);
                    //改变班级
                    $('#class').html(data.class);
                    form.render('select');//select是固定写法 不是选择器
                }
            })
        });

        //分页
        laypage.render({
            elem: 'page'
            ,count: '<?php echo $list_count;?>'
            ,limit:10
            ,layout: ['count', 'prev', 'page', 'next',  'skip']
            ,jump: function(obj){
                // console.log(obj);
                var page = obj.curr,
                    page_count = obj.limit;
                $.ajax({
                    type:'POST',
                    url:ADMIN_URL+'Import/get_list.html?status=2',
                    data:{name:name,province:province,city:city,area:area,school:school,grade:grade,class:class_name,page:page,page_count:page_count},
                    success:function(data){
                        data = jQuery.parseJSON(data);
                        $('#html').html(data.html);
                        $('#count').html(data.count+'个');
                        $('.edit').click(function(){
                            var id = $(this).attr('data-id');
                            //页面层
                            layer.open({
                                type: 2,
                                title:'<?php echo \think\Lang::get('look_camera_import'); ?>',
                                area: ['1000px', '750px'],
                                fixed: false, //不固定
                                maxmin: true,
                                content: ADMIN_URL+'Import/edit.html?id='+id,
                            });
                        });
                    }
                })

            }
        });

    });

    $('#Import').click(function(){
        //页面层
        layer.open({
            type: 2,
            title:'<?php echo \think\Lang::get('look_camera_import'); ?>',
            area: ['1500px', '750px'],
            fixed: false, //不固定
            maxmin: true,
            content: ADMIN_URL+'Import/download.html',
        });
    });





</script>
