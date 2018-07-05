<?php
/**
 * @后台首页
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

/**
 * @定义一个常量，用来防止别人直接访问程序内部文件
 */
define('XEK', 'XEK');

/**
 * @初始化文件
 */
require_once '../xek-init.php';

/**
 * @检测初始化
 */
if (!defined('INIT_END') || !INIT_END) die("初始化失败");

/**
 * @后台预处理
 */
defined('XEK_page') ? : header("location:activation.php?page=activation");

/**
 * @检验用户信息
 */
if(!empty($_COOKIE['user']) && !empty($_COOKIE['pass'])) {
	
	if(!UserUtil::login($_COOKIE['user'], $_COOKIE['pass'])) {
		
		setcookie('user');
		
		setcookie('pass');
		
		header("location:login.php?page=login");
}
}else {
	
	header("location:login.php?page=login");
}

$sql_pdo = new CoreSql();
			
$sql_pdo -> PDO();

if(UserUtil::activation($_COOKIE['user'])) {
	
	$admin_middle = "已经激活";
}else {
	
	$admin_middle = "账号未激活<a href='" . DOMAIN_FOLDER . SCRIPT . "?page=activation&user={$_COOKIE['user']}' >点击激活</a>";
	
		if(defined('XEK_user')) {
		
			if(XEK_user != $_COOKIE['user']) {
				
				ErrorUtil::output( '希尔凯表示您不能代替{' . XEK_user . '}激活!');
			}
		
		$user_array = $sql_pdo -> mysql_array("SELECT * FROM user WHERE user='{$_COOKIE['user']}';");
		
		EmailUtil::email($user_array['email'], 
								'激活希尔凯4.3',
		'<table style="" cellspacing="0" border="0" cellpadding="0" width="800">
		  <tbody>
			<tr>
			  <td style="font-size:14px;padding:50px 40px 20px 40px;">
				<p style="padding-bottom:20px;">亲爱的' . $_COOKIE['user'] . '，您好！</p>
				<p style="padding-bottom:20px;">您正在进行Schear.凯API账号激活，点击以下链接完成验证。</p>
				<p style="padding-bottom:20px;">
				  <a href="' . DOMAIN_FOLDER . SCRIPT . "?page=activation&activation={$user_array['keys']}" . '" target="_blank" style="color:#699f00;">' . DOMAIN_FOLDER . SCRIPT . "?page=activation&activation={$user_array['keys']}" . '</a>
				</p>
				<p style="padding-bottom:20px;">(该链接在24小时内有效，24小时后需要重新获取验证邮件)</p>
				<p style="padding-bottom:20px;">如果该链接无法点击，请将其复制粘贴到你的浏览器地址栏中访问。</p>
				<p style="padding-bottom:20px;">如果这不是您的邮件，请忽略此邮件。</p>
				<p style="padding-bottom:20px;">这是希尔凯系统邮件，请勿回复。</p>
				<p style="text-align:right;">—— Schear.凯</p>
			  </td>
			</tr>
		  </tbody>
		</table>'                             ,
										 'HTML');
	$admin_middle = "已将激活邮件发送至邮箱!如果还未收到请2分钟后刷新该页面重新提交,或把邮箱xierkai@163.com设置为白名单!";
	}
	
	if(defined('XEK_activation')) {
		
		$sql_pdo -> mysql("UPDATE user SET activation = '1' WHERE user.keys = '" . XEK_activation . "';");
		
		if(UserUtil::activation($_COOKIE['user'])) {
			
			$admin_middle = "鸡活成功!</ br><a href='" . DOMAIN_FOLDER . "index.php?page=index' >后台首页</a>";
		}else {
			
			$admin_middle = "鸡活失败!";
		}
	}
}

/**
 * @载入头文件
 */
$label = new LabelUtil();

$admin_head = $label -> file( TEMPLATE_FOLDER.'head.html');

$admin_footer = $label -> file( TEMPLATE_FOLDER . 'footer.html');

exit( $label -> formatting( $admin_head . '<p style="text-align:center;">' . $admin_middle . '</p>' . $admin_footer));
?>