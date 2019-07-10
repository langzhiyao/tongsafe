<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:76:"/home/www/chenganxjh/public/../application/admin/view/dashboard/welcome.html";i:1558338271;s:72:"/home/www/chenganxjh/public/../application/admin/view/public/header.html";i:1558338271;s:77:"/home/www/chenganxjh/public/../application/admin/view/public/admin_items.html";i:1558338271;}*/ ?>
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
                <h3>欢迎界面</h3>
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
    
    

<!--     <ul class="info-message">
        <?php if($version_message): ?>
        <li><?php echo $version_message; ?></li>
        <?php endif; ?>
    </ul> -->

    <div class="info-panel">
        <dl class="member">
            <dt>
            <div class="ico"><i></i><sub title="<?php echo \think\Lang::get('dashboard_wel_total_member'); ?>"><span><em id="statistics_member"></em></span></sub></div>
            <h3><?php echo \think\Lang::get('ds_member'); ?></h3>
            <!--<h5><?php echo \think\Lang::get('dashboard_wel_member_des'); ?></h5>-->
            </dt>
            <dd>
                <ul>
                    <!--<li class="w50pre normal lbn"><a href="<?php echo url('Member/member'); ?>"><?php echo \think\Lang::get('dashboard_wel_new_add'); ?><sub><em id="statistics_week_add_member"></em></sub></a></li>
                    <li class="w50pre none"><a href="<?php echo url('Predeposit/pdcash_list'); ?>"><?php echo \think\Lang::get('dashboard_wel_predeposit_get'); ?><sub><em id="statistics_cashlist">0</em></sub></a></li>-->
                    <li class="w50pre normal lbn"><a>当日<sub><em id="statistics_member_day">0</em></sub></a></li>
                    <li class="w50pre normal lbn"><a>当月<sub><em id="statistics_member_month">0</em></sub></a></li>
                </ul>
            </dd>
        </dl>

        <dl class="teacher">
            <dt>
                <div class="ico"><i class="myicons1"></i><sub title="<?php echo \think\Lang::get('dashboard_wel_total_member'); ?>"><span><em id="statistics_teacher"></em></span></sub></div>
                <h3>教师管理</h3>
            </dt>
            <dd>
                <ul>
                    <li class="w50pre normal lbn"><a>当日<sub><em id="statistics_teacher_day">0</em></sub></a></li>
                    <li class="w50pre normal lbn"><a>当月<sub><em id="statistics_teacher_month">0</em></sub></a></li>
                </ul>
            </dd>
        </dl>
        <dl class="teacherVideo">
            <dt>
                <div class="ico"><i class="myicons2"></i><sub title="<?php echo \think\Lang::get('dashboard_wel_total_member'); ?>"><span><em id="statistics_teacherVideo"></em></span></sub></div>
                <h3>教孩视频管理</h3>
            </dt>
            <dd>
                <ul>
                    <li class="w50pre normal lbn"><a>当日<sub><em id="statistics_teacherVideo_day">0</em></sub></a></li>
                    <li class="w50pre normal lbn"><a>当月<sub><em id="statistics_teacherVideo_month">0</em></sub></a></li>
                </ul>
            </dd>
        </dl>
        <dl class="agent">
            <dt>
                <div class="ico"><i class="myicons3"></i><sub title="<?php echo \think\Lang::get('dashboard_wel_total_member'); ?>"><span><em id="statistics_agent"></em></span></sub></div>
                <h3>代理商管理</h3>
            </dt>
            <dd>
                <ul>
                    <li class="w50pre normal lbn"><a>当日<sub><em id="statistics_agent_day">0</em></sub></a></li>
                    <li class="w50pre normal lbn"><a>当月<sub><em id="statistics_agent_month">0</em></sub></a></li>
                </ul>
            </dd>
        </dl>
        <dl class="school">
            <dt>
                <div class="ico"><i class="myicons4"></i><sub title="<?php echo \think\Lang::get('dashboard_wel_total_member'); ?>"><span><em id="statistics_school"></em></span></sub></div>
                <h3>学校管理</h3>
            </dt>
            <dd>
                <ul>
                    <li class="w50pre normal lbn"><a>当日<sub><em id="statistics_school_day">0</em></sub></a></li>
                    <li class="w50pre normal lbn"><a>当月<sub><em id="statistics_school_month">0</em></sub></a></li>
                </ul>
            </dd>
        </dl>
        <dl class="trade">
            <dt>
                <div class="ico"><i></i><sub title="<?php echo \think\Lang::get('dashboard_wel_total_member'); ?>"><span><em id="statistics_trade"></em></span></sub></div>
                <h3>商城订单管理</h3>
            </dt>
            <dd>
                <ul>
                    <li class="w50pre normal lbn"><a>当日<sub><em id="statistics_trade_day">0</em></sub></a></li>
                    <li class="w50pre normal lbn"><a>当月<sub><em id="statistics_trade_month">0</em></sub></a></li>
                </ul>
            </dd>
        </dl>
        <dl class="camera">
            <dt>
                <div class="ico"><i class="myicons5"></i><sub title="<?php echo \think\Lang::get('dashboard_wel_total_member'); ?>"><span><em id="statistics_camera"></em></span></sub></div>
                <h3>摄像头管理</h3>
            </dt>
            <dd>
                <ul>
                    <li class="w50pre normal lbn"><a>当日<sub><em id="statistics_camera_day">0</em></sub></a></li>
                    <li class="w50pre normal lbn"><a>当月<sub><em id="statistics_camera_month">0</em></sub></a></li>
                </ul>
            </dd>
        </dl>
        <dl class="robot">
            <dt>
                <div class="ico"><i class="myicons6"></i><sub title="<?php echo \think\Lang::get('dashboard_wel_total_member'); ?>"><span><em id="statistics_robot"></em></span></sub></div>
                <h3>机器人管理</h3>
            </dt>
            <dd>
                <ul>
                    <li class="w50pre normal lbn"><a>当日<sub><em id="statistics_robot_day">0</em></sub></a></li>
                    <li class="w50pre normal lbn"><a>当月<sub><em id="statistics_robot_month">0</em></sub></a></li>
                </ul>
            </dd>
        </dl>
        <dl class="blueTooth">
            <dt>
                <div class="ico"><i class="myicons7"></i><sub title="<?php echo \think\Lang::get('dashboard_wel_total_member'); ?>"><span><em id="statistics_blueTooth"></em></span></sub></div>
                <h3>蓝牙防丢系统管理</h3>
            </dt>
            <dd>
                <ul>
                    <li class="w50pre normal lbn"><a>当日<sub><em id="statistics_blueTooth_day">0</em></sub></a></li>
                    <li class="w50pre normal lbn"><a>当月<sub><em id="statistics_blueTooth_month">0</em></sub></a></li>
                </ul>
            </dd>
        </dl>




       <!-- <dl class="shop">
            <dt>
            <div class="ico"><i></i><sub title="<?php echo \think\Lang::get('dashboard_wel_count_store_add'); ?>"><span><em id="statistics_store"></em></span></sub></div>
            <h3><?php echo \think\Lang::get('ds_store'); ?></h3>
            <h5><?php echo \think\Lang::get('dashboard_wel_store_des'); ?></h5>
            </dt>
            <dd>
                <ul>
                    <li class="w20pre none lbn"><a href="<?php echo url('Store/store_joinin'); ?>">开店审核<sub><em id="statistics_store_joinin">0</em></sub></a></li>
                    <li class="w20pre none"><a href="<?php echo url('Store/store_bind_class_applay_list',['state'=>0]); ?>">类目申请<sub><em id="statistics_store_bind_class_applay">0</em></sub></a></li>
                    <li class="w20pre none"><a href="<?php echo url('Store/reopen_list',['re_state'=>1]); ?>">续签申请<sub><em id="statistics_store_reopen_applay">0</em></sub></a></li>
                    <li class="w20pre none"><a href="<?php echo url('Store/store',['store_type'=>'expired']); ?>"><?php echo \think\Lang::get('dashboard_wel_expired'); ?><sub><em id="statistics_store_expired">0</em></sub></a></li>
                    <li class="w20pre none"><a href="<?php echo url('Store/store',['store_type'=>'expire']); ?>"><?php echo \think\Lang::get('dashboard_wel_expire'); ?><sub><em id="statistics_store_expire">0</em></sub></a></li>
                </ul>
            </dd>
        </dl>
        <dl class="goods">
            <dt>
            <div class="ico"><i></i><sub title="<?php echo \think\Lang::get('dashboard_wel_total_goods'); ?>"><span><em id="statistics_goods"></em></span></sub></div>
            <h3><?php echo \think\Lang::get('ds_goods'); ?></h3>
            <h5><?php echo \think\Lang::get('dashboard_wel_goods_des'); ?></h5>
            </dt>
            <dd>
                <ul>
                    <li class="w25pre normal lbn"><a href="<?php echo url('Goods/index'); ?>"><?php echo \think\Lang::get('dashboard_wel_new_add'); ?><sub title="<?php echo \think\Lang::get('dashboard_wel_count_goods'); ?>"><em id="statistics_week_add_product"></em></sub></a></li>
                    <li class="w25pre none"><a href="<?php echo url('Goods/index',['type'=>'waitverify','search_verify'=>10]); ?>">商品审核<sub><em id="statistics_product_verify">0</em></sub></a></li>
                    <li class="w25pre none"><a href="<?php echo url('inform/inform_list'); ?>"><?php echo \think\Lang::get('dashboard_wel_inform'); ?><sub><em id="statistics_inform_list">0</em></sub></a></li>
                    <li class="w25pre none"><a href="<?php echo url('brand/brand_apply'); ?>"><?php echo \think\Lang::get('dashboard_wel_brnad_applay'); ?><sub><em id="statistics_brand_apply">0</em></sub></a></li>
                </ul>
            </dd>
        </dl>
        <dl class="trade">
            <dt>
            <div class="ico"><i></i><sub title="<?php echo \think\Lang::get('dashboard_wel_total_order'); ?>"><span><em id="statistics_order"></em></span></sub></div>
            <h3><?php echo \think\Lang::get('ds_trade'); ?></h3>
            <h5><?php echo \think\Lang::get('dashboard_wel_trade_des'); ?></h5>
            </dt>
            <dd>
                <ul>
                    <li class="w18pre none lbn"><a href="<?php echo url('refund/refund_manage'); ?>">退款<sub><em id="statistics_refund"></em></sub></a></li>
                    <li class="w18pre none"><a href="<?php echo url('returnmanage/return_manage'); ?>">退货<sub><em id="statistics_return"></em></sub></a></li>
                    <li class="w25pre none"><a href="<?php echo url('vrrefund/refund_manage'); ?>">虚拟订单退款<sub><em id="statistics_vr_refund"></em></sub></a></li>
                    <li class="w18pre none"><a href="<?php echo url('complain/complain_new_list'); ?>"><?php echo \think\Lang::get('dashboard_wel_complain'); ?><sub><em id="statistics_complain_new_list">0</em></sub></a></li>
                    <li class="w20pre none"><a href="<?php echo url('complain/complain_handle_list'); ?>"><?php echo \think\Lang::get('dashboard_wel_complain_handle'); ?><sub><em id="statistics_complain_handle_list">0</em></sub></a></li>
                </ul>
            </dd>
        </dl>
        <dl class="operation">
            <dt>
            <div class="ico"><i></i></div>
            <h3><?php echo \think\Lang::get('ds_operation'); ?></h3>
            <h5><?php echo \think\Lang::get('dashboard_wel_stat_des'); ?></h5>
            </dt>
            <dd>
                <ul>
                    <li class="w15pre none lbn"><a href="<?php echo url('groupbuy/index'); ?>"><?php echo \think\Lang::get('dashboard_wel_groupbuy'); ?><sub><em id="statistics_groupbuy_verify_list">0</em></sub></a></li>
                    <li class="w17pre none"><a href="<?php echo url('pointorder/pointorder_list',['porderstate'=>'waitship']); ?>"><?php echo \think\Lang::get('dashboard_wel_point_order'); ?><sub><em id="statistics_points_order">0</em></sub></a></li>
                    <li class="w17pre none"><a href="<?php echo url('bill/show_statis',['bill_state'=>'2']); ?>"><?php echo \think\Lang::get('dashboard_wel_check_billno'); ?><sub><em id="statistics_check_billno">0</em></sub></a></li>
                    <li class="w17pre none"><a href="<?php echo url('bill/show_statis',['bill_state'=>'3']); ?>"><?php echo \think\Lang::get('dashboard_wel_pay_billno'); ?><sub><em id="statistics_pay_billno">0</em></sub></a></li>
                    <li class="w17pre none"><a href="<?php echo url('Mallconsult/index'); ?>">平台客服<sub><em id="statistics_mall_consult">0</em></sub></a></li>
                    <li class="w17pre none"><a href="<?php echo url('Delivery/index',['sign'=>'verify']); ?>">服务站<sub><em id="statistics_delivery_point">0</em></sub></a></li>
                </ul>
            </dd>
        </dl>-->

        <!--<?php if (config('cms_isuse') != null) {?>
        <dl class="cms">
            <dt>
            <div class="ico"><i></i></div>
            <h3>CMS</h3>
            <h5>资讯文章/图片画报/会员评论</h5>
            </dt>
            <dd>
                <ul>
                    <li class="w33pre none"><a href="<?php echo url('Cmsarticle/cms_article_list_verify'); ?>">文章审核<sub><em id="statistics_cms_article_verify">0</em></sub></a></li>
                    <li class="w33pre none"><a href="<?php echo url('Cmspicture/cms_picture_list_verify'); ?>">画报审核<sub><em id="statistics_cms_picture_verify">0</em></sub></a></li>
                    <li class="w34pre none"><a href="<?php echo url('Cmscomment/comment_manage'); ?>">评论<sub></sub></a></li>
                </ul>
            </dd>
        </dl>
        <?php }if (config('circle_isuse') != null) {?>
        <dl class="circle">
            <dt>
            <div class="ico"><i></i></div>
            <h3>圈子</h3>
            <h5>申请开通/圈内话题及举报</h5>
            </dt>
            <dd>
                <ul>
                    <li class="w33pre none"><a href="<?php echo url('Circlemanage/circle_verify'); ?>">圈子申请<sub><em id="statistics_circle_verify">0</em></sub></a></li>
                    <li class="w33pre none"><a href="<?php echo url('Circletheme/theme_list'); ?>">话题</a></li>
                    <li class="w34pre none"><a href="<?php echo url('Circleinform/inform_list'); ?>">举报</a></li>
                </ul>
            </dd>
        </dl>
        <?php }if (config('microshop_isuse') != null){?>
        <dl class="microshop">
            <dt>
            <div class="ico"><i></i></div>
            <h3>微商城</h3>
            <h5>随心看/个人秀/店铺街</h5>
            </dt>
            <dd>
                <ul>
                    <li class="w33pre none"><a href="<?php echo url('Microshop/goods_manage'); ?>">随心看</a></li>
                    <li class="w33pre none"><a href="<?php echo url('Circletheme/theme_list'); ?>">个人秀</a></li>
                    <li class="w34pre none"><a href="<?php echo url('Circleinform/inform_list'); ?>">店铺街</a></li>
                </ul>
            </dd>
        </dl>
        <?php }?>-->
        <div class="clear"></div>
    </div>
    <!--<div class="info-system">
        <div class="mt">
            <h3>版本信息</h3>
        </div>
        <div class="mc">
            <table cellpadding="0" cellspacing="0" class="system_table">
                <tbody><tr>
                        <td class="gray_bg"><?php echo \think\Lang::get('dashboard_wel_version'); ?></td>
                        <td><?php echo $statistics['version']; ?></td>
                        <td class="gray_bg"><?php echo \think\Lang::get('dashboard_wel_install_date'); ?></td>
                        <td><?php echo $statistics['setup_date']; ?></td>
                    </tr>
                    <tr>
                        <td class="gray_bg">程序开发:</td>
                        <td>想见孩网络科技有限公司</td>
                        <td class="gray_bg">版权所有:</td>
                        <td>盗版必究</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="info-system">
        <div class="mt">
            <h3>系统信息</h3>
        </div>
        <div class="mc">
            <table cellpadding="0" cellspacing="0" class="system_table">
                <tbody>
                    <tr>
                        <td class="gray_bg">ThinkPHP版本号</td>
                        <td><?php echo THINK_VERSION;?></td>
                        <td class="gray_bg">类库文件后缀</td>
                        <td><?php echo EXT;?></td>
                    </tr>
                    <tr>
                        <td class="gray_bg"><?php echo \think\Lang::get('dashboard_wel_server_os'); ?></td>
                        <td><?php echo $statistics['os']; ?></td>
                        <td class="gray_bg">服务器域名/IP:</td>
                        <td><?php echo $statistics['domain']; ?> [ <?php echo $statistics['ip']; ?> ]</td>
                    </tr>
                    <tr>
                        <td class="gray_bg">WEB <?php echo \think\Lang::get('dashboard_wel_server'); ?></td>
                        <td><?php echo $statistics['web_server']; ?></td>
                        <td class="gray_bg">PHP <?php echo \think\Lang::get('dashboard_wel_version'); ?></td>
                        <td><?php echo $statistics['php_version']; ?></td>
                    </tr>
                    <tr>
                        <td class="gray_bg">MYSQL <?php echo \think\Lang::get('dashboard_wel_version'); ?></td>
                        <td><?php echo $statistics['sql_version']; ?></td>
                        <td class="gray_bg">GD 版本:</td>
                        <td><?php echo $statistics['gdinfo']; ?></td>
                    </tr>
                    <tr>
                        <td class="gray_bg">文件上传限制:</td>
                        <td><?php echo $statistics['fileupload']; ?></td>
                        <td class="gray_bg">最大占用内存:</td>
                        <td><?php echo $statistics['memory_limit']; ?></td>
                    </tr>
                    <tr>
                        <td class="gray_bg">最大执行时间:</td>
                        <td><?php echo $statistics['max_ex_time']; ?></td>
                        <td class="gray_bg">安全模式:</td>
                        <td><?php echo $statistics['safe_mode']; ?></td>
                    </tr>
                    <tr>
                        <td class="gray_bg">Zlib支持:</td>
                        <td><?php echo $statistics['zlib']; ?></td>
                        <td class="gray_bg">Curl支持:</td>
                        <td><?php echo $statistics['curl']; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>-->

    <script type="text/javascript">
        var normal = ['week_add_member', 'week_add_product'];
        var work = ['store_joinin', 'store_bind_class_applay', 'store_reopen_applay', 'store_expired', 'store_expire', 'brand_apply', 'cashlist', 'groupbuy_verify_list', 'points_order', 'complain_new_list', 'complain_handle_list', 'product_verify', 'inform_list', 'refund', 'return', 'vr_refund', 'cms_article_verify', 'cms_picture_verify', 'circle_verify', 'check_billno', 'pay_billno', 'mall_consult', 'delivery_point', 'offline'];
        $(document).ready(function () {
            $.getJSON("<?php echo url('Dashboard/statistics'); ?>", function (data) {
                $.each(data, function (k, v) {
                    $("#statistics_" + k).html(v);
                    if (v != 0 && $.inArray(k, work) !== -1) {
                        $("#statistics_" + k).parent().parent().parent().removeClass('none').addClass('high');
                    } else if (v == 0 && $.inArray(k, normal) !== -1) {
                        $("#statistics_" + k).parent().parent().parent().removeClass('normal').addClass('none');
                    }
                });
            });
        });
    </script>


</div>