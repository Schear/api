<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @后台开发者
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class admin_developers {
	/**
	 * @后台开发者标签
	 * @param boolean $content 传入格式化内容
	 */
	public function developers($content) {
		
		$sql_pdo = new CoreSql();
		
		$sql_pdo -> PDO();
		
		$user_array = $sql_pdo -> mysql_array(BaseSql::SELECT('*', 'user', 'user', $_COOKIE['user']));
		
		if(defined('XEK_name') && defined('XEK_qq') && defined('XEK_code') && empty($_COOKIE['developer'])){
			
		EmailUtil::email('312224992@qq.com',
						 '开发者提交信',
						 '<h1>开发者名称:'   . XEK_name .
						 '<br /><br />QQ:' . XEK_qq   .
						 '<br /><br />IP:' . XEK_ip   .
						 '<br /><br /><p>' . XEK_code .
						 '</p></h1>',
						 'HTML');
		$information =   '开发者申请提交成功！';
		
		setcookie("developer", 'disabled=""', time() + 60 * 60 * 24 * 1);
		}
		
		$information = empty($information) ? '开发者申请' : $information;
		
		$developers = array('{xek:admin name="information"}' => $information);
			
		$content = strtr($content,$developers);
		
		return $content;
	}
}