<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @核心
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

/**
 * @开启SESSION
 */
session_start();

/**
 * @加载常规操作工具
 */
require_once TOOLS_FOLDER . 'CoreUtil.php';

/**
 * @根据类名自动加载文件
 * @param string $className 类名
 */
function __autoload($className) {
	$folder = CLASS_FOLDER;

	if (CoreUtil::tail_key("Util", $className)) {
		
		/**
		 * @Util结尾的类名为工具类
		 */
		$folder = TOOLS_FOLDER;
	} elseif (CoreUtil::tail_key("Sql", $className)) {
		
		/**
		 * @Sql结尾的类名为sql工具类
		 */
		$folder = SQL_FOLDER;
	} elseif (CoreUtil::tail_key("Plugin", $className)) {
		
		/**
		 * @Plugin结尾的类名为返回类型工具类
		 */
		$folder = PLUGIN_FOLDER;
	} elseif (CoreUtil::tail_key("ysis", $className)) {
		
		/**
		 * @ysis结尾的类名为分词工具类
		 */
		$folder = CLASS_FOLDER.'PhpAnalysis/';
	} elseif (CoreUtil::head_key("admin", $className)) {
		
		/**
		 * @Admin结尾的类名为分词工具类
		 */
		$folder = ADMIN_FOLDER.'inc/';
	}

	/**
	 * @类名的具体目录
	 */
	$file = $folder . $className . ".php";

	/**
	 * @如果文件存在则导入此文件
	 */
	if(file_exists($file)) require_once($file);
}

/**
 * 自动收集GET_POST
 */
foreach($_GET as $var => $key)
{
	if(!empty($_GET[$var])) {
	
	defined('XEK_'.$var) ? :define('XEK_'.$var,$key);
	}
	
	$_GET[$var] = NULL;
}
foreach($_POST as $var => $key)
{
	if(!empty($_POST[$var])) {
	
	defined('XEK_'.$var) ? :define('XEK_'.$var,$key);
	}
	
	$_POST[$var] = NULL;
}
?>