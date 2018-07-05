<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @后台聊天
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class admin_chat {
	
	/**
	 * @后台聊天标签
	 * @param boolean $content 传入格式化内容
	 */
	public function chat($content) {
		
		defined('XEK_type') ? : header("location:" . SCRIPT . "?page=chat&type=1#contain");
		
		if(empty($_COOKIE['user'])) {
			header("location:chat.php");
		}
		
		header("Cache-Control: no-cache"); 
	
		header("Pragma: no-cache");
		
		$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
		
		$uachar = "/(symbianos|android|Mac OS|ucweb|blackberry|Windows Phone|webOS|iPhone|iPod|BlackBerry)/i";
		
		if($ua != '' && preg_match($uachar, $ua)) {
			
			$phone_head   = NULL;
			
			$phone_footer = NULL;
			
			$win_head     = '<!--电脑模式';
			
			$win_footer   = '-->';
		}else {
			
			$phone_head   = '<!--手机模式';
			
			$phone_footer = '-->';
			
			$win_head     = NULL;
			
			$win_footer   = NULL;
		}
		
		$sql_pdo = new CoreSql();
		
		$sql_pdo -> PDO();
		
		$user_array = $sql_pdo -> mysql_array(BaseSql::SELECT('*', 'user', 'user', $_COOKIE['user']));
			
		if(XEK_type == 1) {
			
			$output1 = '您正处于本号调试模式,若要公共聊天模式请点击下方选择';
			
			$output2 = '<a href="' . SCRIPT . '?page=chat&type=2#contain"><i class="fa fa-globe fa-fw"></i>公共聊天模式</a>';
			
			$json_url= "key={$user_array['keys']}&type=1&text=";
		}
		if(XEK_type == 2) {
			
			$output1 = '您正处于公共聊天模式,若要本号测试模式请点击下方选择';
			
			$output2 = '<a href="' . SCRIPT . '?page=chat&type=1#contain"><i class="fa fa-globe fa-fw"></i>本号测试模式</a>';
			
			$time = time() + 60 * 60;
			
			$validation = CoreUtil::key($time);
			
			$json_url= "validation={$validation}&time={$time}&text=";
		}
		echo 'test:' . md5(time());
		$greetings = array('{xek:admin name="phone_head"}'   => $phone_head,
						   '{xek:admin name="phone_footer"}' => $phone_footer,
						   '{xek:admin name="win_head"}'     => $win_head,
						   '{xek:admin name="win_footer"}'   => $win_footer,
						   '{xek:admin name="output1"}'      => $output1,
						   '{xek:admin name="output2"}'      => $output2,
						   '{xek:admin name="json_url"}'     => $json_url);
						   			   
		$content = strtr($content,$greetings);
		
		return $content;
	}
}