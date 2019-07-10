<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:73:"/home/www/chenganxjh/public/../application/admin/view/teachvideo/add.html";i:1558338271;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
<script>
    function _(el){
        return document.getElementById(el);
    }
    function uploadFile(){
        var file = _("file1").files[0];
        // alert(file.name+" | "+file.size+" | "+file.type);
        var formdata = new FormData();
        formdata.append("file1", file);
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "<?php echo url('Admin/Teachvideo/video_data'); ?>");
        ajax.send(formdata);
    }

    function progressHandler(event){
//        _("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
        var percent = (event.loaded / event.total) * 100;
        _("progressBar").value = Math.round(percent);
        _("status").innerHTML = Math.round(percent)+"% 正在上传，请等待";
    }

    function completeHandler(event){
        var bbb=event.target.responseText;
        bbb = $.parseJSON( bbb );
        _("status").innerHTML = "上传成功";
        _("progressBar").value = 0;
        $("#path").val(bbb.path);
        $("#pic").val(bbb.pic);
        $("#time").val(bbb.time);
    }

    function errorHandler(event){
        _("status").innerHTML = "Upload Failed";
    }

    function abortHandler(event){
        _("status").innerHTML = "Upload Aborted";
    }
</script>
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
    
    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom">
            <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
            <span id="explanationZoom" title="收起提示" class="arrow"></span>
        </div>
        <ul>
            <li>系统平台全局设置,包括基础设置、购物、短信、邮件、水印和分销等相关模块。</li>
        </ul>
    </div>
    <br>
    <tr class="noborder">
        <td colspan="2" class="required"><label for="video_name">上传视频:</label></td>
    </tr>
    <tr class="noborder">
        <td class="vatop rowform">
            <input type="file" name="file1" id="file1"><br>
            <input type="button" value="点击上传视频" onclick="uploadFile()">
            <progress id="progressBar" value="0" max="100" style="width:300px;"></progress>
            <h3 id="status"></h3>
            <p id="loaded_n_total"></p></td>
        <td class="vatop tips"></td>
    </tr>
    <form id="user_form" enctype="multipart/form-data" method="post">

        <table class="ds-default-table">
            <tbody>
            <input type="hidden" name="path" value="" id="path">
            <input type="hidden" name="pic" value="" id="pic">
            <input type="hidden" name="time" value="" id="time">
            <tr>
                <td colspan="2" class="required"><label for="video_file"><?php echo \think\Lang::get('teacher_index_videoimgfirst'); ?>:</label></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform"><input type="file" name="video_filename" id="video_filename" /> </td>
                <td class="vatop tips"></td>
            </tr>
            <tr class="noborder">
                <td colspan="2" class="required"><label for="video_name">作者:</label></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform"><input type="text" value="" id="video_author" name="video_author" class="txt"></td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2" class="required"><label for="video_price"><?php echo \think\Lang::get('teacher_index_videoprice'); ?>:</label></td>
            </tr>

            <tr class="noborder">
                <td class="vatop rowform"><input type="text" value="" id="video_price" name="video_price" class="txt"></td>
                <td class="vatop tips"></td>
            </tr>
                <tr class="noborder">
                    <td colspan="2" class="required"><label for="video_name"><?php echo \think\Lang::get('teacher_index_videoname'); ?>:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="" name="video_name" id="video_name" class="txt"></td>
                    <td class="vatop tips"></td>
                </tr>
                <tr class="noborder">
                    <td colspan="2" class="required"><label><?php echo \think\Lang::get('teacher_index_videotype'); ?>:（提示：视频上传成功再选择类别）</label></td>
                    <td class="vatop tips"></td>
                </tr>
                <tr class="noborder">
                    <td id="video_type"> <select name="type1" lay-verify="type1" class="select" onchange="fand_type2($(this))">
                        <option value=""><?php echo \think\Lang::get('teacher_index_videotypeone'); ?></option>
                        <?php if(is_array($teachtype) || $teachtype instanceof \think\Collection || $teachtype instanceof \think\Paginator): $i = 0; $__LIST__ = $teachtype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $type['gc_id']; ?>" <?php if(\think\Request::instance()->get('type1') == $type['gc_id']): ?>selected='selected'<?php endif; ?>><?php echo $type['gc_name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                        <select id="type2_list" name="type2" lay-verify="type2" class="select" onchange="fand_type3($(this))">
                        <option value=""><?php echo \think\Lang::get('teacher_index_videotypetwo'); ?></option>
                        <?php if($teachtype2){ if(is_array($teachtype2) || $teachtype2 instanceof \think\Collection || $teachtype2 instanceof \think\Paginator): $i = 0; $__LIST__ = $teachtype2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $type['gc_id']; ?>" <?php if(\think\Request::instance()->get('type2') == $type['gc_id']): ?>selected='selected'<?php endif; ?>><?php echo $type['gc_name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; } ?>
                    </select>
                        <select id="type3_list" name="type3" lay-verify="type" class="select" onchange="fand_type4($(this))">
                            <option value=""><?php echo \think\Lang::get('teacher_index_videotypethree'); ?></option>
                            <?php if($teachtype3){ if(is_array($teachtype3) || $teachtype3 instanceof \think\Collection || $teachtype3 instanceof \think\Paginator): $i = 0; $__LIST__ = $teachtype3;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $type['gc_id']; ?>" <?php if(\think\Request::instance()->get('type3') == $type['gc_id']): ?>selected='selected'<?php endif; ?>><?php echo $type['gc_name']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; } ?>
                        </select>
                        <select id="type4_list" name="type4" lay-verify="type" class="select">
                            <option value=""><?php echo \think\Lang::get('teacher_index_videotypefour'); ?></option>
                            <?php if($teachtype4){ if(is_array($teachtype4) || $teachtype4 instanceof \think\Collection || $teachtype4 instanceof \think\Paginator): $i = 0; $__LIST__ = $teachtype4;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $type['gc_id']; ?>" <?php if(\think\Request::instance()->get('type4') == $type['gc_id']): ?>selected='selected'<?php endif; ?>><?php echo $type['gc_name']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; } ?>
                        </select></td>
                    <td class="vatop tips"></td>
                </tr>
            <tr>
                <td colspan="2" class="required"><label for="video_desc"><?php echo \think\Lang::get('teacher_index_videodesc'); ?>:</label></td>
            </tr>
            <tr class="noborder">
                <td class="vatop rowform"><input type="text" value="" id="t_profile" name="t_profile" class="txt"></td>
                <td class="vatop tips"></td>
            </tr>
                <tr>
                    <td colspan="2" class="required"><label for="video_desc">备注:</label></td>
                </tr>
                <tr class="noborder">
                    <td class="vatop rowform"><input type="text" value="" id="video_desc" name="video_desc" class="txt"></td>
                    <td class="vatop tips"></td>
                </tr>

            </tbody>
            <tfoot>
                <tr class="tfoot">
                    <td colspan="15"><input id="submitBtn" class="btn" type="submit" value="<?php echo \think\Lang::get('ds_submit'); ?>"/></td>
                </tr>
            </tfoot>
        </table>
    </form>

</div>

<script type="text/javascript">

    $(function() {
        //按钮先执行验证再提交表单
        $("#submitBtn").click(function () {
            if ($("#user_form").valid()) {
                $("#user_form").submit();
            }
            var pas1 =  $("#status").text();
            var objFile = $("#file1").val();
            if(pas1=="" || (objFile!="" && pas1!="上传成功")){
                alert("请确认已选择视频文件，“点击上传视频”，并等待上传");exit;
            }
        });
        $('#user_form').validate({

            errorPlacement: function(error, element) {
                error.appendTo(element.parent().parent().prev().find('td:first'));
            },
            rules: {
                file1: {
                    required: true
                },
                t_profile: {
                    required: true
                },
                video_type: {
                    required: true
                },
                video_file: {
                    required: true
                },
                video_price: {
                    required: true
                },
                video_author: {
                    required: true
                },
                status: {
                    required: true
                }
            },
            messages: {
                file1: {
                    required: '<?php echo \think\Lang::get('school_add_name_null'); ?>'
                },
                t_profile: {
                    required: '<?php echo \think\Lang::get('school_add_desc_null'); ?>'
                },
                video_type: {
                    required: '<?php echo \think\Lang::get('school_add_type_null'); ?>'
                },
                video_file: {
                    required: '<?php echo \think\Lang::get('school_add_file_null'); ?>'
                },
                video_price: {
                    required: '<?php echo \think\Lang::get('school_add_price_null'); ?>'
                },
                video_author: {
                    required: '作者不能为空，可自定义起名'
                },
                status: {
                    required: '请上传视频'
                }
            }
        });
    });
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
