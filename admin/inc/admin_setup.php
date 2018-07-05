<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @后台设置
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class admin_setup {
	/**
	 * @后台设置标签
	 * @param boolean $content 传入格式化内容
	 */
	public function setup($content) {
		
		$sql_pdo = new CoreSql();
		
		$sql_pdo -> PDO();
		
		$user_array = $sql_pdo -> mysql_array(BaseSql::SELECT('*', 'user', 'user', $_COOKIE['user']));
		
		$system_head = "<!--";
			
		$system_footer = "-->";
		
		if($user_array['permissions'] == 'system') {
			
			if (defined('XEK_xek_name')) {
			
				$sql_pdo -> mysql(BaseSql::UPDATE('system', 'content', XEK_xek_name, 'name', 'xek_name'));
			}
			if(defined('XEK_xek_keywords')) {
				
				$sql_pdo -> mysql(BaseSql::UPDATE('system', 'content', XEK_xek_keywords, 'name', 'xek_keywords'));
			}
			if(defined('XEK_xek_description')) {
				
				$sql_pdo -> mysql(BaseSql::UPDATE('system', 'content', XEK_xek_description, 'name', 'xek_description'));
			}
			if(defined('XEK_xek_basehost')) {
				
				$sql_pdo -> mysql(BaseSql::UPDATE('system', 'content', XEK_xek_basehost, 'name', 'xek_basehost'));
			}
			if(defined('XEK_xek_email')) {
				
				$sql_pdo -> mysql(BaseSql::UPDATE('system', 'content', XEK_xek_email, 'name', 'xek_email'));
			}
			if(defined('XEK_xek_emailpass')) {
				
				$sql_pdo -> mysql(BaseSql::UPDATE('system', 'content', XEK_xek_emailpass, 'name', 'xek_emailpass'));
			}
			if(defined('XEK_xek_announcement')) {
				
				$sql_pdo -> mysql(BaseSql::UPDATE('system', 'content', XEK_xek_announcement, 'name', 'xek_announcement'));
			}
			if(defined('XEK_xek_smtp')) {
				
				$sql_pdo -> mysql(BaseSql::UPDATE('system', 'content', XEK_xek_smtp, 'name', 'xek_smtp'));
			}
			
			$permissions_system = 1;
			
			$system_head        = NULL;
			
			$system_footer      = NULL;
		}
		
		if(defined('XEK_email')) {
			
			if(preg_match('/\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}/', XEK_email)) {
				
				$sql_pdo -> mysql(BaseSql::UPDATE('user', 'email', XEK_email, 'user', $_COOKIE['user']));
			}else {
				
				$information = '邮箱格式出错！';
			}
		}
		if(defined('XEK_phone')) {
			if(preg_match('/^1[34578]\d{9}$/', XEK_phone)) {
				
				$sql_pdo -> mysql(BaseSql::UPDATE('user', 'phone', XEK_phone, 'user', $_COOKIE['user']));
			}else {
				
				$information = '手机格式出错';
			}
		}
		if(defined('XEK_pass')) {
			if(preg_match('/^[0-9A-Za-z]{6,16}$/', XEK_pass)) {
				
				$sql_pdo -> mysql(BaseSql::UPDATE('user', 'pass', CoreUtil::key(XEK_pass), 'user', $_COOKIE['user']));
				
				setcookie('user');
		
				setcookie('pass');
				
				header("location:login.php?page=login");
			}else {
				
				$information = '密码只能是数字和字母且密码最小为6位最大为16位!';
			}
		}
		
		$system_object = $sql_pdo -> mysql(BaseSql::SELECT('*', 'system'));
		
		foreach($system_object as $system_json) {
			
			$system_content = empty($permissions_system) ? '' : $system_json['content'];
			
			$system_array[$system_json['name']] = $system_content;
		}
		
		$user_array = $sql_pdo -> mysql_array(BaseSql::SELECT('*', 'user', 'user', $_COOKIE['user']));
		
		$information = empty($information) ? '基本设置' : $information;
		
		$system = array('{xek:admin name="xek_name"}' => $system_array['xek_name'],
						'{xek:admin name="xek_keywords"}' => $system_array['xek_keywords'],
						'{xek:admin name="xek_description"}' => $system_array['xek_description'],
						'{xek:admin name="xek_basehost"}' => $system_array['xek_basehost'],
						'{xek:admin name="xek_email"}' => $system_array['xek_email'],
						'{xek:admin name="xek_emailpass"}' => $system_array['xek_emailpass'],
						'{xek:admin name="xek_announcement"}' => $system_array['xek_announcement'],
						'{xek:admin name="xek_smtp"}' => $system_array['xek_smtp'],
						'{xek:admin name="user"}' => $user_array['user'],
						'{xek:admin name="phone"}' => $user_array['phone'],
						'{xek:admin name="keys"}' => $user_array['keys'],
						'{xek:admin name="permissions"}' => $user_array['permissions'],
						'{xek:admin name="email"}' => $user_array['email'],
						'{xek:admin name="system_head"}' => $system_head,
						'{xek:admin name="system_footer"}' => $system_footer,
						'{xek:admin name="information"}' => $information
		);
			
		$content = strtr($content,$system);
		
		return $content;
	}
}