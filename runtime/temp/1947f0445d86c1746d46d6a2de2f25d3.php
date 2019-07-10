<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:72:"/home/www/chenganxjh/public/../application/admin/view/member/member.html";i:1561455123;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
        
    

        


<link rel="stylesheet" href="<?php echo \think\Config::get('url_domain_root'); ?>static/plugins/layer/css/layui.css">
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>会员管理</h3>
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
            <li>平台会员管理以及基础信息展示</li>
        </ul>
    </div>
    <form method="get" name="formSearch" id="formSearch" >
        <div class="layui-form-item">
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <input name="search_field_value"  autocomplete="off" placeholder="请输入账号名称或手机号" value="<?php echo $_GET['search_field_value'];?>" class="layui-input" type="text">
                </div>
            </div>
            <div class="layui-inline">
                <button class="layui-btn" data-type="reload"><?php echo \think\Lang::get('look_camera_search'); ?></button>
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
          <th><input type="checkbox" class="checkall" id="checkallBottom"></th>
          <th class="align-center" colspan="2"><?php echo \think\Lang::get('member_index_name'); ?></th>
          <th class="align-center"><span>年龄</span></th>
          <th class="align-center"><span>主/副账号</span></th>
          <th class="align-center"><?php echo \think\Lang::get('member_index_state'); ?></th>
            <?php if(session('admin_is_super')==1 || in_array('3',$action) || in_array('2',$action)){?>
          <th class="align-center"><?php echo \think\Lang::get('ds_handle'); ?></th>
            <?php }?>
        </tr>
      <tbody>
        <?php if(!empty($member_list) && is_array($member_list)){ foreach($member_list as $k => $v){ ?>
        <tr class="hover member">
          <td class="w24"><input type="checkbox" name='del_id[]' value="<?php echo $v['member_id']; ?>" class="checkitem"></td>
          <td class="w48 picture">
              <div class="size-44x44">
              <span class="thumb"><i></i>
                  <img src="<?php echo getMemberAvatar($v['member_avatar']); ?>?<?php echo microtime(); ?>"  onload="javascript:DrawImage(this,44,44);"/>
              </span>
          </div>
          </td>
          <td><p class="name"><strong><?php echo $v['member_name']; ?></strong></p>
            <p class="smallfont"><?php echo \think\Lang::get('member_index_reg_time'); ?>:&nbsp;<?php echo $v['member_add_time']; ?></p>
              <div class="im">
               <?php if($v['member_mobile'] != ''){ ?>
               <div style="font-size:13px; padding-left:10px">&nbsp;&nbsp;<?php echo $v['member_mobile']; ?></div>
               <?php } ?>
              </div>
          </td>
          <td class="align-center"><?php echo $v['member_age']; ?></td>
          <td class="align-center"><?php if($v['is_owner']!=0){echo "副账号";}else{echo "主账号";} ?></td>
          
          <td class="align-center"><?php echo $v['member_state'] == 1?lang('member_edit_allow'):lang('member_edit_deny'); ?></td>
          <td class="align-center">
            <?php if(session('admin_is_super') ==1 || in_array(4,$action)){?>
              <a href="javascript:dd(<?php echo $v['member_id']; ?>)" data-method="setTop" class="layui-btn layui-btn-sm"><?php echo \think\Lang::get('ds_view'); ?></a>
              <?php }if(session('admin_is_super')==1 || in_array('3',$action)){?>
              <a class="layui-btn layui-btn-sm" href="<?php echo url('/admin/member/edit',['member_id'=>$v['member_id']]); ?>"><?php echo \think\Lang::get('ds_edit'); ?></a>
              <?php }if(session('admin_is_super')==1 || in_array('2',$action)){?>
              <a class="layui-btn layui-btn-sm layui-btn-danger" href="javascript:member_drop('<?php echo $v['member_id']; ?>')"><?php echo \think\Lang::get('ds_del'); ?></a>
              <?php }?>
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
          <td colspan="17">
              <a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo \think\Lang::get('ds_ensure_del'); ?>')){$('#form_member').submit();}"><span><?php echo \think\Lang::get('ds_del'); ?></span></a>
          </td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
    <?php echo $page; ?>
    
</div>
<script type="text/javascript">
    function dd(id) {
        var urls=ADMIN_URL+'Membercommon/MemberInfo?member_id='+id;
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
    function member_drop(id){
        layer.confirm('是否删除此用户？', {
            btn: ['删除','取消'] //按钮
        }, function(){
            window.location.href="<?php echo url('/admin/member/drop'); ?>?member_id="+id;
        });
    }
</script>