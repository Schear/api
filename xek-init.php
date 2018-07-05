<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @初始化
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

/**
 * 设置报错级别（E_ERROR可以设置为0不输出任何错误）
 */
//error_reporting(E_ERROR);

/**
 * @时间格式化
 */
date_default_timezone_set('PRC');

/**
 * @载入配置项
 */
require_once dirname(__FILE__) . '/xek-config.php';

/**
 * @如果数据库配置文件不存在或者内容为空则跳转到安装页面
 */
if (!file_exists(SQL_FILE) || (file_exists(SQL_FILE) && file_get_contents(SQL_FILE) == "" && !defined('INSTALL'))) header('location:http://' . HOST . '/install/index.php');

/**
 * @载入数据库
 */
require_once ROOT . 'xek-db.php';

/**
 * @载入核心
 */
require_once ROOT . 'xek-load.php';

/**
 * @是否加载完成，如果设置为false，程序将停止运行（相当于关闭站点）
 */
define('INIT_END', true);
?>