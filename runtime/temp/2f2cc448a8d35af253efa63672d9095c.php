<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:72:"/home/www/chenganxjh/public/../application/admin/view/school/member.html";i:1561455123;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
        
    

        


<script src="<?php echo \think\Config::get('url_domain_root'); ?>static/common/js/mlselection.js"></script>
<script src="<?php echo \think\Config::get('url_domain_root'); ?>static/home/js/common.js"></script>
<link rel="stylesheet" href="<?php echo \think\Config::get('url_domain_root'); ?>static/plugins/layer/css/layui.css">
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
            <li>学校列表及信息展示。</li>
        </ul>
    </div>
    <form method="get" name="formSearch" id="formSearch" class="layui-form">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('school_name'); ?>：</label>
                    <div class="layui-input-block">
                        <input type="text"  name="schoolname" placeholder="请输入学校名称"  id="schoolname" value="<?php echo $_GET['schoolname']; ?>" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <div class="layui-input-inline">
                        <select name="school_type" lay-verify="type" class="select">
                            <option value=""><?php echo \think\Lang::get('school_index_type'); ?></option>
                            <?php if(is_array($schoolType) || $schoolType instanceof \think\Collection || $schoolType instanceof \think\Paginator): $i = 0; $__LIST__ = $schoolType;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $type['sc_id']; ?>" <?php if(\think\Request::instance()->get('school_type') == $type['sc_id']): ?>selected='selected'<?php endif; ?>><?php echo $type['sc_type']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
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
                    <button class="layui-btn layuiadmin-btn-admin" lay-submit="" class="submit" type="submit" lay-filter="LAY-user-back-search">
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
            <th class="align-center"><?php echo \think\Lang::get('school_index_name'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_index_region'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_index_address'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_index_unique'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_index_time'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_index_desc'); ?></th>
            <?php  if(session('admin_is_super') ==1 || (in_array('4',$action) || in_array('3',$action) || in_array('2',$action) || in_array('10',$action) || in_array('6',$action))){?>
            <th class="align-center"><?php echo \think\Lang::get('ds_handle'); ?></th>
            <?php }?>
        </tr>
        <tbody>
        <?php if(!empty($school_list) && is_array($school_list)){ foreach($school_list as $k => $v){ ?>
        <tr class="hover member">
            <td class="align-center"><?php if(!$_GET['page']){  echo $k+1; }else{ echo ($_GET['page']-1)*15+$k+1; }?></td>
            <td class="align-center"><?php echo $v['name']; ?></td>
            <td class="align-center"><?php echo $v['region']; ?></td>
            <td class="align-center"><?php echo $v['address']; ?></td>
            <td class="align-center"><?php echo $v['schoolCard']; ?></td>
            <td class="align-center"><?php echo $v['createtime']; ?></td>
            <td class="align-center"><?php echo $v['desc']; ?></td>
            <td class="align-center">
                <?php if(session('admin_is_super') ==1 || in_array('4',$action)){ ?>
                <a href="javascript:dd(<?php echo $v['schoolid']; ?>)" class="layui-btn layui-btn-xs"><?php echo \think\Lang::get('ds_view'); ?></a>
                <?php } if(session('admin_is_super') ==1 || in_array('3',$action)){ ?>
                <a href="<?php echo url('/admin/school/edit',['school_id'=>$v['schoolid']]); ?>" class="layui-btn layui-btn-xs"><?php echo \think\Lang::get('ds_edit'); ?></a>
                <?php } if(session('admin_is_super') ==1 || in_array('2',$action)){ ?>
                <a href="javascript:void(0)" onclick="if(confirm('<?php echo \think\Lang::get('ds_ensure_del'); ?>'))
                location.href='<?php echo url('/admin/school/drop',['school_id'=>$v['schoolid']]); ?>';" class="layui-btn layui-btn-xs"><?php echo \think\Lang::get('ds_del'); ?></a>
                <?php } if(session('admin_is_super') ==1 || in_array('18',$action)){ ?>
                <a href="<?php echo url('/admin/school/addposition',['school_id'=>$v['schoolid']]); ?>" class="layui-btn layui-btn-xs"><?php echo \think\Lang::get('school_position_add'); ?></a>
                <?php } if(session('admin_is_super') ==1 || in_array('10',$action)){ ?>
                <a href="<?php echo url('/admin/school/addclass',['school_id'=>$v['schoolid']]); ?>" class="layui-btn layui-btn-xs"><?php echo \think\Lang::get('school_class_add'); ?></a>
                <?php } if(session('admin_is_super') ==1 || in_array('6',$action)){ ?>
                <a href="javascript:jia(<?php echo $v['schoolid']; ?>,<?php echo $v['admin_company_id']; ?>)" class="layui-btn layui-btn-xs"><?php echo \think\Lang::get('ds_organize_assign'); ?></a>
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
                    data = jQuery.parseJSON(data);
                    form.render('select');//select是固定写法 不是选择器
                }
            })
        });

    });
    function dd(id) {
        var urls=ADMIN_URL+'schoolinfo/index?school_id='+id;
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

    function jia(admin_school_id,admin_company_id){
        var urls=ADMIN_URL+'schoolinfo/admin_add?school_id='+admin_school_id+'&company_id='+admin_company_id;
        //多窗口模式，层叠置顶
        layer.open({
            type: 2,
            title: '分配管理员账号',
            area: ['800px', '600px'],
            fixed: false, //不固定
            shadeClose: true,
            shade: 0.4,
            maxmin: false, //开启最大化最小化按钮
            content: urls
        });
    }
    $(function() {
        regionInit("region");
    });
    //按钮先执行验证再提交表
    $(document).ready(function() {

        layui.use(['form', 'layedit', 'laydate'], function() {
            var form = layui.form
        });
        //按钮先执行验证再提交表单
        $("#submitBtn").click(function() {
            if ($("#courForm").valid()) {
                //$("#courForm").submit();
                //$('.layui-layer-close1').click();
                var admin_name = $("#admin_name").val();
                var admin_password = $("#admin_password").val();
                var role=$("#role").val();
                var admin_company_id=$("#admin_company_id").val();
                $.ajax({
                    url: "<?php echo url('/Admin/school/admin_add'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {'admin_name': admin_name,'admin_password':admin_password,'role':role,'admin_company_id':admin_company_id},
                    success:function(sb){
                        if (sb.m) {
                            layer.msg(sb.ms, {icon: 16,time: 500},function(){
                                window.location.href="<?php echo url('/Admin/School/member'); ?>";
                            });

                        }
                    }
                });

            }
        });
        $("#courForm").validate({
            errorPlacement: function(error, element) {
                error.appendTo(element.nextAll('span.err'));
            },
            rules: {
                admin_name: {
                    required: true,
                    minlength: 5,
                    maxlength: 20,
                    remote: {
                        url: ADMIN_URL+'/School/ajax.html?branch=check_admin_name',
                        type: 'get',
                        data: {
                            admin_name: function() {
                                return $('#admin_name').val();
                            }
                        }
                    }
                },
                admin_password: {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                },
                admin_rpassword: {
                    required: true,
                    equalTo: '#admin_password'
                },
                gid: {
                    required: true
                }
            },
            messages: {
                admin_name: {
                    required: '<?php echo \think\Lang::get('admin_add_username_null'); ?>',
                    minlength: '<?php echo \think\Lang::get('admin_add_username_max'); ?>',
                    maxlength: '<?php echo \think\Lang::get('admin_add_username_max'); ?>',
                    remote: '<?php echo \think\Lang::get('admin_add_admin_not_exists'); ?>'
                },
                admin_password: {
                    required: '<?php echo \think\Lang::get('admin_add_password_null'); ?>',
                    minlength: '<?php echo \think\Lang::get('admin_add_password_max'); ?>',
                    maxlength: '<?php echo \think\Lang::get('admin_add_password_max'); ?>'
                },
                admin_rpassword: {
                    required: '<?php echo \think\Lang::get('admin_add_password_null'); ?>',
                    equalTo: '<?php echo \think\Lang::get('admin_edit_repeat_error'); ?>'
                },
                gid: {
                    required: '<?php echo \think\Lang::get('admin_add_gid_null'); ?>',
                }
            }
        });
    });
</script>
