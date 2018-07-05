<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @后台控制台
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class admin_console {
	
	/**
	 * @后台控制台标签
	 * @param boolean $content 传入格式化内容
	 */
	public function console($content) {
		
		$sql_pdo = new CoreSql();
		
		$sql_pdo -> PDO();
		
		$user_array = $sql_pdo -> mysql_array(BaseSql::SELECT('*', 'user', 'user', $_COOKIE['user']));
		
		if($user_array['log']==NULL) {
			
			$log_content = NULL;
			
			for($i=1;$i<=date('j');$i++) {
				
				$log_content .= '#x_e_k#'.$i.','.'0';
			}
			
			$sql_pdo -> mysql(BaseSql::UPDATE('user', 'log', $log_content, 'user', $_COOKIE['user']));
			
			$user_array = $sql_pdo -> mysql_array(BaseSql::SELECT('*', 'user', 'user', $_COOKIE['user']));
		}
		
		$segmentation = explode('#x_e_k#', $user_array['log']);
		
		if(count($segmentation)-1 != 0 && date('j')!='1') {
			
			$log_content = NULL;
			
			if(count($segmentation)-1 != date('j')) {
				
				for($i = 1; $i <= date('j'); $i++) {
					
					if($segmentation[$i] != NULL) {
						
						$log = explode(',', $segmentation[$i]);
						
						$log_content .=  '#x_e_k#'.$log[0].','. $log[1];
					}else {
						
						$log_content .= '#x_e_k#'.$i.','. '0';
					}
				}
				
				$sql_pdo -> mysql(BaseSql::UPDATE('user', 'log', $log_content, 'user', $_COOKIE['user']));
			}
		}
		if(date('j')=='1') {
			
			if(count($log)-1 != 1) {
				
				$log_content = '#x_e_k#'.'1'.','. '0';
			}
			
			$sql_pdo -> mysql(BaseSql::UPDATE('user', 'log', $log_content, 'user', $_COOKIE['user']));
		}
		
		$log_content = NULL;
		
		$user_array = $sql_pdo -> mysql_array(BaseSql::SELECT('*', 'user', 'user', $_COOKIE['user']));
		
		$segmentation = explode('#x_e_k#', $user_array['log']);
		
		$mainApp=NULL;
		
		if(count($segmentation)-1 == 1) {
			
			$json1 = explode(',', $segmentation[1]);
			
			$m=date('n-').$json1[0];
			
			$b=1000-$json1[1];
			
			$mainApp = "{
				m: '{$m}',
				a: {$json1[1]},
				b: {$b}
				}";
		}else {
			
			$mainApp = NULL;
			
			for($i=1;$i<=count($segmentation)-1;$i++) {
				
				$json1 = explode(',', $segmentation[$i]);
				
				$m=date('n-').$json1[0];
				
				$b=1000-$json1[1];
				
				if(empty($mainApp)) {
					
					$mainApp = "{
						m: '{$m}',
						a: {$json1[1]},
						b: {$b}
						}";
				}else {
					
					$mainApp .= ",
					{
						m: '{$m}',
						a: {$json1[1]},
						b: {$b}
						}";
				}
			}
		}
		
		$greetings = array('{xek:admin name="admin_console"}' => "",
						   '{xek:admin name="mainApp"}' => $mainApp);
						   			   
		$content = strtr($content,$greetings);
		
		return $content;
	}
}