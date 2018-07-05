<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @标签工具
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class LabelUtil {
	
	/**
	 * @取文件内容
	 * @param boolean $address 实际地址
	 */
	public function file($address)
	{
		return fread(fopen($address, "r"), filesize ($address));
	}
	
	/**
	 * @格式化
	 * @param boolean $content 需要格式化的内容
	 */
	public function formatting($content)
	{
		while(true) {
			if(strstr($content,"{xek:") == NULL) break;
			
			$name = CoreUtil::middle($content,'{xek:',' name="');
			
			$content = $this->$name($content);
		}	
		return $content;
	}
	
	/**
	 * @系统类标签
	 * @param boolean $content 传入格式化内容
	 */
	public function system($content)
	{
		$sql_pdo = new CoreSql();
		$sql_pdo -> PDO();
		$system_name_json = $sql_pdo -> mysql("SELECT `name` FROM `system`");
		$system_contemt_json = $sql_pdo -> mysql("SELECT `content` FROM `system`");
		$system_name = array();
		$system_contemt = array();
		foreach($system_name_json as $system_name[]){}
		foreach($system_contemt_json as $system_contemt[]){}
		for($i = 0; $i <= count($system_name) - 1; $i++) {
			$system['{xek:system name="'.$system_name[$i][0].'"}'] = $system_contemt[$i][0];
		}
		$content = strtr($content,$system);
		
		return $content;
	}
	
	/**
	 * @路径类标签
	 * @param boolean $content 传入格式化内容
	 */
	public function path($content)
	{
		while(true) {
			if(strstr($content,"{xek:path") == NULL) break;
			
			$name = CoreUtil::middle($content,'{xek:path name="','"}');
			
			$path = array('{xek:path name="'.$name.'"}' => constant($name));
			
			$content = strtr($content,$path);
		}	
		
		return $content;
	}
	
	/**
	 * @时间类标签
	 * @param boolean $content 传入格式化内容
	 */
	public function date($content)
	{
		while(true) {
			if(strstr($content,"{xek:date") == NULL) break;
			
			$name = CoreUtil::middle($content,'{xek:date name="','"}');
			
			$date = array('{xek:date name="'.$name.'"}' => date($name));
			
			$content = strtr($content,$date);
		}	
		return $content;
	}
	
	/**
	 * @后台类标签
	 * @param boolean $content 传入格式化内容
	 */
	public function admin($content)
	{
		$admin = new AdminUtil();
		
		while(true) {
			if(strstr($content,"{xek:admin") == NULL) break;
			
			$name = CoreUtil::middle($content,'{xek:admin name="','"}');
			
			$content = $admin ->$name($content);
		}
		return $content;
	}
	
	/**
	 * @cookie标签
	 * @param boolean $content 传入格式化内容
	 */
	public function cookie($content) {
		$name = CoreUtil::middle($content,'{xek:cookie name="','"}');
		
		$cookie = array('{xek:cookie name="'.$name.'"}' => $_COOKIE[$name]);
			
		$content = strtr($content,$cookie);
		
		return $content;
	}
	
	/**
	 * @server标签
	 * @param boolean $content 传入格式化内容
	 */
	public function server($content) {
		$name = CoreUtil::middle($content,'{xek:server name="','"}');
		
		$cookie = array('{xek:server name="'.$name.'"}' => $_SERVER[$name]);
			
		$content = strtr($content,$cookie);
		
		return $content;
	}
}