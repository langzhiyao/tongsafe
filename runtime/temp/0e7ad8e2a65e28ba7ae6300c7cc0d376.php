<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:74:"/home/www/chenganxjh/public/../application/admin/view/teachtype/index.html";i:1558338271;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
                <h3>视频分类管理</h3>
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
            <li>点击分类名前“+”符号，显示当前分类的下级分类</li>
        </ul>
    </div>
    
  <form method='post'>
      <input type="hidden" id="admin_is_super" value='<?php echo session("admin_is_super");?>'>
      <input type="hidden" id="adminAction" value='<?php echo json_encode($action);?>'>
    <table class="ds-default-table">
        <input type="hidden" name="submit_type" id="submit_type" value="" />
      <thead>
        <tr class="thead">
          <th></th>
          <th><?php echo \think\Lang::get('ds_sort'); ?></th>
          <th><?php echo \think\Lang::get('teacher_type_index_name'); ?></th>
          <th><?php echo \think\Lang::get('teacher_type_index_type'); ?></th>
            <?php  if(session('admin_is_super') ==1 || in_array('3',$action) || in_array('2',$action)){?>
          <th><?php echo \think\Lang::get('ds_handle'); ?></th>
            <?php } ?>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($class_list) && is_array($class_list)){ foreach($class_list as $k => $v){ ?>
        <tr class="hover edit">
          <td class="w48"><input type="checkbox" name="check_gc_id[]" value="<?php echo $v['gc_id'];?>" class="checkitem">
            <?php if(isset($v['have_child']) && $v['have_child'] == '1'){ ?>
            <img fieldid="<?php echo $v['gc_id'];?>" status="open" nc_type="flex" src="<?php echo \think\Config::get('url_domain_root'); ?>static/admin/images/treetable/tv-expandable.gif">
            <?php }else{ ?>
            <img fieldid="<?php echo $v['gc_id'];?>" status="close" nc_type="flex" src="<?php echo \think\Config::get('url_domain_root'); ?>static/admin/images/treetable/tv-item.gif">
            <?php } ?></td>
          <td class="w48 sort"><span title="<?php echo \think\Lang::get('ds_editable'); ?>" ajax_branch="goods_class_sort" datatype="number" fieldid="<?php echo $v['gc_id'];?>" fieldname="gc_sort" nc_type="inline_edit" class="editable "><?php echo $v['gc_sort'];?></span></td>
          <td class="w50pre name">
          <span title="<?php echo \think\Lang::get('ds_editable'); ?>" required="1" fieldid="<?php echo $v['gc_id'];?>" ajax_branch="goods_class_name" fieldname="gc_name" nc_type="inline_edit" class="editable "><?php echo $v['gc_name'];?></span>
              <?php if(session('admin_is_super') ==1 || in_array('1',$action)){ ?>
              <a class="btn-add-nofloat marginleft" href="<?php echo url('/Admin/Teachtype/type_class_add',['gc_parent_id'=>$v['gc_id']]); ?>">
              <span><?php echo \think\Lang::get('ds_add_sub_class'); ?></span>
          </a>
              <?php } ?>
          </td>
          <td><?php echo $v['type_name'];?></td>
          <td class="w96">
              <!--<a href="<?php echo url('/Admin/Teachtype/nav_edit',['gc_id'=>$v['gc_id']]); ?>">设置</a> |-->
              <?php if(session('admin_is_super') ==1 || (in_array('3',$action)&&in_array('2',$action))){ ?>
              <a href="<?php echo url('/Admin/Teachtype/type_class_edit',['gc_id'=>$v['gc_id']]); ?>"><?php echo \think\Lang::get('ds_edit'); ?></a> |
              <?php }elseif(session('admin_is_super') ==1 || in_array('3',$action)){ ?>
              <a href="<?php echo url('/Admin/Teachtype/type_class_edit',['gc_id'=>$v['gc_id']]); ?>"><?php echo \think\Lang::get('ds_edit'); ?></a>
              <?php } if(session('admin_is_super') ==1 || in_array('2',$action)){ ?>
              <a href="javascript:if(confirm('<?php echo \think\Lang::get('goods_class_index_ensure_del'); ?>'))window.location = '<?php echo url('/Admin/Teachtype/type_class_del',['gc_id'=>$v['gc_id']]); ?>';"><?php echo \think\Lang::get('ds_del'); ?></a>
              <?php } ?>
          </td>
        </tr>
        <?php } }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo \think\Lang::get('ds_no_record'); ?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php if(!empty($class_list) && is_array($class_list)){ ?>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkall_2"></td>
          <td id="batchAction" colspan="15"><span class="all_checkbox">
            <label for="checkall_2"><?php echo \think\Lang::get('ds_select_all'); ?></label>
            </span>&nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo \think\Lang::get('goods_class_index_ensure_del'); ?>')){$('#submit_type').val('del');$('form:first').submit();}"><span><?php echo \think\Lang::get('ds_del'); ?></span></a>
            </td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>

<script type="text/javascript" src="<?php echo \think\Config::get('url_domain_root'); ?>static/plugins/jquery.edit.js" charset="utf-8"></script>
<script src="<?php echo \think\Config::get('url_domain_root'); ?>static/admin/js/jquery.teachtype.js"></script>
