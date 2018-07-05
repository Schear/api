<?php
/**
 * @接口
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

/**
 * @定义一个常量，用来防止别人直接访问程序内部文件
 */
define('XEK', 'XEK');
$start_time=microtime(true);
/**
 * @初始化文件
 */
require_once 'xek-init.php';

/**
 * @检测初始化
 */
if (!defined('INIT_END') || !INIT_END) die("初始化失败");

/**
 * @GET/POST初始化
 */
$text = defined('XEK_text') ? XEK_text : NULL;

$key = defined('XEK_key') ? XEK_key : NULL;

$stable = defined('XEK_stable') ? XEK_stable : NULL;

$type = defined('XEK_type') ? XEK_type : NULL;


/**
 * @测试聊天模式
 */
if(defined('XEK_validation') && defined('XEK_time')) {
	
	if(XEK_time > time()) {
		
		$key='a670324beaf5e14095850d7df9bf0d49';
		
		$stable='2';
		
		$type='0';
	}else {
		
		die('Page has expired, please refresh,页面过期请刷新');
	}
}

/**
 * @载入SQL环境
 */
$sql_pdo = new CoreSql();

$sql_pdo->PDO();

/**
 * @基本检测
 */
if($key == NULL)
{//检测KEY是否为空
	header("Content-Type:application/x-javascript;   charset=utf-8"); 
	die (json_encode(array('text'=>"KEY Can't be empty",'error'=>'401')));
}

$xek_user = $sql_pdo->mysql_array("SELECT * FROM `user` WHERE `keys` LIKE '{$key}'");
if($xek_user == NULL)
{//检测KEY是否有效
	header("Content-Type:application/x-javascript;   charset=utf-8"); 
	die (json_encode(array('text'=>'KEY Is not correct','error'=>'402')));
}

if($type == NULL)
{//检测返回格式是否为空
	header("Content-Type:application/x-javascript;   charset=utf-8"); 
	die (json_encode(array('text'=>"TYPE Can't be empty",'error'=>'401')));
}

/**
 * @定义,释放
 */
define('XEK_USER',$xek_user['user']);

//unset($xek_user);

define('XEK_MSG',$text);

unset($text);

define('XEK_STABLE',$stable);

unset($stable);

if(XEK_MSG != NULL)
{
	/**
	 * @log记录
	 */
	if($xek_user['log'] == NULL)
	{
		$content=NULL;
		
		for($i=1;$i<=date('j');$i++)
		{
			$content .= '#x_e_k#'.$i.','.'0';
		}
		$sql_pdo->mysql("UPDATE user SET log = '{$content}' WHERE user.user = '{$xek_user['user']}';");
		
		$xek_user = $sql_pdo->mysql_array("SELECT * FROM `user` WHERE `keys` LIKE '{$key}'");
	}
	
	unset($user_json);
	
	$xek_log = explode('#x_e_k#', $xek_user['log']);
	
	if(count($xek_log)-1 != 0 && date('j')!='1')
	{
		$content=NULL;
		
		if(count($xek_log)-1 != date('j')) {
			
			for($i = 1; $i <= date('j'); $i++) {
				
				$log_temporary = isset($xek_log[$i]) ? $xek_log[$i] : '';
				
				if($log_temporary!=NULL) {
					
					$user_log = explode(',', $xek_log[$i]);
					
					$content .=  '#x_e_k#'.$user_log[0].','. $user_log[1];
				}else {
					
					if($i == date('j')) {
						
						$content .= '#x_e_k#'.date('j').','. '1';
					}else {
						
						$content .= '#x_e_k#'.$i.','. '0';
					}
				}
			}
		}else {
			
			for($i=1; $i<=count($xek_log)-1; $i++) {
				
				$user_log = explode(',', $xek_log[$i]);
				
				$b = $user_log[1] + 1;
				
				if(date('j') == $user_log[0]) {
					
					$content .= '#x_e_k#'.$user_log[0].','. $b;
				}else {
					
					$content .= '#x_e_k#'.$user_log[0].','. $user_log[1];
				}
			}
		}
		
		$sql_pdo->mysql("UPDATE user SET log = '{$content}' WHERE user.user = '{$xek_user['user']}';");
	}
	if(date('j')=='1') {
		
		if(count($xek_log)-1 == 1) {
			
			$$user_log = explode(',', $xek_log[$i]);
			
			$b = $user_log[1] + 1;
			
			$content = '#x_e_k#'.'1'.','. $b;
		}else {
			
			$content = '#x_e_k#'.'1'.','. '1';
		}
		
		$sql_pdo->mysql("UPDATE user SET log = '{$content}' WHERE user.user = '{$xek_user['user']}';");
	}
	
	unset($content);
	
	unset($user_log);
	
	unset($xek_log);
	
	/**
	 * @载入系统插件
	 */
	$system = $sql_pdo->mysql_array("SELECT * FROM system WHERE name='xek_plugin';");
	
	$xek_plugin = $system['content'];
	
	unset($system);
	
	if (count(explode('#_x_e_k_#', $xek_plugin)) >= 1) {
		
		$xek_plugin = explode('#_x_e_k_#', $xek_plugin);
		
		$plugin_name = NULL;
		
		for ($i = 0;$i <= count($xek_plugin)-1;$i++) {
			
			$plugin = explode('#x_e_k#', $xek_plugin[$i]);
			
			if (!empty($plugin[4])) {
				
			   require_once PLUGIN_FOLDER.'system/'.$plugin[4].'.php';
			   
			   $plugin_name.=$plugin[4].',';
			}
		}
		unset($plugin);
		
		unset($xek_plugin);
		
		$plugin=explode(',', $plugin_name);
	}
	
	unset($sql_pdo);
	
	/**
	 * @载入插件模块
	 */
	$TypePlugin = new TypePlugin();
	
	for ($x = 0;$x <= count($plugin) - 1;$x++) {
		
		if(preg_match("/{$plugin[$x]}/", $xek_user['plugin'])) {
			
			if($plugin[$x]!=NULL) {
				
				$loading = new $plugin[$x]();
				
				$results_array = $loading -> XEK();
				
				if(!empty($results_array)) {
					
					if($results_array == 'exit') {
						
						exit();
					}
					
					//测试格式
					if($type == '0') {
						
						die ( $TypePlugin -> test($results_array));
					}
					
					//普通文本格式
					if($type == '1') {
						
						die ( $TypePlugin -> txt($results_array));
					}
					
					//json格式
					if($type == '2') {
						
						header("Content-Type:application/x-javascript;   charset=utf-8"); 
						
						echo $TypePlugin -> json($results_array);
						
						break;
					}
					
					//xml格式
					if($type == '3') {
						
						header("Content-type:text/xml");
						
						die ( $TypePlugin -> xml($results_array));
					}
				}
			}
		}
	}
}
$end_time=microtime(true);

echo '{"系统":"'.number_format(microtime(1) - $start_time, 6).'"}';

die();
?>