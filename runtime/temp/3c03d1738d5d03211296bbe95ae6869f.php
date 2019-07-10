<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:72:"/home/www/chenganxjh/public/../application/admin/view/classes/index.html";i:1561455123;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
    <!-- 操作说明 -->
    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom">
            <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
            <span id="explanationZoom" title="收起提示" class="arrow"></span>
        </div>
        <ul>
            <li>班级信息展示。</li>
        </ul>
    </div>
    <form method="get" name="formSearch" id="formSearch" class="layui-form">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('school_index_classname'); ?></label>
                    <div class="layui-input-block">
                        <input type="text"  name="school_index_classname" placeholder="请输入班级名称"  id="school_index_classname" value="<?php echo $_GET['school_index_classname']; ?>" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <div class="layui-input-inline">
                        <select  lay-filter="province"  class="select"  lay-verify="type" name="province" id="province">
                            <option value="" selected><?php echo \think\Lang::get('look_address_province'); ?></option>
                            <?php if(is_array($region_list) || $region_list instanceof \think\Collection || $region_list instanceof \think\Paginator): $i = 0; $__LIST__ = $region_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $vo['area_id']; ?>" <?php if($vo['area_id'] == $_GET['province']){echo 'selected';}?> ><?php echo $vo['area_name']; ?></option>
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
                <div class="layui-inline">
                    <div class="layui-input-inline">
                        <select  lay-filter="school"  class="select"  lay-verify="type" name="school" id="school">
                            <option value="" selected><?php echo \think\Lang::get('school_index_allschool'); ?></option>
                            <?php if(is_array($schoolList) || $schoolList instanceof \think\Collection || $schoolList instanceof \think\Paginator): $i = 0; $__LIST__ = $schoolList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $vo['schoolid']; ?>" <?php if($vo['schoolid'] == $_GET['school']){echo 'selected';}?> ><?php echo $vo['name']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                    <div class="layui-input-inline">
                        <select name="grade" lay-filter="grade"  class="select"  lay-verify="type"  id="grade">
                            <option value=""><?php echo \think\Lang::get('school_index_type'); ?></option>
                        </select>
                    </div>
                    <div class="layui-input-inline">
                        <select name="class" lay-filter="class"  class="select"  lay-verify="type"  id="class">
                            <option value=""><?php echo \think\Lang::get('school_index_classname'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-admin" lay-submit="" type="submit" lay-filter="LAY-user-back-search">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
    <table class="layui-table">
        <colgroup>
            <col >
            <col >
            <col>
        </colgroup>
        <thead>
        <tr class="thead">
            <th colspan="align-center"><?php echo \think\Lang::get('school_index_id'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_index_classname'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_index_classunique'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_index_name'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_index_region'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_index_time'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_index_desc'); ?></th>
            <?php  if(session('admin_is_super') ==1 || (in_array('4',$action) || in_array('3',$action) || in_array('2',$action) || in_array('11',$action))){?>
            <th class="align-center"><?php echo \think\Lang::get('ds_handle'); ?></th>
            <?php } ?>
        </tr>
        <tbody>
        <?php if(!empty($class_list) && is_array($class_list)){ foreach($class_list as $k => $v){ ?>
        <tr class="hover member">
            <td class="align-center"><?php if(!$_GET['page']){  echo $k+1; }else{ echo ($_GET['page']-1)*15+$k+1; }?></td>
            <?php if($v['typename']){ ?>
            <td class="align-center"><?php echo $v['typename']; ?>-<?php echo $v['classname']; ?></td>
            <?php }else{ ?>
            <td class="align-center"><?php echo $v['classname']; ?></td>
            <?php } ?>
            <td class="align-center"><?php echo $v['classCard']; ?></td>
            <td class="align-center"><?php echo $v['schoolname']; ?></td>
            <td class="align-center"><?php echo $v['school_region']; ?></td>
            <td class="align-center"><?php echo $v['createtime']; ?></td>
            <td class="align-center"><?php echo $v['desc']; ?></td>
            <td class="align-center">
                <?php if(session('admin_is_super') ==1 || in_array('4',$action)){ ?>
                <a href="javascript:dd(<?php echo $v['classid']; ?>)" class="layui-btn layui-btn-xs""><?php echo \think\Lang::get('ds_view'); ?></a>
                <?php } if(session('admin_is_super') ==1 || in_array('3',$action)){ ?>
                <a href="<?php echo url('/admin/classes/edit',['class_id'=>$v['classid']]); ?>" class="layui-btn layui-btn-xs"><?php echo \think\Lang::get('ds_edit'); ?></a>
                <?php } if(session('admin_is_super') ==1 || in_array('2',$action)){ ?>
                <a href="javascript:void(0)" onclick="if(confirm('<?php echo \think\Lang::get('ds_ensure_del'); ?>'))
                location.href='<?php echo url('/admin/classes/drop',['class_id'=>$v['classid']]); ?>';" class="layui-btn layui-btn-xs"><?php echo \think\Lang::get('ds_del'); ?></a>
                <?php } if(session('admin_is_super') ==1 || in_array('11',$action)){ ?>
                <a href="<?php echo url('/admin/classes/addstudent',['class_id'=>$v['classid']]); ?>" class="layui-btn layui-btn-xs"><?php echo \think\Lang::get('school_class_studentadd'); ?></a>
                <?php } ?>
            </td>
        </tr>
        <?php } }else { ?>
        <tr class="no_data">
            <td colspan="11"><?php echo \think\Lang::get('ds_no_record'); ?></td>
        </tr>
        <?php } ?>
        </tbody>
        <tfoot class="tfoot">
        <?php if(!empty($member_list) && is_array($member_list)){ ?>
        <tr>
            <td class="w24"><input type="checkbox" class="checkall" id="checkallBottom"></td>
            <td colspan="16">
                <label for="checkallBottom"><?php echo \think\Lang::get('ds_select_all'); ?></label>
                &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo \think\Lang::get('ds_ensure_del'); ?>')){$('#form_member').submit();}"><span><?php echo \think\Lang::get('ds_del'); ?></span></a>
            </td>
        </tr>
        <?php } ?>
        </tfoot>
    </table>
    <?php echo $page; ?>
    
</div>

<script type="text/javascript">
    layui.use(['form','laypage', 'layer'], function(){
        var form = layui.form,
            laypage = layui.laypage
            ,layer = layui.layer;
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
                url:ADMIN_URL+'Common/get_school_info2?school='+school+'&grade='+grade+'&class='+class_name,
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
                url:ADMIN_URL+'Common/get_school_info2?school='+data.value,
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
                url:ADMIN_URL+'Common/get_school_info2?school='+school+'&grade='+data.value,
                success:function(data){
                    data = jQuery.parseJSON(data);
                    //改变班级
                    $('#class').html(data.class);
                    form.render('select');//select是固定写法 不是选择器
                }
            })
        });
    });
    function dd(id) {
        var urls=ADMIN_URL+'classesinfo/index?class_id='+id;
        //多窗口模式，层叠置顶
        layer.open({
            type: 2
            , title: '查看'
            , area: ['80%', '80%']
            , shade: 0
            , maxmin: true
            , content: urls

        });
    }

    $(function() {
        regionInit("region");
    });
</script>