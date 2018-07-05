<?php
/**
 * @登录页
 * @希尔凯
 * @http://www.14eowi.com
 * @version 1.0
 * @数据库结构，账号，密码，邮箱，手机，名字，插件，是否激活
 */

/**
 * @定义一个常量，用来防止别人直接访问程序内部文件
 */
define('XEK', 'XEK');

/**
 * @定义data文件夹
 */
define('DATA_FOLDER',	'data/');

/**
 * @定义表
 */

define('USER_FILE',	'user');

/**
 * @载入主要配置
 */
require_once DATA_FOLDER.'xek-config.php';

/**
 * @初始化文件
 */
require_once DATA_FOLDER.'xek-init.php';

/**
 * @检测初始化
 */
if (!defined('INIT_END') || !INIT_END) die("程序还没有准备好");

/**
 * @核心文件
 */
require_once CORE_FILE;

if (!empty($_COOKIE['user']) && !empty($_COOKIE['pass']))
{
	require_once INC_FOLDER.'cookie.inc';
}

if(!empty($_SESSION['user']) && !empty($_SESSION['pass']))
{
	require_once INC_FOLDER.'session.inc';
}

if(!empty($_GET['login']))
{
	if($_GET['login']!=1 && $_GET['login']!=2)
	{
		$content= "传递参数有误!";
		//恶意提交
		require_once (TEMPLATE_FOLDER."404.php");
		exit ();
	}
	if($_GET['login']==1)
	{
		require_once INC_FOLDER.'login.inc';
	}
	if($_GET['login']==2)
	{
		require_once INC_FOLDER.'registered.inc';
	}
}
else
{
		require_once (TEMPLATE_FOLDER."login.php");
		exit ();
}
?>

