<?php
/**
 * @安装页
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

/**
 * @定义一个常量，用来防止别人直接访问程序内部文件
 */
define('XEK', 'XEK');

define('INSTALL', 'INSTALL');

/**
 * @初始化文件
 */
if(!file_exists('../xek-db.php')) fopen("../xek-db.php", "w");

if(!file_exists('install.sql')) $information = "丢失install.sql文件";

if(!file_exists('basic.sql')) $information = "丢失basic.sql文件";
 
require_once '../xek-init.php';

/**
 * @检测初始化
 */
if (!defined('INIT_END') || !INIT_END) die("初始化失败");

/**
 * @主程序
 */
defined('XEK_page') ? : header("location:index.php?page=home");

$label = new LabelUtil();

if(XEK_page == 'home') {
	
	$install = $label -> file( 'home.html');
	
	$information = empty($information) ? '欢迎安装Schear.凯4.3' : $information;
}

if(XEK_page == 'install') {
	
	$install = $label -> file( 'install.html');
	
	$host     = defined('XEK_home')     ? XEK_home     : 'localhost';
		
	$sql_user = defined('XEK_sql_user') ? XEK_sql_user : '';
	
	$sql_pass = defined('XEK_sql_pass') ? XEK_sql_pass : '';
	
	$sql_base = defined('XEK_sql_base') ? XEK_sql_base : '';
	
	$user     = defined('XEK_user')     ? XEK_user     : '';
	
	$pass     = defined('XEK_pass')     ? XEK_pass     : '';
	
	if(defined('XEK_install')) {
	
		if($host == NULL)     $information = "主机地址不能为空\r\n建议填写localhost";
		
		if($sql_user == NULL) $information = "数据库用户名不能为空";
		
		if($sql_pass == NULL) $information = "数据库密码不能为空";
		
		if($sql_base == NULL) $information = "数据库名不能为空";
		
		if($user == NULL)     $information = "管理员用户名不能为空";
		
		if($pass == NULL)     $information = "管理员密码不能为空";
	
		if(empty($information)) {
			try {
				$sql_pdo = new PDO("mysql:host={$host};",
											   $sql_user,
											   $sql_pass, 
				array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
			}
			catch(PDOException $error) {
				
				$information = '数据库连接错误: '.$error -> getMessage();
			}
			$sql_pdo -> query( "DROP DATABASE `{$sql_base}`;" );
			
			$sql_pdo -> query( "CREATE DATABASE `{$sql_base}`;" );
			
			try {
				$sql_pdo = new PDO("mysql:host={$host};dbname={$sql_base}",
																 $sql_user,
																 $sql_pass, 
				array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
			}
			catch(PDOException $error) {
				
				$information = '数据库连接错误: '.$error -> getMessage();
			}
			
			if(empty($information)) {
			
				//写入配置信息
				$xek_db="<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @首页
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

/*host地址*/
define('XEK_HOST_SQL','{$host}');

/*数据库名*/
define('XEK_DB_SQL','{$sql_base}');

/*数据库用户名*/
define('XEK_USER_SQL','{$sql_user}');

/*数据库用户密码*/
define('XEK_PASS_SQL','{$sql_pass}');
?>";
				
				if (!file_put_contents('../xek-db.php', $xek_db)) {
					
					$information = "数据库配置写xek_db.php文件失败!";
				}
				
				if(empty($information)) {
					
					$sql=file_get_contents('install.sql');
					
					$sql=explode ( ";", $sql);
					
					for ($i = 0; $i < count($sql); $i++){
						
						$sql_pdo -> query($sql[$i]); 
					}
					
				header('location:http://' . HOST . "/install/index.php?page=resuit&user={$user}&pass={$pass}&host={$host}");
				}
			}
		}
	}
	
	$install_array = array('{xek:login name="host"}'     => $host,
						   '{xek:login name="sql_user"}' => $sql_user,
						   '{xek:login name="sql_pass"}' => $sql_pass,
						   '{xek:login name="sql_base"}' => $sql_base,
						   '{xek:login name="user"}'     => $user,
						   '{xek:login name="pass"}'     => $pass);
		
	$install = strtr($install,$install_array);
	
	$information = empty($information) ? '填写以下信息' : $information;
}

if(XEK_page == 'resuit') {
	
	$install_array = array('{xek:login name="host"}' => XEK_host,
						   '{xek:login name="user"}' => XEK_user,
						   '{xek:login name="pass"}' => XEK_pass);
						   
	$information = UserUtil::add(XEK_user, XEK_pass, 'admin@xek.com', '', 'system');
	
	$install = $label -> file( 'resuit.html');
		
	$install = strtr($install,$install_array);
	
	if($information == 1) {
		$sql_pdo = new CoreSql();
		
		$sql_pdo -> PDO();
		
		$sql=file_get_contents('basic.sql');
					
		$sql=explode ( ";", $sql);
		
		for ($i = 0; $i < count($sql); $i++){
			
			$sql_pdo -> mysql($sql[$i]); 
		}
		
		$sql_pdo -> mysql(BaseSql::UPDATE('user', 'activation', '1', 'user', XEK_user));
		
		$information = '安装成功';
	}elseif($information == 0){
		
		$information = '安装失败';
	}
	
	$information = empty($information) ? '安装结果' : $information;
}

$install_head = $label -> file( 'head.html');

$install_footer = $label -> file( 'footer.html');

$information = empty($information) ? '' : $information;

$install_array = array('{xek:login name="information"}' => $information);
		
$install = strtr($install_head . $install . $install_footer, $install_array);

die($install);