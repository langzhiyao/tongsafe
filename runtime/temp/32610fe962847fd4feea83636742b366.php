<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:75:"/home/www/chenganxjh/public/../application/admin/view/pkgs/pkgs_manage.html";i:1561530512;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
<link rel="stylesheet" href="<?php echo \think\Config::get('url_domain_root'); ?>static/plugins/layer/css/layui.css">

<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3><?php echo \think\Lang::get('packages_manage'); ?></h3>
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
    <!--<form method="get" action="" name="formSearch">
      <table class="search-form">
        <tbody>
          <tr>
            <th><label for="search_name"><?php echo \think\Lang::get('pkg_name'); ?></label></th>
            <td><input class="txt" type="text" name="search_name" id="search_name" value="<?php echo \think\Request::instance()->get('search_name'); ?>" /></td>
            <td>
                <a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo \think\Lang::get('ds_query'); ?>"></a>
            </td>
          </tr>
        </tbody>
      </table>
    </form>-->



    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom">
            <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
            <span id="explanationZoom" title="收起提示" class="arrow"></span>
        </div>
        <ul>
            <li><?php echo \think\Lang::get('pkg_help1'); ?></li>
            <li><?php echo \think\Lang::get('pkg_help2'); ?></li>
        </ul>
    </div>


    <form method="post" id="store_form">
        <input type="hidden" name="form_submit" value="ok" />
        <table class="layui-table">
            <thead>
            <tr class="thead">
                <!-- <th><input type="checkbox" class="checkall"/></th> -->
                <th class="align-center"><?php echo \think\Lang::get('pkg_sort'); ?></th>
                <th><?php echo \think\Lang::get('pkg_name'); ?></th>
                <th class="align-center"><?php echo \think\Lang::get('pkg_price'); ?></th>
                <th class="align-center"><?php echo \think\Lang::get('pkg_cprice'); ?></th>
                <th class="align-center"><?php echo \think\Lang::get('pkg_type'); ?></th>
                <th class="align-center"><?php echo \think\Lang::get('pkg_length'); ?></th>

                <?php  if(session('admin_is_super') ==1 || (in_array('13',$action) )){?>
                <th class="align-center"><?php echo \think\Lang::get('pkg_enabled'); ?></th>
                <?php } ?>

                <th class="align-center"><?php echo \think\Lang::get('uptime'); ?></th>
                <?php  if(session('admin_is_super') ==1 || (in_array('3',$action) || in_array('2',$action))){?>
                <th class="align-center"><?php echo \think\Lang::get('ds_handle'); ?></th>
                <?php } ?>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($pkg_list) && is_array($pkg_list)){ foreach($pkg_list as $k => $v){ ?>
            <tr class="hover">
                <!-- <td class="w24"><input type="checkbox" class="checkitem" name="del_id[]" value="<?php echo $v['pkg_id']; ?>" /></td> -->
                <td class="align-center"><?php echo $v['pkg_sort'];?></td>
                <td><span title="<?php echo $v['pkg_name'];?>"><?php echo str_cut($v['pkg_name'], '40');?></span></td>
                <td class="align-center"><?php echo $v['pkg_price'];?></td>
                <td class="align-center"><?php echo $v['pkg_cprice'];?></td>
                <td class="align-center"><?php
            switch ($v['pkg_type']) {
                case '1':
                    echo '看孩儿套餐';
                    break;
                default:
                    echo '重温课堂套餐';
                    break;
            }
            ?></td>
                <td class="align-center"><?php echo $v['pkg_length']." ".axisFomat($v['pkg_axis']);?></td>

                <td class="align-center yes-onoff">
                    <?php if(session('admin_is_super') ==1 || in_array('13',$action)){ if($v['pkg_enabled'] == '2'){ ?>
                    <a href="JavaScript:void(0);" class=" disabled" ajax_branch="pkg_enabled" nc_type="inline_edit" fieldname="pkg_enabled" fieldid="<?php echo $v['pkg_id']?>" fieldvalue="1" i_val='1' title="<?php echo \think\Lang::get('ds_editable'); ?>"><img src="<?php echo \think\Config::get('url_domain_root'); ?>static/admin/images/transparent.gif"></a>
                    <?php }else { ?>
                    <a href="JavaScript:void(0);" class=" enabled" ajax_branch="pkg_enabled" nc_type="inline_edit" fieldname="pkg_enabled" fieldid="<?php echo $v['pkg_id']?>" fieldvalue="2" i_val='2' title="<?php echo \think\Lang::get('ds_editable'); ?>"><img src="<?php echo \think\Config::get('url_domain_root'); ?>static/admin/images/transparent.gif"></a>
                    <?php } } ?>
                </td>

                <td class="align-center"><?php echo date('Y-m-d H:i:s', $v['up_time']);?></td>
                <td class="align-center">
                    <?php if(session('admin_is_super') ==1 || in_array('3',$action)){ ?>
                    <a class="layui-btn layui-btn-sm" href="<?php echo url('/Admin/Pkgs/pkgs_edit',['pkg_id'=>$v['pkg_id']]); ?>"><?php echo \think\Lang::get('ds_edit'); ?></a>
                    <?php } if(session('admin_is_super') ==1 || in_array('2',$action)){ ?>
                    <a class="layui-btn layui-btn-sm layui-btn-danger" href="<?php echo url('/Admin/Pkgs/pkgs_del',['pkg_id'=>$v['pkg_id']]); ?>"><?php echo \think\Lang::get('ds_del'); ?></a>
                    <?php } ?>
                </td>
            </tr>
            <?php } }else { ?>
            <tr class="no_data">
                <td colspan="15"><?php echo \think\Lang::get('ds_no_record'); ?></td>
            </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <!-- <tr class="tfoot">
              <td><input type="checkbox" class="checkall" id="checkall"/></td>
              <td id="batchAction" colspan="15"><span class="all_checkbox">
                <label for="checkall"><?php echo \think\Lang::get('ds_select_all'); ?></label>
                </span>&nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo \think\Lang::get('ap_del_sure'); ?>')){$('#store_form').submit();}"><span><?php echo \think\Lang::get('ds_del'); ?></span></a>
              </td>
            </tr> -->
            </tfoot>
        </table>
        <?php echo $page; ?>
    </form>
</div>
<script type="text/javascript" src="<?php echo \think\Config::get('url_domain_root'); ?>static/plugins/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo \think\Config::get('url_domain_root'); ?>static/plugins/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo \think\Config::get('url_domain_root'); ?>static/plugins/js/jquery-ui/jquery-ui.min.js"></script>
