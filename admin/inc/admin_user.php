<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @后台用户
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class admin_user {

	/**
	 * @后台用户标签
	 * @param boolean $content 传入格式化内容
	 */
	public function user($content) {
		
		$sql_pdo = new CoreSql();
		
		$sql_pdo -> PDO();
		
		$user_array = $sql_pdo -> mysql_array("SELECT * FROM user WHERE user='{$_COOKIE['user']}';");
		
		$permissions_array = array('root', 'developers', 'admin', 'user');
		
		$permissions_inspection = array('admin', 'system','root');
		
		$permissions_admin = array('user', 'developers');
		
		$permissions_root = array('admin', 'user', 'developers');
		
		$memory_array = array('1000', '2000', '5000', '10000', '50000', '100000');
		
		/**
		 * @新增用户
		 */
		if (defined('XEK_add')) {
			
			if($user_array['permissions'] == 'system'){
							
				$return = UserUtil::add(XEK_user, XEK_pass, XEK_email, XEK_phone);
				
				if ($return == '0') {
					
					$information = "注册失败";
				}elseif ($return == '1') {
					
					$information = "注册成功!";
				}elseif ($return == '2') {
					
					$information = "账号重复,请更换账号重试!";
				}else {
					
					$information = $return;
				}
			}else {
				ErrorUtil::output('希尔凯表示您无权限增加{' . XEK_page . '}这个用户,sorry根据希尔凯的规矩只能由system添加用户!');
			}
		}
		
		/**
		 * @检测隶属组
		 */
		if (!in_array($user_array['permissions'], $permissions_inspection)) {
			
			ErrorUtil::output('希尔凯表示您无权限访问{' . XEK_page . '}这个页面,请问你打开想干嘛!');
		}
		
		if (defined('XEK_user') && !defined('XEK_add')) {
			
		$user_user_array = $sql_pdo -> mysql_array("SELECT * FROM user WHERE user='" . XEK_user . "';");
		
			if (XEK_user != NULL) {
				
				if (defined('XEK_activation') ) {
					
					if (XEK_activation == '1') {
						
						$sql_pdo -> mysql("UPDATE user SET activation = '1' WHERE user.user = '" . XEK_user . "';");
					}else {
						ErrorUtil::output('希尔凯表示无法识别{' . XEK_activation . '}这个激活参数,请问你输入想干嘛!');
					}
				}
				
				if (defined('XEK_permissions') ) {
					
					if (XEK_permissions == 'system') {
						
						ErrorUtil::output('希尔凯表示禁止修改创始管理员,请问你想作反?');
					}
					if (XEK_user == $_COOKIE['user']) {
						
						ErrorUtil::output('希尔凯表示禁止修改自己权限,请问你想作反?');
					}
					if (in_array($user_array['permissions'], $permissions_inspection) && in_array(XEK_permissions, $permissions_array )) {
						
						if ($user_array['permissions'] == 'root' && in_array(XEK_permissions, $permissions_root)) {
							
							$sql_pdo -> mysql("UPDATE user SET permissions = '" . XEK_permissions . "' WHERE user.user = '" . XEK_user . "';");
						}elseif($user_array['permissions'] == 'admin' && in_array(XEK_permissions, $permissions_admin)) {
								
							$sql_pdo -> mysql("UPDATE user SET permissions = '" . XEK_permissions . "' WHERE user.user = '" . XEK_user . "';");
						}elseif($user_array['permissions'] == 'system') {
							
							$sql_pdo -> mysql("UPDATE user SET permissions = '" . XEK_permissions . "' WHERE user.user = '" . XEK_user . "';");
						}else {
								
							ErrorUtil::output('希尔凯表示权限不足,呜喵喵喵?');
						}
					}else {
						
						ErrorUtil::output('希尔凯表示权限不足,呜喵喵喵?');
					}
				}
				if (defined('XEK_delete') ) {
					if (XEK_user == $_COOKIE['user']) {
						
						ErrorUtil::output('希尔凯表示干嘛想不开删除自己,呜喵喵喵?');
					}
					if ($user_user_array == 'system') {
						
						ErrorUtil::output('希尔凯表示禁止删除创始管理员,呜喵喵喵?');
					}
					
					if (in_array($user_array['permissions'], $permissions_inspection) && !in_array($user_user_array['permissions'], $permissions_inspection) ) {
						
						$sql_pdo -> mysql("DROP TABLE `qa_".XEK_user."`;");
						
						$sql_pdo -> mysql("DELETE FROM user WHERE user = '".XEK_user."';");
					}else {
						
						ErrorUtil::output('希尔凯表示权限不足,呜喵喵喵?');
					}
				}
				if (defined('XEK_memory') ) {
					
					if (in_array(XEK_memory, $memory_array) ) {
						
						$sql_pdo -> mysql("UPDATE user SET memory = '" . XEK_memory . "' WHERE user.user = '" . XEK_user . "';");
					} else {
						
						ErrorUtil::output('希尔凯表示内存参数错误,呜喵喵喵?');
					}
				}
			}else {
				
				ErrorUtil::output('希尔凯表示传入其他参数为空,呜喵喵喵?');
			}

		}
	
		/**
		 * 列出用户信息
		 */
		$usr_list = NULL;
		
		$user_object = $sql_pdo -> mysql("SELECT * FROM `user`");
		
		foreach ($user_object as $user_json[]) {}
		
		for ($i = 0; $i <= count($user_json) - 1; $i++) {
			
			if ($user_json[$i]['activation'] != "1") {
				$activation = "<td class='center'><div class='btn-group'><button data-toggle='dropdown' class='btn btn-danger dropdown-toggle'>未激活 <span class='caret'></span></button><ul class='dropdown-menu'><li><a href='" . DOMAIN_FOLDER . "index.php?page=user&user={$user_json[$i]['user']}&activation=1'>激活</a></li></ul></div></td>";
			}else {
				
				$activation = "<td class='center'><div class='btn-group'><button data-toggle='dropdown' class='btn btn-success dropdown-toggle'>已激活 <span class='caret'></span></button></div></td>";
			}
			
			if($user_json[$i]['permissions'] != NULL) {
				
				$permissions = "<td class='center'><div class='btn-group'><button data-toggle='dropdown' class='btn btn-success dropdown-toggle'>{$user_json[$i]['permissions']} <span class='caret'></span></button><ul class='dropdown-menu'>";
			}else {
				
				$permissions = "<td class='center'><div class='btn-group'><button data-toggle='dropdown' class='btn btn-success dropdown-toggle'>NULL <span class='caret'></span></button><ul class='dropdown-menu'>";
			}
			
			for($x = 0; $x <= count($permissions_array) - 1; $x++) {
				
				$permissions .= "<li><a href='" . DOMAIN_FOLDER . "index.php?page=user&user={$user_json[$i]['user']}&permissions=$permissions_array[$x]'>$permissions_array[$x]</a></li>";
			}
			
			$permissions .= "</ul></div></td>";
			
			$memory = "<td class='center'><div class='btn-group'><button data-toggle='dropdown' class='btn btn-success dropdown-toggle'>{$user_json[$i]['memory']} <span class='caret'></span></button><ul class='dropdown-menu'>";
			
			for($x = 0; $x <= count($memory_array) - 1; $x++) {
				
				$memory .= "<li><a href='" . DOMAIN_FOLDER . "index.php?page=user&user={$user_json[$i]['user']}&memory=$memory_array[$x]'>$memory_array[$x]</a></li>";
				
			}
			
			$memory .= "</ul></div></td>";
			
			if ($user_json[$i]['permissions'] == 'system') {
				
				$permissions = "<td class='center'><div class='btn-group'><button data-toggle='dropdown' class='btn btn-success dropdown-toggle'>system <span class='caret'></span></button></div></td>";
				
			}
			$delete = "<td class='center'><div class='btn-group'><button data-toggle='dropdown' class='btn btn-danger dropdown-toggle'>删除 <span class='caret'></span></button><ul class='dropdown-menu'><li><a href='" . DOMAIN_FOLDER . "?page=user&user={$user_json[$i]['user']}&delete=1'>确定</a></li></ul></div></td>";
			
			$usr_list .= "<tr class='{$user_json[$i]['user']}'>\n\r<td>{$user_json[$i]['user']}</td>\n\r<td>{$user_json[$i]['email']}</td>\n\r{$activation}\n\r{$permissions}\n\r{$memory}\n\r{$delete}\n\r</tr>";
		}
		
		/**
		 * @信息
		 */
		 if(empty($information)) {
			 $information = '用户列表';
		 }
		
		$user = array('{xek:admin name="admin_user"}' => "",
						   '{xek:admin name="information"}' => $information,
						   '{xek:admin name="usr_list"}' => $usr_list );
			
		$content = strtr($content,$user);
		
		return $content;
	}
}