<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:75:"/home/www/chenganxjh/public/../application/admin/view/mbfeedback/index.html";i:1558338271;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
                <h3>意见反馈</h3>
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
    
    <div class="fixed-empty"></div>
    
    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom">
            <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
            <span id="explanationZoom" title="收起提示" class="arrow"></span>
        </div>
        <ul>
            <li>来自用户的反馈</li>
        </ul>
    </div>
    
    <form method='post' id="form_link">
        
        <table class="ds-default-table nobdb">
            <thead>
            <tr class="thead">
                <th>&nbsp;</th>
                <th><?php echo \think\Lang::get('feedback_index_content'); ?></th>
                <th>用户名</th>
                <th><?php echo \think\Lang::get('feedback_index_time'); ?></th>
                <th><?php echo \think\Lang::get('feedback_index_from'); ?></th>
                <th class="align-center"><?php echo \think\Lang::get('ds_handle'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php if(!(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty()))): if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <tr class="hover edit">
                <td class="w24"><input type="checkbox" name="del_id[]" value="<?php echo $v['id']; ?>" class="checkitem"></td>
                <td width="705px"><?php echo $v['content']; ?></td>
                <td><?php echo $v['member_name']; ?></td>
                <td><?php echo date('Y-m-d H:i:s',$v['ftime']); ?></td>
                <td><?php echo $v['type']; ?></td>
                <td class="w96 align-center"><a id="btn_delete" data-id="<?php echo $v['id']; ?>"><?php echo \think\Lang::get('ds_del'); ?></a></td>
            </tr>
           <?php endforeach; endif; else: echo "" ;endif; else: ?>
            <tr class="no_data">
                <td colspan="10"><?php echo \think\Lang::get('ds_no_record'); ?></td>
            </tr>
            <?php endif; ?>
            </tbody>
            <tfoot>
            <?php if(!(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty()))): ?>
            <tr class="tfoot" id="dataFuncs">
                <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
                <td colspan="16" id="batchAction"><label for="checkallBottom"><?php echo \think\Lang::get('ds_select_all'); ?></label>
                    &nbsp;&nbsp; <a href="JavaScript:void(0);" class="btn" id="btn_delete_batch"><span><?php echo \think\Lang::get('ds_del'); ?></span></a>
                    <div class="pagination"> <?php echo $page; ?> </div></td>
            </tr>
            <?php endif; ?>
            </tfoot>

        </table>
    </form>

</div>
<form id="delete_form" method="post" action="<?php echo url('mbfeedback/del'); ?>">
    <input id="feedback_id" name="feedback_id" type="hidden">
</form>
<script type="text/javascript">
    function submit_delete_batch(){
        /* 获取选中的项 */
        var items = '';
        $('.checkitem:checked').each(function(){
            items += this.value + ',';
        });
        if(items != '') {
            items = items.substr(0, (items.length - 1));
            submit_delete(items);
        }
        else {
            alert('<?php echo \think\Lang::get('ds_please_select_item'); ?>');
        }
    }
    function submit_delete(id){
        if(confirm('<?php echo \think\Lang::get('ds_ensure_del'); ?>')) {
            $('#feedback_id').val(id);
            $('#delete_form').submit();
        }
    }

    $(document).ready(function(){
        $('#btn_delete_batch').on('click', function() {
            submit_delete_batch();
        });

        $('#btn_delete').on('click', function() {
            submit_delete($(this).attr('data-id'));
        });
    });
</script>