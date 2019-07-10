<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:75:"/home/www/chenganxjh/public/../application/admin/view/adminlog/loglist.html";i:1558338271;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
        
    

        


<div id="append_parent"></div>
<div id="ajaxwaitid"></div>

<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>操作日志</h3>
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
        <input type="hidden" name="delago" id="delago" value="">
        <table class="search-form">
            <tbody>
            <tr>
                <th><?php echo \think\Lang::get('admin_log_man'); ?></th>
                <td><input class="txt" name="admin_name" value="<?php echo \think\Request::instance()->get('admin_name'); ?>" type="text"></td>
                <th><?php echo \think\Lang::get('admin_log_dotime'); ?></th>
                <td><input class="txt date" type="text" value="<?php echo \think\Request::instance()->get('time_from'); ?>" id="time_from" name="time_from">
                    <label for="time_to">~</label>
                    <input class="txt date" type="text" value="<?php echo \think\Request::instance()->get('time_to'); ?>" id="time_to" name="time_to"/></td>
                <td><a href="javascript:void(0);" class="btn-search " title="<?php echo \think\Lang::get('ds_query'); ?>"></a>
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
            <li><?php echo \think\Lang::get('admin_log_tips2'); ?></li>
        </ul>
    </div>
    
    
    <form method="post" id='form_list' action="<?php echo url('adminlog/list_del'); ?>">
        <input type="hidden" name="form_submit" value="ok" />
        <div style="text-align:right;"><a class="btns" href="<?php echo url('adminlog/export_step1'); ?>"><span><?php echo \think\Lang::get('ds_export'); ?>Excel</span></a></div>
        <table class="ds-default-table">
            <thead>
            <tr class="thead">
                <th></th>
                <th><?php echo \think\Lang::get('admin_log_man'); ?></th>
                <th><?php echo \think\Lang::get('admin_log_do'); ?></th>

                <th class="align-center"><?php echo \think\Lang::get('admin_log_dotime'); ?></th>
                <th class="align-center">IP</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty()))): if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <tr class="hover">
                <td class="w24">
                    <input name="del_id[]" type="checkbox" class="checkitem" value="<?php echo $v['id']; ?>">
                </td>
                <td><?php echo $v['admin_name']; ?></td>
                <td><?php echo $v['content']; ?></td>
                <td class="align-center"><?php echo date("Y-m-d H:i:s",$v['createtime']); ?></td>
                <td class="align-center"><?php echo $v['ip']; ?></td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; else: ?>
            <tr class="no_data">
                <td colspan="10"><?php echo \think\Lang::get('ds_no_record'); ?></td>
            </tr>
            <?php endif; ?>
            </tbody>
            <tfoot>
            <?php if(!(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty()))): ?>
            <tr class="tfoot">
                <td><input type="checkbox" class="checkall" id="checkallBottom" name="chkVal"></td>
                <td colspan="16"><label for="checkallBottom"><?php echo \think\Lang::get('ds_select_all'); ?></label>
                    &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo \think\Lang::get('ds_ensure_del'); ?>')){$('#form_list').submit();}"><span><?php echo \think\Lang::get('ds_del'); ?></span></a>
                </td>
            </tr>
            <?php endif; ?>
            </tfoot>
        </table>
        <?php echo $page; ?>
    </form>

</div>

<script type="text/javascript">
    $(function(){
        $.datepicker.regional["zh-CN"] = { closeText: "关闭", prevText: "&#x3c;上月", nextText: "下月&#x3e;", currentText: "今天", monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"], monthNamesShort: ["一", "二", "三", "四", "五", "六", "七", "八", "九", "十", "十一", "十二"], dayNames: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"], dayNamesShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"], dayNamesMin: ["日", "一", "二", "三", "四", "五", "六"], weekHeader: "周", dateFormat: "yy-mm-dd", firstDay: 1, isRTL: !1, showMonthAfterYear: !0, yearSuffix: "年" }
        $.datepicker.setDefaults($.datepicker.regional["zh-CN"]);

        $('#time_from').datepicker({dateFormat: 'yy-mm-dd'});
        $('#time_to').datepicker({dateFormat: 'yy-mm-dd'});

        $('.btn-search').click(function(){
            var time_from = $('#time_from').val();
            time_from = new Date(time_from.replace("-", "/").replace("-", "/"));
            var time_to = $('#time_to').val();
            time_to = new Date(time_to.replace("_","/").replace("-","/"));
            if(time_to<time_from){
                alert('开始时间必须要大于结束时间');return false;
            }

            $('#formSearch').submit();
        })
    });
</script>