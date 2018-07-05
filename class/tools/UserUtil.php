<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @用户操作页
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class UserUtil {
	
	/**
	 * @增加用户
	 * @param boolean $user        账号
	 * @param boolean $pass        密码
	 * @param boolean $email       邮箱
	 * @param boolean $phone       手机 
	 * @param boolean $permissions 隶属组
	 */
	static function add($user = false, $pass = false, $email = false, $phone = false, $permissions = false) {
		
		$sql_pdo = new CoreSql();
		
		$sql_pdo -> PDO();
		
		$permissions = $permissions ? $permissions : 'user';
		
		if(!$user){
			
			return "账号不能为空";
		}elseif(!preg_match('/^[0-9A-Za-z]{3,16}$/',$user)){
			
			return "账号只能为数字英文最小3位最大16位!";
		}elseif(!$pass){
			
			return "密码不能为空";
		}elseif(!preg_match('/^[0-9A-Za-z]{6,16}$/',$pass)) {
			
			return "密码只能为数字英文最小6位最大16位!";
		}elseif(!$email) {
			
			return "邮箱不能为空";
		}elseif(!preg_match('/\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}/',$email)) {
			
			return "邮箱格式出错!";
		}
		
		$user_array = $sql_pdo -> mysql_array("SELECT * FROM user WHERE user='{$user}';");
		
		$email_array = $sql_pdo -> mysql_array("SELECT * FROM user WHERE email='{$email}';");
			
		if($user_array != NULL) {
			
			return '2';
		}elseif($email_array != NULL) {
			
			return '3';
		}
			
		$log = NULL;
			
		for($i = 1;$i <= date('j'); $i++) {
			
			$log .= '#x_e_k#' . $i . ',' . '0';
		}
		$key = CoreUtil::key( $user . 'key');
		
		$pass = CoreUtil::key( $pass);
		
		$column = array('user', 'pass', 'email', 'phone', 'plugin', 'activation', 'permissions', 'keys', 'ip', 'time', 'memory', 'vip', 'log');
		
		$value = array($user, $pass, $email, NULL, 'plugin_zanswers', '0', $permissions, $key, NULL, time(), '1000', '', $log);
		
		$create = array('q', 'a', 'pinyin');
		
		if($sql_pdo -> mysql_exec(BaseSql::INSERT('user', $column, $value)) && !$sql_pdo -> mysql_exec(BaseSql::CREATE("qa_{$user}", $create))) {
			
			return '1';
		}else {
			
			return '0';
		}
	}
	
	/**
	 * @用户登录验证
	 * @param boolean $user        账号
	 * @param boolean $pass        密码
	 */
	static function login($user = false, $pass = false) {
		
		$sql_pdo = new CoreSql();
		
		$sql_pdo -> PDO();
		
		if(!$user){
			
			return "账号不能为空";
		}elseif(!preg_match('/^[0-9A-Za-z]{3,16}$/',$user) && !preg_match('/\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}/',$user)){
			
			return "账号只能为数字英文或邮箱且最小3位最大16位!";
		}elseif(!$pass){
			
			return "密码不能为空";
		}elseif(!preg_match('/^[0-9A-Za-z]{6,16}$/',$pass)) {
			
			return "密码只能为数字英文最小6位最大16位!";
		}
		
		if(preg_match('/^[0-9A-Za-z]{3,16}$/',$user)) {
			
			$user_array = $sql_pdo -> mysql_array("SELECT * FROM user WHERE user='{$user}';");
		}elseif(preg_match('/\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}/',$user)) {
			
			$user_array = $sql_pdo -> mysql_array("SELECT * FROM user WHERE email='{$user}';");
		}
		
		if($user_array['pass'] == CoreUtil::key($pass)) {
			
			return '1';
		}else {
			
			return '0';
		}
	}
	
	/**
	 * @用户激活检测
	 * @param boolean $user        账号
	 * $param boolean $activation  是否未激活自动激活
	 */
	static function activation($user = false, $activation = false) {
		
		$sql_pdo = new CoreSql();
		
		$sql_pdo -> PDO();
		
		if(!$activation) {
			
			$user_array = $sql_pdo -> mysql_array("SELECT * FROM user WHERE user='{$user}';");
			
			return $user_array['activation'];
		}
	}
}