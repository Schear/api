<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @后台登录
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class admin_login {
	/**
	 * @后台登录标签
	 * @param boolean $content 传入格式化内容
	 */
	public function login($content) {
		
		$sql_pdo = new CoreSql();
		
		$sql_pdo -> PDO();
		
		$user = defined('XEK_user') ? XEK_user : '';
		
		$pass = defined('XEK_pass') ? XEK_pass : '';
		
		if(defined('XEK_login')) {
		
			$information = UserUtil::login($user, $pass);
			
			if($information == '1') {
				
				$information = '登录成功!';
				
				if(preg_match('/\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}/',$user)) {
					
					$user_array = $sql_pdo -> mysql_array("SELECT * FROM user WHERE email='{$user}';");
					
					$user = $user_array['user'];
				}
				
				setcookie("user", $user, time() + 60 * 60 * 24 * 1, HOST);
				
				setcookie("pass", $pass, time() + 60 * 60 * 24 * 1, HOST);
				
				header("location:index.php?page=index");
			}elseif($information == '0') {
				
				$information = '账号或密码错误!';
			}
		}
		
		$information = empty($information) ? 'Login' : $information;
		
		$login = array('{xek:admin name="user"}' => $user,
					   '{xek:admin name="pass"}' => $pass,
					   '{xek:admin name="information"}' => $information);
			
		$content = strtr($content,$login);
		
		return $content;
	}
}