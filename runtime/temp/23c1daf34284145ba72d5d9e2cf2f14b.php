<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:91:"/home/www/chenganxjh/public/../application/admin/view/articleclass/article_class_index.html";i:1558338271;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
                <h3>文章分类</h3>
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
            <li><?php echo lang('article_class_index_help1'); ?></li>
            <li><?php echo lang('article_class_index_help2'); ?></li>
        </ul>
    </div>
  <form method='post'>

    <table class="ds-default-table">
      <thead>
        <tr class="thead">
          <th class="w48"></th>
          <th class="w48"><?php echo lang('ds_sort'); ?></th>
          <th><?php echo lang('article_class_index_name'); ?></th>
          <th class="w96 align-center"><?php echo lang('ds_handle'); ?></th>
        </tr>
      </thead>
      <tbody id="treet1">
      <?php if(!(empty($class_list) || (($class_list instanceof \think\Collection || $class_list instanceof \think\Paginator ) && $class_list->isEmpty()))): if(is_array($class_list) || $class_list instanceof \think\Collection || $class_list instanceof \think\Paginator): $i = 0; $__LIST__ = $class_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
        <tr class="hover edit">
          <td>
            <?php if($v['ac_code'] == ''): ?>
            <input type="checkbox" name='check_ac_id[]' value="<?php echo $v['ac_id']; ?>" class="checkitem">
            <?php else: ?>
            <input name="" type="checkbox" disabled="disabled" value="" />
           <?php endif; if($v['have_child'] == '1'): ?>
            <img src="<?php echo config('url_domain_root'); ?>static/admin/images/treetable/tv-expandable.gif" fieldid="<?php echo $v['ac_id']; ?>" status="open" nc_type="flex">
            <?php else: ?>
            <img fieldid="<?php echo $v['ac_id'];?>" status="close" nc_type="flex" src="<?php echo config('url_domain_root'); ?>static/admin/images/treetable/tv-item.gif">
           <?php endif; ?>
          </td>
          <td class="sort">
            <span title="<?php echo lang('ds_editable'); ?>" ajax_branch='article_class_sort' datatype="number" fieldid="<?php echo $v['ac_id']; ?>" fieldname="ac_sort" nc_type="inline_edit" class="editable"><?php echo $v['ac_sort']; ?></span>
          </td>
          <td class="name">
            <span title="<?php echo lang('ds_editable'); ?>" required="1" fieldid="<?php echo $v['ac_id']; ?>" ajax_branch='article_class_name' fieldname="ac_name" nc_type="inline_edit" class="editable "><?php echo $v['ac_name']; ?></span>
            <a class='btn-add-nofloat marginleft' href="<?php echo url('articleclass/article_class_add',['ac_parent_id'=>$v['ac_id']]); ?>">
              <span><?php echo lang('ds_add_sub_class'); ?></span>
            </a>
          </td>
          <td class="align-center">
            <a href="<?php echo url('articleclass/article_class_edit',['ac_id'=>$v['ac_id']]); ?>"><?php echo lang('ds_edit'); ?></a>
            <?php if($v['ac_code'] == ''): ?>
            | <a href="javascript:if(confirm('<?php echo lang('article_class_index_ensure_del'); ?>'))window.location = '<?php echo url('articleclass/article_class_del',['ac_id'=>$v['ac_id']]); ?>';"><?php echo lang('ds_del'); ?></a>
           <?php endif; ?>
          </td>
        </tr>
       <?php endforeach; endif; else: echo "" ;endif; else: ?>
        <tr class="no_data">
          <td colspan="10"><?php echo lang('ds_no_record'); ?></td>
        </tr>
       <?php endif; ?>
      </tbody>
      <tfoot>
      <?php if(!(empty($class_list) || (($class_list instanceof \think\Collection || $class_list instanceof \think\Paginator ) && $class_list->isEmpty()))): ?>
        <tr>
          <td>
            <label for="checkall1">
              <input type="checkbox" class="checkall" id="checkall_2">
            </label>
          </td>
          <td colspan="16">
            <label for="checkall_2"><?php echo lang('ds_select_all'); ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo lang('article_class_index_ensure_del'); ?>')){$('form:first').submit();}">
            <span><?php echo lang('ds_del'); ?></span>
          </a>
          </td>
        </tr>
       <?php endif; ?>
      </tfoot>
    </table>
  </form>
</div>
<script src="<?php echo config('url_domain_root'); ?>/static/admin/js/article_class.js"></script>
