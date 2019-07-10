<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:72:"/home/www/chenganxjh/public/../application/admin/view/company/index.html";i:1561455123;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
        
    

        


<script src="<?php echo \think\Config::get('url_domain_root'); ?>static/common/js/mlselectiones.js"></script>
<script src="<?php echo \think\Config::get('url_domain_root'); ?>static/home/js/common.js"></script>
<link rel="stylesheet" href="<?php echo \think\Config::get('url_domain_root'); ?>static/plugins/layer/css/layui.css">
<style>
    .align-center{
        text-align: center;
    }
</style>
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>

<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>分/子公司管理</h3>
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
            <li>分/子公司信息展示。</li>
        </ul>
    </div>
    <form method="get" name="formSearch" id="formSearch" class="layui-form">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('ds_organize_name'); ?></label>
                    <div class="layui-input-block">
                        <input type="text"  name="search_organize_name" placeholder="请输入代理商名称"  id="search_organize_name" value="<?php echo $_GET['search_organize_name']; ?>" autocomplete="off" class="layui-input">
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
                    <button class="layui-btn layuiadmin-btn-admin" lay-submit="" type="submit" lay-filter="LAY-user-back-search">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>


    <form method='post' onsubmit="if(confirm('<?php echo \think\Lang::get('ds_ensure_del'); ?>')){return true;}else{return false;}" name="brandForm">
        <?php if(session('admin_is_super') ==1 || in_array(7,$action)){?>
            <div style="text-align:right;"><a class="btns layui-btn layui-btn-sm"  href="<?php echo url('company/export_step1',['o_name'=>$search_organize_name,'o_provinceid'=>$o_provinceid,'o_cityid'=>$o_cityid,'area_id'=>$area_id]); ?>" id="ncexport"><span><?php echo \think\Lang::get('ds_export'); ?>Excel</span></a></div>
        <?php }?>
        <table class="layui-table">
            <colgroup>
                <col >
                <col >
                <col>
            </colgroup>
            <thead>
            <tr class="thead">
                <th class="w272" style="text-align: center;"><?php echo \think\Lang::get('ds_number'); ?></th>
                <th class="w172" style="text-align: center;"><?php echo \think\Lang::get('ds_organize_name'); ?></th>
                <th class="w272" style="text-align: center;"><?php echo \think\Lang::get('organize_index_address'); ?></th>
                <th class="w272" style="text-align: center;"><?php echo \think\Lang::get('ds_organize_time'); ?></th>
                <?php if(session('admin_is_super') ==1 || in_array(4,$action) || in_array(3,$action) || in_array(2,$action) || in_array(6,$action)){?>
                <th class="w172" style="text-align: center;"><?php echo \think\Lang::get('ds_handle'); ?></th>
                <?php }?>
                <th class="w172" style="text-align: center;"><?php echo \think\Lang::get('ds_organize_remark'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php if(!(empty($organize_list) || (($organize_list instanceof \think\Collection || $organize_list instanceof \think\Paginator ) && $organize_list->isEmpty()))): if(is_array($organize_list) || $organize_list instanceof \think\Collection || $organize_list instanceof \think\Paginator): $i = 0; $__LIST__ = $organize_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <tr class="hover edit">
                <td class="sort align-center"><?php echo $key+1; ?></td>
                <td class="name align-center"><?php echo $v['o_name']; ?></td>
                <td class="class align-center"><?php echo $v['o_area']; ?></td>
                <td class="picture align-center"><?php echo $v['o_createtime']; ?></td>
                <?php if(session('admin_is_super') ==1 || in_array(4,$action) || in_array(3,$action) || in_array(2,$action) || in_array(6,$action)){?>
                <td class="align-center">
                    <?php if(session('admin_is_super') ==1 || in_array(4,$action)){?>
                    <a href="javascript:dd(<?php echo $v['o_id']; ?>)" data-method="setTop" class="layui-btn layui-btn-xs"><?php echo \think\Lang::get('ds_view'); ?></a>
                    <?php }if(session('admin_is_super') ==1 || in_array(3,$action)){?>
                    <a href="<?php echo url('company/edit',['organize_id'=>$v['o_id']]); ?>" class="layui-btn layui-btn-xs"><?php echo \think\Lang::get('ds_edit'); ?></a>
                    <?php }if(session('admin_is_super') ==1 || in_array(2,$action)){?>
                    <a href="javascript:void(0)" onclick="if(confirm('<?php echo \think\Lang::get('ds_ensure_del'); ?>'))
                        location.href='<?php echo url('company/del',['o_id'=>$v['o_id']]); ?>';" class="layui-btn layui-btn-xs"><?php echo \think\Lang::get('ds_del'); ?></a>
                    <?php }if(session('admin_is_super') ==1 || in_array(6,$action)){?>
                    <a href="javascript:jia(<?php echo $v['o_role']; ?>,<?php echo $v['o_id']; ?>)" class="layui-btn layui-btn-xs" id="parentIframe"><?php echo \think\Lang::get('ds_organize_assign'); ?></a>
                    <?php }?>
                </td>
                <?php }?>
                <td class="align-center"><?php echo $v['o_remark']; ?></td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; else: ?>
            <tr class="no_data">
                <td colspan="10"><?php echo \think\Lang::get('ds_no_record'); ?></td>
            </tr>
            <?php endif; ?>
            </tbody>

        </table>
        <tfoot>
        <?php if(!(empty($organize_list) || (($organize_list instanceof \think\Collection || $organize_list instanceof \think\Paginator ) && $organize_list->isEmpty()))): ?>
        <tr colspan="15" class="tfoot">
            <td colspan="16">
                <div class="pagination"> <?php echo $page; ?> </div></td>
        </tr>
        <?php endif; ?>
        </tfoot>
    </form>
    <div class="clear"></div>
</div>
<script type="text/javascript" src="<?php echo config('url_domain_root'); ?>static/plugins/jquery.edit.js" charset="utf-8"></script>
<script>
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
        var urls=ADMIN_URL+'organizes/company?o_id='+id;
        //多窗口模式，层叠置顶
        layer.open({
            type: 2,
            title: '公司信息',
            area: ['80%', '80%'],
            shadeClose: true,
            shade: 0.4,
            maxmin: false, //开启最大化最小化按钮
            content: urls
        });
    }
    function jia(role,oid){
            var urls=ADMIN_URL+'organizes/admin_add?role_id='+role+'&o_id='+oid;
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
                var gid = $("#role").val();
                var oid=$("#oid").val();
                $.ajax({
                    url: "<?php echo url('/Admin/company/admin_add'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {'admin_name': admin_name,'admin_password':admin_password,'gid':gid,'oid':oid},
                    success:function(sb){
                        if (sb.m==true) {
                            layer.msg(sb.ms, {icon: 16,time: 500},function(){
                                window.location.href="<?php echo url('/Admin/Company/index'); ?>";
                            });
                        }else{
                            alert(sb.ms);
                            window.location.href="<?php echo url('/Admin/Company/index'); ?>";
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

