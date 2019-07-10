<?php
$lang['site_name'] ='网站名称';
$lang['seller_center_logo'] ='商家中心LOGO';
$lang['site_mobile_logo'] ='手机端LOGO';
$lang['site_logowx'] ='微信二维码';
$lang['site_tel400'] ='400电话';
$lang['email_set']		= '邮件设置';
$lang['mobile_set']		= '短信平台设置';
$lang['email_tpl']		= '其它模板';
$lang['message_tpl']	= '站内信模板';
$lang['message_tpl_state']	= '消息模板状态更改';
$lang['seller_tpl']     = '商家消息模板';
$lang['seller_tpl_edit']     = '编辑商家消息模板';
$lang['member_tpl']     = '用户消息模板';
$lang['member_tpl_edit']= '编辑用户消息模板';
$lang['node_site_url']  ='scoket.io服务端地址';

$lang['time_zone_set']         = '默认时区';
$lang['set_sys_use_time_zone'] = '设置系统使用的时区，中国为';
$lang['default_product_pic']   = '默认商品图片';
$lang['default_store_logo']    = '默认店铺标志';
$lang['default_user_pic']      = '默认会员头像';
$lang['flow_static_code']      = '版权底部信息';
$lang['flow_static_code_notice']     = '前台页面底部可以显示版权信息或第三方统计';
$lang['image_dir_type']		= '图片存放类型';
$lang['image_dir_type_0']	= '按照文件名存放 (例:/店铺id/图片)';
$lang['image_dir_type_1']	= '按照年份存放 (例:/店铺id/年/图片)';
$lang['image_dir_type_2']	= '按照年月存放 (例:/店铺id/年/月/图片)';
$lang['image_dir_type_3']	= '按照年月日存放 (例:/店铺id/年/月/日/图片)';
$lang['image_width']	= '宽';
$lang['image_height']	= '高';
$lang['image_typeerror']	= '上传图片格式不正确';
$lang['image_thumb_tool']	= '压缩工具';
$lang['image_thumb_tool_tips']	= '商城默认使用GD库生成缩略图，GD使用广泛但占用系统资源较多，ImageMagick速度快系统资源占用少，但需要服务器有执行命令行命令的权限。可到 http://www.imagemagick.org 下载安装，如改用ImageMagick，可编辑data/config/config.ini.php文件(用EditPlus): <br/>$config[\'thumb\'][\'cut_type\'] = \'im\';<br/>$config[\'thumb\'][\'impath\'] = \'ImageMagick下convert工具所在路径\'; 如：<br/>$config[\'thumb\'][\'impath\'] = \'/usr/local/ImageMagick/bin\';';

$lang['allowed_visitors_consult']           = '允许游客咨询';
$lang['allowed_visitors_consult_notice']    = '允许游客在商品的详细展示页面，对当前商品进行咨询';
$lang['open_pseudo_static']                 = '启用伪静态';
$lang['open_kefu'] = '启用在线客服';
$lang['open_kefu_yes'] = '是';
$lang['open_kefu_no'] = '否';
$lang['promotion_allow'] = '商品促销';
$lang['promotion_notice'] = '启用商品促销功能后，商家可以通过限时打折、满即送、优惠套装和推荐展位活动，对店铺商品进行促销';
$lang['open_pointshop_isuse'] = '积分中心';
$lang['open_pointshop_isuse_notice'] = '积分中心和积分同时启用后，网站将增加积分中心频道';
$lang['open_pointprod_isuse'] = '积分兑换';
$lang['open_pointprod_isuse_notice'] = '积分兑换、积分功能以及积分中心启用后，平台发布礼品，会员的积分在达到要求时可以在积分中心中兑换礼品';
$lang['points_isuse_notice'] = '积分系统启用后，可设置会员的注册、登录、购买商品送一定的积分';
$lang['open_predeposit_isuse'] = '预存款';
$lang['open_predeposit_isuse_notice'] = '预存款启用后，会员可以给自己帐户充值进行交易，当交易支付到平台时，预存款不可以关闭';
$lang['voucher_allow'] = '代金券';
$lang['voucher_allow_notice'] = '代金券功能、积分功能、积分中心启用后，商家可以申请代金券活动；会员积分达到要求时可以在积分中心兑换代金券；<br>拥有代金券的会员可在代金券所属店铺内购买商品时，选择使用而得到优惠';
$lang['groupbuy_allow'] = '抢购';
$lang['groupbuy_isuse_notice']    = '抢购功能启用后，商家通过活动发布抢购商品，进行促销';
$lang['complain_time_limit'] = '投诉时效';
$lang['complain_time_limit_desc'] = '单位为天，订单完成后开始计算，多少天内可以发起投诉，根据具体情况卖家和买家都可发起投诉';
$lang['update_cycle_hour']                  = '更新周期(小时)';
$lang['web_name']                           = '网站名称';
$lang['web_name_notice']					= '网站名称，将显示在前台顶部欢迎信息等位置';
$lang['site_description']                   = '网站描述';
$lang['site_description_notice']			= '网站描述，出现在前台页面头部的 Meta 标签中，用于记录该页面的概要与描述';
$lang['site_keyword']                       = '网站关键字';
$lang['site_keyword_notice']                = '网站关键字，出现在前台页面头部的 Meta 标签中，用于记录该页面的关键字，多个关键字间请用半角逗号 "," 隔开';
$lang['site_logo']                          = '网站Logo';
$lang['member_logo']                        = '会员中心Logo';
$lang['member_logo_notice']                 = '默认为网站Logo，在会员中心头部显示，建议使用180px * 50px';
$lang['icp_number']                         = 'ICP证书号';
$lang['icp_number_notice']                  = '前台页面底部可以显示 ICP 备案信息，如果网站已备案，在此输入你的授权码，它将显示在前台页面底部，如果没有请留空';
$lang['site_phone']                         = '平台客服联系电话';
$lang['site_phone_notice']                  = '商家中心右下侧显示，方便商家遇到问题时咨询，多个请用半角逗号 "," 隔开';
$lang['site_bank_account']                  = '平台汇款账号';
$lang['site_bank_account_notice']           = '用半角逗号","分隔项目，用半角冒号":"分隔标题和内容，例："银行:中国银行,币种:人民币,账号:xxxxxxxxxxx,姓名:csdeshang,开户行:中国银行XX分行"';
$lang['site_email']                         = '电子邮件';
$lang['site_email_notice']                  = '商家中心右下侧显示，方便商家遇到问题时咨询';
$lang['site_state']                         = '站点状态';
$lang['site_state_notice']                  = '可暂时将站点关闭，其他人无法访问，但不影响管理员访问后台';
$lang['closed_reason']                      = '关闭原因';
$lang['closed_reason_notice']               = '当网站处于关闭状态时，关闭原因将显示在前台';
$lang['hot_search']                         = '热门搜索';
$lang['field_notice']                       = '热门搜索，将显示在前台搜索框下面，前台点击时直接作为关键词进行搜索，多个关键词间请用半角逗号 "," 隔开';
$lang['email_type_open']                    = '邮件功能开启';
$lang['email_type']                         = '邮件发送方式';
$lang['use_other_smtp_service']             = '采用其他的SMTP服务';
$lang['use_server_mail_service']            = '采用服务器内置的Mail服务';
$lang['if_choose_server_mail_no_input_follow'] = '如果您选择服务器内置方式则无须填写以下选项';
$lang['smtp_server']             = 'SMTP 服务器';
$lang['set_smtp_server_address'] = '设置 SMTP 服务器的地址，如 smtp.163.com';
$lang['smtp_port']               = 'SMTP 端口';
$lang['set_smtp_port']           = '设置 SMTP 服务器的端口，默认为 25';
$lang['sender_mail_address']     = '发信人邮件地址';
$lang['if_smtp_authentication']  = '使用SMTP协议发送的邮件地址，如 csdeshang@163.com';
$lang['smtp_user_name']          = 'SMTP 身份验证用户名';
$lang['smtp_user_name_tip']      = '如 csdeshang@163.com';
$lang['smtp_user_pwd']           = 'SMTP 身份验证密码';
$lang['smtp_user_pwd_tip']       = 'csdeshang@163.com邮件的密码，如 123456';
$lang['test_mail_address']       = '测试接收的邮件地址';
$lang['test']                    = '测试';
$lang['open_checkcode']          = '使用验证码';
$lang['front_login']             = '前台登录';
$lang['front_goodsqa']           = '商品咨询';
$lang['front_regist']            = '前台注册';
$lang['allow_open_store']        = '开店申请';
$lang['setting_store_creditrule']        = '店铺信用';
$lang['setting_store_creditrule_grade']        = '等级';
$lang['setting_store_creditrule_gradenum']        = '信用介于';


$lang['default_img_wrong']       = '图片限于png,gif,jpeg,jpg格式';

$lang['upload_image_filesize']	= '图片文件大小';
$lang['image_allow_ext']	= '图片扩展名';
$lang['image_allow_ext_notice']	= '图片扩展名，用于判断上传图片是否为后台允许，多个后缀名间请用半角逗号 "," 隔开。';
$lang['image_allow_ext_not_null']	= '图片扩展名不能为空';
$lang['upload_image_file_size']	= '大小';
$lang['upload_image_filesize_is_number']    = '图片文件大小仅能为数字';
$lang['image_max_size_tips'] = '当前服务器环境，最大允许上传'.ini_get('upload_max_filesize').'B 的文件，您的设置请勿超过该值。';
$lang['upload_image_size_c_num'] = '图片像素最多四位数';
$lang['image_max_size_only_num'] = '图片文件大小仅能为数字';
$lang['image_max_size_c_num'] = '图片文件大小最多四位数';

$lang['gold_isuse']    = '金币';
$lang['gold_isuse_notice']    = '金币功能启用后，店主可通过平台提供的交易方式进行购买，金币可用来购买广告、直通车等';
$lang['gold_isuse_open']    = '开启';
$lang['gold_isuse_close']    = '关闭';
$lang['gold_rmbratio']    = '金币市值';
$lang['gold_rmbratiodesc_1']    = '人民币一元兑换';
$lang['gold_rmbratiodesc_2']    = '枚金币';
$lang['gold_isuse_check']    = '请选择是否启用金币功能';
$lang['gold_rmbratio_isnum']    = '金币市值必须为正整数';
$lang['gold_rmbratio_min']    = '金币市值最小为1';
$lang['edit_gold_set_ok']       = '编辑金币设置成功。';
$lang['edit_gold_set_fail']     = '编辑金币设置失败。';

$lang['ztc_isuse']    = '直通车状态';
$lang['ztc_isuse_open']    = '开启';
$lang['ztc_isuse_close']    = '关闭';
$lang['ztc_dayprod']    = '直通车单价';
$lang['ztc_unit']    = '金币/天';
$lang['ztc_isuse_check']    = '请选择是否启用直通车';
$lang['ztc_isuse_notice']    = '直通车功能启用后，店主用金币来购买，申请的商品在列表中会靠前';
$lang['ztc_dayprod_isnum']    = '直通车单价必须为正整数';
$lang['ztc_dayprod_min']    = '直通车单价最小为1';

$lang['qq_isuse']   			= '是否启用QQ互联功能';
$lang['qq_isuse_open']    	 	= '开启';
$lang['qq_isuse_close']    	 	= '关闭';
$lang['qq_apply_link']    	 	= '立即在线申请';
$lang['qq_appcode']    	 		= '域名验证信息';
$lang['qq_appid']    	 		= '应用标识';
$lang['qq_appkey']    	 		= '应用密钥';
$lang['qq_appid_error']    	 	= '请添加应用标识';
$lang['qq_appkey_error']    	= '请添加应用密钥';
$lang['qq_ucenter_error']    	 	= '请关闭会员整合，才可启用QQ互联功能';

$lang['sina_isuse']   			= '新浪微博登录功能';
$lang['sina_isuse_open']    	= '开启';
$lang['sina_isuse_close']    	= '关闭';
$lang['sina_apply_link']    	= '立即在线申请';
$lang['sina_appcode']    	 		= '域名验证信息';
$lang['sina_wb_akey']    	 	= '应用标识';
$lang['sina_wb_skey']    	 	= '应用密钥';
$lang['sina_wb_akey_error']    	= '请添加应用标识';
$lang['sina_wb_skey_error']    	= '请添加应用密钥';
$lang['sina_function_fail_tip'] = '该功能需要在  php.ini 中 开启 php_curl 扩展，才能使用。';
$lang['sina_settings']          = '新浪微博';

$lang['sms_register']           = '手机注册';
$lang['sms_login']              = '手机登录';
$lang['sms_password']           = '找回密码';

$lang['weixin_isuse']           = '是否启用微信登录功能';
$lang['weixin_appid']           = '应用标识(appid)';
$lang['weixin_secret']          = '应用密钥';

$lang['points_isuse']   		= '积分';
$lang['points_isuse_open']    	= '开启';
$lang['points_isuse_close']    	= '关闭';
$lang['points_ruletip']    		= '积分规则如下';
$lang['points_item']    	 	= '项目';
$lang['points_number']    	 	= '赠送积分';
$lang['points_number_reg']    	= '会员注册';
$lang['points_number_login']    = '会员每天登录';
$lang['points_number_comments']    = '订单商品评论';
$lang['points_tuijian']       = '设置推荐积分规则';
$lang['reg_tuijian']       = '推荐注册积分';
$lang['regtuijian']        = '会员注册时分给推荐人积分数';
$lang['points_number_order']    = '购物并付款';
$lang['points_number_orderrate']    = '消费额与赠送积分比例';
$lang['points_number_orderrate_tip']    = '例:设置为10，表明消费10单位货币赠送1积分';
$lang['points_number_ordermax']    = '每订单最多赠送积分';
$lang['points_number_ordermax_tip']    = '例:设置为100，表明每订单赠送积分最多为100积分';
$lang['points_update_success']    = '更新成功';
$lang['points_update_fail']    	= '更新失败';
$lang['flea_isuse']		   = '开启闲置';
$lang['flea_isuse_notice'] = '开启闲置市场，会员可以通过发布自己的闲置商品';

$lang['open_yes']    	= '是';
$lang['open_no']    	= '否';

$lang['is_goods_verify']  ='商品发布审核';
$lang['goods_verify_notice'] ='店铺发布的商品是否需要通过商家的审核后才能上架';


//分成/时长/副账号设置
$lang['teacher_children'] = '教孩视频（观看有效时间）';
$lang['revisit_class'] = '重温课堂（观看有效时间）';
$lang['teacher_pay_scale'] = '教孩在线支付分成比例';
$lang['teacher_children_video'] = '教孩上传视频录制时长设置';
$lang['f_account_num'] = '副账号数量设置';
$lang['zb'] = '总部';
$lang['province_agent'] = '省代理商';
$lang['city_agent'] = '市代理商';
$lang['teacher'] = '教师';



?>
