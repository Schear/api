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
defined('XEK_page') ? : header("location:index.php?page=index");

/**
 *@退出登录
 */
if(XEK_page == 'exit') {
	
	setcookie('user');
		
	setcookie('pass');
	
	header("location:login.php?page=login");
}

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

if(!UserUtil::activation($_COOKIE['user'])) {
	
	header("location:activation.php?page=activation");
}

/**
 * @载入头文件
 */
$label = new LabelUtil();

$admin_page = XEK_page;

$admin_head = $label -> file( TEMPLATE_FOLDER.'head.html');

if(file_exists( TEMPLATE_FOLDER . $admin_page . '.html')) {
	
	$admin_middle = $label -> file( TEMPLATE_FOLDER . $admin_page . '.html');
}else {
	
	ErrorUtil::output( '希尔凯表示没有{' . $admin_page . '}这个页面,请问你找这个页面干什么!');
}

$admin_footer = $label -> file( TEMPLATE_FOLDER . 'footer.html');

$admin_name = 'admin_' . $admin_page;

$admin = new $admin_name();

$admin_middle = $admin -> $admin_page( $admin_middle);

exit( $label -> formatting( $admin_head . $admin_middle . $admin_footer));
?>