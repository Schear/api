<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @后台首页
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class admin_index {
	/**
	 * @后台首页标签
	 * @param boolean $content 传入格式化内容
	 */
	public function index($content) {
		
		$sql_pdo = new CoreSql();
		
		$sql_pdo -> PDO();
		
		$statistical = NULL;
		
		$json = $sql_pdo -> mysql(BaseSql::SELECT('q', "qa_{$_COOKIE['user']}"));
		
		foreach ($json as $statistical[]) {}
		
		$dictionary = count($statistical);
		
		$statistical = NULL;
		
		$json = $sql_pdo -> mysql(BaseSql::SELECT('user', 'user'));
		
		foreach ($json as $statistical[]) {}
		
		$user = count($statistical);
		
		$user_json = $sql_pdo -> mysql_array(BaseSql::SELECT('*', 'user', 'user', $_COOKIE['user']));
		
		$plugin = count(explode(',', $user_json['plugin']));
		
		$sum = $user_json['memory'];
		
		$used = $dictionary;
		
		$xek_announcement = $sql_pdo -> mysql_array(BaseSql::SELECT('*', 'system', 'name', 'xek_announcement'));
		
		$xek_plugin = $sql_pdo -> mysql_array(BaseSql::SELECT('*', 'system', 'name', 'xek_plugin'));
		
		$plugin1 = count(explode('#_x_e_k_#', $xek_plugin['content'])) - 1;
		
		$index = array('{xek:admin name="dictionary"}' => $dictionary,
					   '{xek:admin name="user"}' => $user + 100,
					   '{xek:admin name="plugin"}' => $plugin,
					   '{xek:admin name="xek_announcement"}' => $xek_announcement['content'],
					   '{xek:admin name="key"}' => $user_json['keys'],
					   '{xek:admin name="used"}' => $used,
					   '{xek:admin name="remaining"}' => $sum - $used,
					   '{xek:admin name="used"}' => $used,
					   '{xek:admin name="plugin1"}' => $plugin1 - $plugin
						);
			
		$content = strtr($content,$index);
		
		return $content;
	}
}