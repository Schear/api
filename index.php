<?php
/**
 * @首页
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
require_once 'xek-init.php';

/**
 * @检测初始化
 */
if (!defined('INIT_END') || !INIT_END) die("初始化失败");

$task = defined('XEK_task') ? XEK_task : '';

/**
 * @任务更新
 */
if($task != NULL) {
	/**
	 * @载入数据库
	 */
	$sql_pdo = new CoreSql();
		
	$sql_pdo -> PDO();
	
	if($task == '990605' || $task == 'plugin') {
		
		/**
		 * @插件更新
		 */
		 $plugin_folder = scandir(PLUGIN_FOLDER . 'system');
		 
		 for ($i = 2; $i < count($plugin_folder); $i++) {
			 
			 $plugin_name = basename($plugin_folder[$i],".php");
			 
			 if(isset($plugin_name)) {
				 
				 require_once PLUGIN_FOLDER . 'system/' . $plugin_folder[$i];
			 }
		 }
		 
		 $plugin = NULL;
		 
		 for ($i = 2;$i < count($plugin_folder);$i++) {
			 
			$plugin_name=basename($plugin_folder[$i],".php");
			
			if(preg_match("/(.*).php/", $plugin_folder[$i])) {
				
				$call = new $plugin_name();
				
				if(isset($call->plugin_name) && isset($call->plugin_author) && isset($call->plugin_version)) {
					
					$plugin .= "{$call->plugin_name}#x_e_k#{$call->plugin_author}#x_e_k#{$call->plugin_about}#x_e_k#{$call->plugin_version}#x_e_k#{$plugin_name}#_x_e_k_#";
				}
			}
		}
		
		$sql_pdo -> mysql("UPDATE system SET content = '{$plugin}' WHERE system.name = 'xek_plugin';");
	}
	
	if($task == '990605' ||$task =='user') {
	
		/**
		 * @清理用户
		 */
		$user_array = $sql_pdo -> mysql_array_management("SELECT * FROM `user`");
		
		for ($i = 0; $i < count($user_array); $i++) {
			
			if($user_array[$i]['activation'] == '0') {
				
				$sql_pdo -> mysql("DROP TABLE `qa_{$user_array[$i]['user']}`;");
				
				$sql_pdo -> mysql("DELETE FROM user WHERE user = '{$user_array[$i]['user']}';");
			}
		}
	}
	
	if($task == '990605' || $task == 'sql') {
		
		/**
		 * @数据库备份
		 */
		if(!file_exists('./backup/xel_'.date('y').'_'.date('m').'_'.date('j').".sql"))
		{
			$json_structure = $sql_pdo -> mysql("show tables");
			foreach($json_structure as $var)
			{
				$table = $var[0];
				$structure = $sql_pdo -> mysql("show create table `$table`");
				foreach($structure as $row){}
				$mysql_structure .= $row['Create Table'].";\n\r\n\r";
				$row=NULL;
				$var=NULL;
				$json_content = $sql_pdo -> mysql("select * from `$table`");
				foreach($json_content as $var)
				{
					$keys = NULL;
					$vals = NULL;
					foreach($var as $key => $row)
					{
						if(!preg_match("/^[1-9]\d*|0$/", $key))
						{
							if($keys==NULL)
							{
								$keys = $key;
								$vals = $row;
							}
							else
							{
								$keys .= '`,`'.$key;
								$vals .= "','".$row;
							}
						}
					}
					$mysql_content.="insert into `{$table}`(`{$keys}`) values('{$vals}');\n\r\n\r";
				}
				$row=NULL;
				$var=NULL;
				$keys=NULL;
			}
			$filename='xel_'.date('y').'_'.date('m').'_'.date('j').".sql";
			$fp = fopen('./backup/'.$filename,'w');
			fputs($fp,$mysql_content);
			fclose($fp);
			$filename = 'xel_'.date('y').'_'.date('m').'_'.date('j')."structure.sql";
			$fp = fopen('./backup/'.$filename,'w');
			fputs($fp,$mysql_structure);
			fclose($fp);
		}
	}
	die('更新成功');
}

/**
 * @载入首页模板
 */
$label = new LabelUtil();

if(!defined('XEK_error')) {
	$content = $label -> file(TEMPLATE_FOLDER . 'index.html');
	
	header("Content-Type:text/html;   charset=utf-8"); 
	
	header("Cache-Control: no-cache"); 
	
	header("Pragma: no-cache");
	
	$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
	
	$uachar = "/(symbianos|android|Mac OS|ucweb|blackberry)/i";
	
	if($ua != '' && preg_match($uachar, $ua)){
		
		$experience = '                        <li><a href="{HTTP_HOST}admin/chat.php" onClick="fnOpen()">体验中心</a></li>';
		
	}else{
		
		$experience = '                        <li><a href="#" onClick="fnOpen()">体验中心</a></li>';
	}
	
	$content = strtr($content,array('{xek:experience}' => $experience));
	
	$content = $label -> formatting($content);
	
	echo $content;
}else {
	ErrorUtil::output(XEK_error);

}

exit();

?>