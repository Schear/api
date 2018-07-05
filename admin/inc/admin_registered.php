<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @后台注册
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class admin_registered {
	/**
	 * @后台注册标签
	 * @param boolean $content 传入格式化内容
	 */
	public function registered($content) {
		
		$sql_pdo = new CoreSql();
		
		$sql_pdo -> PDO();
		
		$user = defined('XEK_user') ? XEK_user : '';
		
		$pass = defined('XEK_pass') ? XEK_pass : '';
		
		$email = defined('XEK_email') ? XEK_email : '';
		
		if(defined('XEK_registered')) {
		
			$information = UserUtil::add($user, $pass, $email);
			
			if($information == '1') {
				
				$information = '注册成功!';
				
				setcookie("user", $user, time() + 60 * 60 * 24 * 1, HOST);
				
				setcookie("pass", $pass, time() + 60 * 60 * 24 * 1, HOST);
				
				header("location:index.php?page=index");
			}elseif($information == '0') {
				
				$information = '注册失败!';
			}elseif($information == '2') {
				
				$information = '账号重复!';
			}elseif($information == '3') {
				
				$information = '该邮箱已经注册过了!';
			}
		}
		
		$information = empty($information) ? 'Registered' : $information;
		
		$login = array('{xek:admin name="user"}' => $user,
					   '{xek:admin name="pass"}' => $pass,
					   '{xek:admin name="email"}' => $email,
					   '{xek:admin name="information"}' => $information);
			
		$content = strtr($content,$login);
		
		return $content;
	}
}