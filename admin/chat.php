<?php
/**
 * @聊天测试
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

if(isset($_COOKIE['user'])) {
	header("location:index.php?page=chat");}
	
defined('XEK_type') ? : header("location:chat.php?type=experience#contain");

header("Cache-Control: no-cache"); 

header("Pragma: no-cache");

$ua = strtolower($_SERVER['HTTP_USER_AGENT']);

$uachar = "/(symbianos|android|Mac OS|ucweb|blackberry|Windows Phone|webOS|iPhone|iPod|BlackBerry)/i";

if($ua != '' && preg_match($uachar, $ua)) {
	
	$phone_head   = NULL;
	
	$phone_footer = NULL;
	
	$win_head     = '<!--电脑模式';
	
	$win_footer   = '-->';
}else {
	
	$phone_head   = '<!--手机模式';
	
	$phone_footer = '-->';
	
	$win_head     = NULL;
	
	$win_footer   = NULL;
}	

$output1 = '欢迎使用Schear.凯聊天测试模块';

$output2 = '<a href="http://www.xek17.com"><i class="fa fa-globe fa-fw"></i>官方网站</a>';

$time = time() + 60 * 60;

$validation = CoreUtil::key($time);

$json_url= "validation={$validation}&time={$time}&text=";

echo 'test:' . md5(time());

$label = new LabelUtil();

$admin_head = $label -> file( TEMPLATE_FOLDER.'head.html');

$admin_chat = $label -> file( TEMPLATE_FOLDER.'chat.html');

$admin_footer = $label -> file( TEMPLATE_FOLDER.'footer.html');

$content = $admin_head . $admin_chat . $admin_footer;

$chat = array('{xek:admin name="phone_head"}'   => $phone_head,
			  '{xek:admin name="phone_footer"}' => $phone_footer,
			  '{xek:admin name="win_head"}'     => $win_head,
			  '{xek:admin name="win_footer"}'   => $win_footer,
			  '{xek:admin name="output1"}'      => $output1,
			  '{xek:admin name="output2"}'      => $output2,
			  '{xek:admin name="json_url"}'     => $json_url);
							   
$content = strtr($content,$chat);

die($label -> formatting($content));