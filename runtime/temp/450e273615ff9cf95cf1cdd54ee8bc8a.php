<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:73:"/home/www/chenganxjh/public/../application/admin/view/vrsorder/index.html";i:1561455123;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>订单管理</h3>
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
            <li>线上视频订单信息。</li>
        </ul>
    </div>
    <form method="get" name="formSearch" id="formSearch" class="layui-form">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('school_index_names'); ?>：</label>
                    <div class="layui-input-inline">
                        <input type="text"  name="buyer_name" placeholder="请输入会员账号"  id="buyer_name" value="<?php echo $_GET['buyer_name']; ?>" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('school_index_paytype'); ?>：</label>
                    <div class="layui-input-inline">
                        <select name="payment_code" class="select">
                            <option value=""><?php echo \think\Lang::get('ds_please_choose'); ?></option>
                            <?php if(is_array($payment) || $payment instanceof \think\Collection || $payment instanceof \think\Paginator): $i = 0; $__LIST__ = $payment;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $item['payment_code']; ?>" <?php if(\think\Request::instance()->get('payment_code') == $item['payment_code']): ?>selected<?php endif; ?>><?php echo $item['payment_name']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label"><?php echo \think\Lang::get('order_state'); ?>：</label>
                    <div class="layui-input-inline">
                        <select name="order_state" class="select">
                            <option value=""><?php echo \think\Lang::get('ds_please_choose'); ?></option>
                            <option value="10" <?php if(\think\Request::instance()->get('order_state') == '10'): ?>selected<?php endif; ?>>待支付</option>
                            <option value="40" <?php if(\think\Request::instance()->get('order_state') == '40'): ?>selected<?php endif; ?>>已支付</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-admin" lay-submit="" class="submit" type="submit" lay-filter="LAY-user-back-search">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>

    <table class="layui-table">
        <thead>
        <tr class="thead">
            <th colspan="align-center"><?php echo \think\Lang::get('school_index_id'); ?></th>
            <th colspan="align-center"><?php echo \think\Lang::get('school_index_names'); ?></th>
            <th colspan="align-center"><?php echo \think\Lang::get('school_index_extend'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_index_order'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_index_price'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_index_orderstatus'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_index_paytype'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_order_dieline'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_order_createtime'); ?></th>
            <th class="align-center"><?php echo \think\Lang::get('school_index_paytime'); ?></th>
        </tr>
        <tbody>
        <?php if(!empty($order_list) && is_array($order_list)){ foreach($order_list as $k => $v){ ?>
        <tr class="hover member">
            <td class="align-center"><?php if(!$_GET['page']){  echo $k+1; }else{ echo ($_GET['page']-1)*15+$k+1; }?></td>
            <td class="align-center"><?php echo $v['buyer_mobile']; ?></td>
            <td class="align-center"><?php echo $v['s_name']; ?></td>
            <td class="align-center"><?php echo $v['pkg_name']; ?></td>
            <td class="align-center"><?php if(!empty($v['order_amount'])){echo sprintf('%.2f', $v['order_amount']);}else{echo "";} ?></td>
            <td class="align-center"><?php if($v['order_state']==10){echo "待支付";}
            elseif($v['order_state']==40){echo "已支付";}?></td>
            <td class="align-center">
                <?php foreach($payment as $key=>$item){
                if($item['payment_code']==$v['payment_code']){echo $item['payment_name'];}
                }  ?>
            </td>
            <td class="align-center"><?php if(!empty($v['order_dieline'])){echo date("Y-m-d H:i:s",$v['order_dieline']);} ?></td>
            <td class="align-center"><?php if(!empty($v['add_time'])){echo date("Y-m-d H:i:s",$v['add_time']);} ?></td>
            <td class="align-center"><?php if(!empty($v['payment_time'])){echo date("Y-m-d H:i:s",$v['payment_time']);} ?></td>
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
    layui.use(['form','laypage', 'layer'], function(){
        var form = layui.form,
            laypage = layui.laypage
            ,layer = layui.layer;
    });
    $(function() {
        regionInit("region");
    });
</script>