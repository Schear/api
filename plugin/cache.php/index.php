<?php
/**
 * @首页
 * @希尔凯
 * @http://www.14eowi.com
 * @version 1.0
 */

/**
 * @定义一个常量，用来防止别人直接访问程序内部文件
 */
define('XEK', 'XEK');

/**
 * @定义data文件夹
 */
define('DATA_FOLDER',	'data/');

$start_time=microtime(true);

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
 * @核心框架
 */
require_once CORE_FILE;

if($_GET['page']=='index')
{
	/**
	 * @检测是否需要激活账号
	 */
	if(!empty($_GET['activation']))
	{
		$json=xek::mysql("SELECT * FROM `user` WHERE `keys` LIKE '{$_GET['activation']}'");
		if($json['user']==NULL)
		{
			echo '未能查询到激活账号';
			exit();
		}
		else
		{
			if($json['activation']=='1')
			{
				echo '账号已经激活，无需重复！';
				exit();
			}
			else
			{
				xek::mysql("UPDATE user SET activation = '1' WHERE user.keys = '{$_GET['activation']}';");
				echo '账号激活成功！';
				exit();
			}
		}
	}
}

/**
 * @验证用户
 */
if (!empty($_COOKIE['user']) && !empty($_COOKIE['pass']))
	{
		if(xek::login($_COOKIE['user'],$_COOKIE['pass'])!='1')
		{
			//验证失败
			header("location:login.php");
			exit ();
		}
	}
	else
	{
		//验证失败
		header("location:login.php");
		exit ();
	}
/**
 * @如果page为空转跳到index页面
 */
if(empty($_GET['page']))
{
	header("location:index.php?page=index");
	exit ();
}
/**
 * @如果page为exit，即是退出
 */
if($_GET['page']=="exit")
{
	setcookie("user");
	setcookie("pass");
	header("location:login.php");
	exit ();
}

/**
 * @载入头
 */
require_once (TEMPLATE_FOLDER."head.php");
/**
 * @载入模板
 */
if(!empty($_GET['page']))
{
	if(file_exists(TEMPLATE_FOLDER."{$_GET['page']}.php"))
	{
		require_once (TEMPLATE_FOLDER."{$_GET['page']}.php");
	}
	else
	{
		$content= "传递参数有误!";
		require_once (TEMPLATE_FOLDER."404.php");
	}
}
/**
 * 载入尾
 */
require_once (TEMPLATE_FOLDER."footer.php");
exit ();
?>