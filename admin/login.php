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
defined('XEK_page') ? : header("location:login.php?page=login");

if(!empty($_COOKIE['user']) && !empty($_COOKIE['pass'])) {

	if(UserUtil::login($_COOKIE['user'], $_COOKIE['pass'])) {
			
		header("location:index.php?page=index");
	}
}

/**
 * @载入头文件
 */
$label = new LabelUtil();

$login_page = XEK_page;

$login_head = $label -> file( TEMPLATE_FOLDER.'head.html');

if(file_exists( TEMPLATE_FOLDER . $login_page . '.html') && ($login_page == 'login' || $login_page  == 'registered')) {
	
	$login_middle = $label -> file( TEMPLATE_FOLDER . $login_page . '.html');
}else {
	
	ErrorUtil::output( '希尔凯表示没有{' . $login_page . '}这个页面,请问你找这个页面干什么!');
}

$login_footer = $label -> file( TEMPLATE_FOLDER . 'footer.html');

$login_name = 'admin_' . $login_page;

$login = new $login_name();

$login_middle = $login -> $login_page( $login_middle);

exit( $label -> formatting( $login_head . $login_middle . $login_footer));
?>