<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @后台标签工具
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class AdminUtil {
	
	/**
	 * @菜单标签
	 * @param boolean $content 传入格式化内容
	 */
	public function head_menu($content) {
		
		$sql_pdo = new CoreSql();
		
		$sql_pdo -> PDO();
		
		if(!empty($_COOKIE['user'])) {
		
		$user = $sql_pdo -> mysql_array(BaseSql::SELECT('*', 'user', 'user', $_COOKIE['user']));
		}else {
			
			$user['permissions'] = 'user';
		}
		
		$page = defined('XEK_page') ? XEK_page : '';
		
		$json = array();
		
		$menu_content = NULL;
		
		$template = $sql_pdo -> mysql(BaseSql::SELECT('*', 'template'));
		
		foreach ($template as $template_array[]) {}
		
		for ($i = 0; $i < count($template_array); $i++) {
			
			if (preg_match("/{$user['permissions']}/", $template_array[$i]['permissions'])) {
				
				if ($page == $template_array[$i]['name']) {
					
					$menu_content.= "        <li><a class='active-menu' href='index.php?page={$template_array[$i]['name']}'><i class='fa fa-{$template_array[$i]['icon']} fa-fw'></i>{$template_array[$i]['menu']}</a></li>\n\r" . "<!--希尔凯QQ:312224992-->\n\r";
					
				} else {
					
					$menu_content.= "                        <li><a href='index.php?page={$template_array[$i]['name']}'><i class='fa fa-{$template_array[$i]['icon']} fa-fw'></i>{$template_array[$i]['menu']}</a></li>\n\r" . "<!--希尔凯QQ:312224992-->\n\r";
				}
			}
		} 
		$menu = array('{xek:admin name="head_menu"}' => $menu_content);
		
		$content = strtr($content,$menu);
		
		return $content;
	}
	
	/**
	 * @问候标签
	 * @param boolean $content 传入格式化内容
	 */
	public function greetings($content) {
		
		$h=date("h"); 
		if($h == "12") $h=0; 
		$a=date("a"); 
		if($h >5 && $a =="pm")    $greetings = "晚上好"; 
		if($h <=5 && $a =="pm")   $greetings = "下午好"; 
		if($h >5 && $a =="am")    $greetings = "上午好"; 
		if( $h <= 5 && $a =="am") $greetings = "深夜了请注意休息!";
		
		$greetings = array('{xek:admin name="greetings"}' => $greetings);
			
		$content = strtr($content,$greetings);
		
		return $content;
	}
}
?>