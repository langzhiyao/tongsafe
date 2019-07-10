<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:76:"/home/www/chenganxjh/public/../application/admin/view/classesinfo/lists.html";i:1561455123;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
            <li>共有学生：<?php echo count($student_list); ?>人。</li>
        </ul>
    </div>
    <table class="layui-table">
        <thead>
        <tr class="thead">
            <th colspan="align-center"><?php echo \think\Lang::get('school_index_id'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_index_studentname'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_edit_sex'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_index_studentidcard'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_index_susernamesuo'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_index_time'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_index_desc'); ?></th>
        </tr>
        <tbody>
        <?php if(!empty($student_list) && is_array($student_list)){ foreach($student_list as $k => $v){ ?>
        <tr class="hover member">
            <td class="align-center"><?php if(!$_GET['page']){  echo $k+1; }else{ echo ($_GET['page']-1)*10+$k+1; }?></td>
            <td class="align-center"><?php echo $v['s_name']; ?></td>
            <td class="align-center"><?php if($v['s_sex']==1){echo "男";}else{echo "女";} ?></td>
            <td class="align-center"><?php echo $v['s_card']; ?></td>
            <td class="align-center"><?php echo $v['member']; ?></td>
            <td class="align-center"><?php echo $v['s_createtime']; ?></td>
            <td class="align-center"><?php echo $v['s_remark']; ?></td>
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
    function dd(id) {
        var urls=ADMIN_URL+'school/view?school_id='+id;
        //多窗口模式，层叠置顶
        layer.open({
            type: 2
            , title: '学校信息'
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