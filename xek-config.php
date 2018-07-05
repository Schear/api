<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @路径载入
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

/**
 * @网站域名
 */
define('HOST',			$_SERVER['HTTP_HOST']);

/**
 * @网站脚本名字
 */
define('SCRIPT',			basename($_SERVER['SCRIPT_FILENAME']));

/**
 * @生成网站根目录网址
 */
$domain = "http://" . HOST . "/";

$self = explode("/", $_SERVER['PHP_SELF']);

for ($i = 0; $i < count($self) - 1; $i++) {
	
	if ($self[$i] == "") continue;
	
	$domain .= $self[$i] . "/";
}

/**
 * @网站根目录网址
 */
define('DOMAIN_FOLDER',		$domain);

unset($domain);

unset($self);

/**
 * @程序安装根目录
 */
define('ROOT',				dirname(__FILE__) .  "/");

/**
 * @后台目录
 */
define('ADMIN_FOLDER',		ROOT              .  'admin/');

/**
 * @插件存放目录
 */
define('PLUGIN_FOLDER',		ROOT              .  'plugin/');

/**
 * @类文件根目录
 */
define('CLASS_FOLDER',		ROOT              .  'class/');

/**
 * @工具类存放目录
 */
define('TOOLS_FOLDER',		CLASS_FOLDER      .  'tools/');

/**
 * @sql工具类
 */
define('SQL_FOLDER',		CLASS_FOLDER      .  'sql/');

/**
 * @模板目录
 */
define('TEMPLATE_FOLDER',		                 'template/');

/**
 * @CSS目录
 */
define('CSS_FOLDER',		TEMPLATE_FOLDER   .  'css/');

/**
 * @JavaScript目录
 */
define('JS_FOLDER',			TEMPLATE_FOLDER   .  'js/');

/**
 * @图片目录
 */
define('IMAGES_FOLDER',		TEMPLATE_FOLDER   .  'images/');

/**
 * @插件加载框架
 */
define('PLUGIN_FILE',		PLUGIN_FOLDER     .  'xek-plugin.php');

/**
 * @SQL链接框架
 */
define('SQL_FILE',		    ROOT              .  'xek-db.php');

/**
 * @回车换行
 */
define('CR', "\r\n");

/**
 * @插件指令的分割符，多个指令用这个符号隔开
 */
define('PART', '|');

/**
 * @版本号
 */
define('VERSION', '4.3');

?>