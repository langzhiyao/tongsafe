<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:75:"/home/www/chenganxjh/public/../application/admin/view/teachvideo/index.html";i:1558338271;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
                <h3>视频管理</h3>
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

    <form method="get" name="formSearch" id="formSearch">
        <table class="search-form">
            <tbody>
               <tr>
                   <td> <label><?php echo \think\Lang::get('teacher_index_videoupload'); ?>：</label></td>
                   <td><input type="text" name="user" value="<?php echo \think\Request::instance()->get('user'); ?>"></td>
                   <td> <select name="teacher_status" lay-verify="type" class="select">
                       <option value=""><?php echo \think\Lang::get('teacher_index_status'); ?></option>
                       <option value="1" <?php if(\think\Request::instance()->get('teacher_status') == 1): ?>selected='selected'<?php endif; ?>>待审核</option>
                       <option value="2" <?php if(\think\Request::instance()->get('teacher_status') == 2): ?>selected='selected'<?php endif; ?>>审核失败</option>
                       <option value="3" <?php if(\think\Request::instance()->get('teacher_status') == 3): ?>selected='selected'<?php endif; ?>>审核通过</option>
                   </select></td>
                   <td> <select name="type1" lay-verify="type1" class="select" onchange="fand_type2($(this))">
                            <option value=""><?php echo \think\Lang::get('teacher_index_videotypeone'); ?></option>
                            <?php if(is_array($teachtype) || $teachtype instanceof \think\Collection || $teachtype instanceof \think\Paginator): $i = 0; $__LIST__ = $teachtype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $type['gc_id']; ?>" <?php if(\think\Request::instance()->get('type1') == $type['gc_id']): ?>selected='selected'<?php endif; ?>><?php echo $type['gc_name']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select></td>

                   <td id="type2_list"> <select name="type2" lay-verify="type2" class="select" onchange="fand_type3($(this))">
                       <option value=""><?php echo \think\Lang::get('teacher_index_videotypetwo'); ?></option>
                       <?php if($teachtype2){ if(is_array($teachtype2) || $teachtype2 instanceof \think\Collection || $teachtype2 instanceof \think\Paginator): $i = 0; $__LIST__ = $teachtype2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?>
                           <option value="<?php echo $type['gc_id']; ?>" <?php if(\think\Request::instance()->get('type2') == $type['gc_id']): ?>selected='selected'<?php endif; ?>><?php echo $type['gc_name']; ?></option>
                           <?php endforeach; endif; else: echo "" ;endif; } ?>
                   </select></td>
                   <td id="type3_list"> <select name="type3" lay-verify="type" class="select" onchange="fand_type4($(this))">
                       <option value=""><?php echo \think\Lang::get('teacher_index_videotypethree'); ?></option>
                       <?php if($teachtype3){ if(is_array($teachtype3) || $teachtype3 instanceof \think\Collection || $teachtype3 instanceof \think\Paginator): $i = 0; $__LIST__ = $teachtype3;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?>
                       <option value="<?php echo $type['gc_id']; ?>" <?php if(\think\Request::instance()->get('type3') == $type['gc_id']): ?>selected='selected'<?php endif; ?>><?php echo $type['gc_name']; ?></option>
                       <?php endforeach; endif; else: echo "" ;endif; } ?>
                   </select></td>
                   <td id="type4_list"> <select name="type4" lay-verify="type" class="select">
                       <option value=""><?php echo \think\Lang::get('teacher_index_videotypefour'); ?></option>
                       <?php if($teachtype4){ if(is_array($teachtype4) || $teachtype4 instanceof \think\Collection || $teachtype4 instanceof \think\Paginator): $i = 0; $__LIST__ = $teachtype4;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?>
                       <option value="<?php echo $type['gc_id']; ?>" <?php if(\think\Request::instance()->get('type4') == $type['gc_id']): ?>selected='selected'<?php endif; ?>><?php echo $type['gc_name']; ?></option>
                       <?php endforeach; endif; else: echo "" ;endif; } ?>
                   </select></td>
                   <td> <label><?php echo \think\Lang::get('teacher_index_uploadtime'); ?>：</label></td>
                   <td>
                       <input type="text" class="txt date" name="query_start_time" id="query_start_time" value="<?php echo \think\Request::instance()->get('query_start_time'); ?>">
                       &nbsp;–&nbsp;
                       <input id="query_end_time" class="txt date" type="text" name="query_end_time" value="<?php echo \think\Request::instance()->get('query_end_time'); ?>">
                   </td>
                     <td class="layui-inline">   <input type="submit" class="submit" value="搜索">
                        <a href="<?php echo url('Teachvideo/index'); ?>" class="btns"><span><?php echo \think\Lang::get('ds_cancel_search'); ?></span></a>
                        </td>
               </tr>
            </tbody>
        </table>
    </form>
    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom">
            <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
            <span id="explanationZoom" title="收起提示" class="arrow"></span>
        </div>
        <ul>
            <li>系统平台全局设置,包括基础设置、购物、短信、邮件、水印和分销等相关模块。</li>
        </ul>
    </div>
    <table class="ds-default-table">
        <thead>
        <tr class="thead">
            <th colspan="align-center"><?php echo \think\Lang::get('teacher_index_id'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('teacher_index_videoimg'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('teacher_index_videoname'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('teacher_index_videotype'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('teacher_index_videoupload'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('teacher_index_relname'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('teacher_index_uploadtime'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('teacher_index_optiontime'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('teacher_index_status'); ?></th>
            <?php if(session('admin_is_super') ==1 || in_array('15',$action)){ ?>
            <th class="align-center">推荐</th>
            <?php }  if(session('admin_is_super') ==1 || in_array('15',$action)){?>
            <th class="align-center">审核</th>
            <?php }  if(session('admin_is_super') ==1 || in_array('3',$action) || in_array('2',$action)){?>
            <th class="align-center"><?php echo \think\Lang::get('ds_handle'); ?></th>
            <?php }?>
            <th class="align-center"><?php echo \think\Lang::get('teacher_index_desc'); ?></th>
        </tr>
        <tbody>
        <?php if(!empty($teach_list) && is_array($teach_list)){ foreach($teach_list as $k => $v){ ?>
        <tr class="hover member">
            <td class="align-center"><?php if(!$_GET['page']){  echo $k+1; }else{ echo ($_GET['page']-1)*15+$k+1; }?></td>
            <?php if(!empty($v['t_picture'])){ ?>
                <td class="align-center"><a href="javascript:imageBig(<?php echo $v['t_id']; ?>)"><img src="<?php echo $img_path; ?><?php echo $v['t_picture']; ?>" height="60px"></a></td>
            <?php }elseif(!empty($v['t_videoimg'])){ ?>
                <td class="align-center"><a href="javascript:imageBig(<?php echo $v['t_id']; ?>)"><img src="<?php echo $v['t_videoimg']; ?>" height="60px"></a></td>
            <?php } ?>
            <td class="align-center"><?php echo $v['t_title']; ?></td>
            <td class="align-center"><?php echo $v['type']; ?></td>
            <td class="align-center"><?php echo $v['member_mobile']; ?></td>
            <td class="align-center"><?php if($v['member_mobile']=="后台"){echo "后台";}else{echo $v['username'];} ?></td>
            <td class="align-center"><?php echo date("Y-m-d H:i:s",$v['t_maketime']); ?></td>
            <td class="align-center"><?php if($v['option_time']!=""){echo date("Y-m-d H:i:s",$v['option_time']);} ?></td>
            <td class="align-center"><?php if($v['t_audit']==1){
                                    echo "待审核";
                                    }elseif($v['t_audit']==2){
                                    echo "审核失败";
                                    }elseif($v['t_audit']==3){
                                    echo "审核通过";
                                    } ?></td>
            <?php if(session('admin_is_super') ==1 || in_array('15',$action)){ ?>
            <td class="align-center"> <?php if($v['t_recommend']==1){ ?>
                <a href="<?php echo url('/admin/teachvideo/recom',['t_id'=>$v['t_id'],'t_recommend'=>2]); ?>" class="layui-btn layui-btn-xs">推荐</a>
                <?php }else{ ?>
                <a href="<?php echo url('/admin/teachvideo/recom',['t_id'=>$v['t_id'],'t_recommend'=>1]); ?>" class="layui-btn layui-btn-xs">取消推荐</a>
                <?php } ?></td>
            <?php }  if(session('admin_is_super') ==1 || in_array('15',$action)){?>
            <td class="align-center">
                <?php if($v['t_audit']==1){ ?>
                <a href="<?php echo url('/admin/teachvideo/pass',['t_id'=>$v['t_id']]); ?>" class="layui-btn layui-btn-xs"><?php echo \think\Lang::get('teacher_index_pass'); ?></a>
                <?php }elseif($v['t_audit']==2){  ?>
                <a href="<?php echo url('/admin/teachvideo/pass',['t_id'=>$v['t_id']]); ?>" class="layui-btn layui-btn-xs"><?php echo \think\Lang::get('teacher_index_repass'); ?></a>
                <?php }else{ ?>
                <a href="javascript:(0)" class="layui-btn layui-btn-xs">无</a>
                <?php }  ?>
            </td>
            <?php } ?>
            <td class="align-center">
                <?php if(session('admin_is_super') ==1 || in_array('3',$action)){ ?>
                <a href="<?php echo url('/admin/teachvideo/edit',['video_id'=>$v['t_id']]); ?>" class="layui-btn layui-btn-xs"><?php echo \think\Lang::get('ds_edit'); ?></a>
                <?php } if(session('admin_is_super') ==1 || in_array('2',$action)){ ?>
                <a href="javascript:void(0)" onclick="if(confirm('<?php echo \think\Lang::get('ds_ensure_del'); ?>'))
                location.href='<?php echo url('/admin/teachvideo/del',['video_id'=>$v['t_id']]); ?>';" class="layui-btn layui-btn-xs"><?php echo \think\Lang::get('ds_del'); ?></a>
                <?php } ?>
            </td>
            <td class="align-center"><?php echo $v['t_desc']; ?></td>
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
    function imageBig(id) {
        var urls=ADMIN_URL+'teachvideo/view?id='+id;
        //多窗口模式，层叠置顶
        layer.open({
            type: 2,
            title: '图片详情',
            area: ['70%', '80%'],
            shadeClose: true,
            shade: 0.4,
            maxmin: false, //开启最大化最小化按钮
            content: urls
        });
    }
    function fand_type2(_sef) {
        var gc_id = $(_sef).val();
        if(gc_id){
            var url = SITE_URL + 'index.php/Admin/Teachvideo/fand_type';
            $.post(url, {'gc_id': gc_id}, function (data) {
                data=$.parseJSON( data );
                var type_length = data.length;
                var type_list = data;
                if (data) {
                    var select = '<select name="type2" class="select" onchange="fand_type3($(this))"><option value="">二级分类</option>';
                    if (type_length>0) {
                        for (var i = 0; i < type_length; i++) {
                            select += "<option value='" + type_list[i].gc_id + "'>" + type_list[i].gc_name + "</option>";
                        }
                    }
                    select +='</select>';
                    $("#type2_list").html(select);

                    var select = '<select name="type3" class="select"><option value="">三级分类</option>';
                    select +='</select>';
                    $("#type3_list").html(select);

                    var select = '<select name="type4" class="select"><option value="">四级分类</option>';
                    select +='</select>';
                    $("#type4_list").html(select);
                }else {
                    alert(data.message);
                }
            });
        }
    }
    function fand_type3(_sef) {
        var gc_id = $(_sef).val();
        if(gc_id){
            var url = SITE_URL + 'index.php/Admin/Teachvideo/fand_type';
            $.post(url, {'gc_id': gc_id}, function (data) {
                data=$.parseJSON( data );
                var type_length = data.length;
                var type_list = data;
                if (data) {
                    var select = '<select name="type3" class="select" onchange="fand_type4($(this))"><option value="">三级分类</option>';
                    if (type_length>0) {
                        for (var i = 0; i < type_length; i++) {
                            select += "<option value='" + type_list[i].gc_id + "'>" + type_list[i].gc_name + "</option>";
                        }
                    }
                    select +='</select>';
                    $("#type3_list").html(select);

                    var select = '<select name="type4" class="select"><option value="">四级分类</option>';
                    select +='</select>';
                    $("#type4_list").html(select);
                }else {
                    alert(data.message);
                }
            });
        }
    }
    function fand_type4(_sef) {
        var gc_id = $(_sef).val();
        if(gc_id){
            var url = SITE_URL + 'index.php/Admin/Teachvideo/fand_type';
            $.post(url, {'gc_id': gc_id}, function (data) {
                data=$.parseJSON( data );
                var type_length = data.length;
                var type_list = data;
                if (data) {
                    var select = '<select name="type4" class="select"><option value="">四级分类</option>';
                    if (type_length>0) {
                        for (var i = 0; i < type_length; i++) {
                            select += "<option value='" + type_list[i].gc_id + "'>" + type_list[i].gc_name + "</option>";
                        }
                    }
                    select +='</select>';
                    $("#type4_list").html(select);
                }else {
                    alert(data.message);
                }
            });
        }
    }
</script>
