<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @后台插件
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class admin_plugin {

	/**
	 * @后台插件标签
	 * @param boolean $content 传入格式化内容
	 */
	public function plugin($content) {
		
		$sql_pdo = new CoreSql();
		
		$sql_pdo -> PDO();
		
		$user_array = $sql_pdo -> mysql_array("SELECT * FROM user WHERE user='{$_COOKIE['user']}';");
		
		$system_plugin =  $sql_pdo -> mysql_array("SELECT * FROM system WHERE name='xek_plugin';");
		
		/**
		 * @插件变更
		 */
		 if (defined('XEK_plugin')) {
			if ($user_array['plugin'] != NULL) {
				if (preg_match('/'.XEK_plugin.'/', $user_array['plugin'])) {
					
					$user_plugin = explode(',', $user_array['plugin']);
					
					if (count($user_plugin) - 1 >= 1) {
						for ($i = 0; $i <= count($user_plugin) - 1; $i++) {
							if ($user_plugin[$i] != XEK_plugin) //处理结果
							{
								if (empty($user_plugin_content)) {
									
									$user_plugin_content = $user_plugin[$i];
								}else {
									
									$user_plugin_content .= ',' . $user_plugin[$i];
								}
							}
						}
					}
					if (XEK_plugin == $user_array['plugin']) {
						
						$user_plugin_content = '0';
					}
				}else {
					$user_plugin_content = $user_array['plugin'] . "," . XEK_plugin;
				}
				if ($user_array['plugin'] == '0' || $user_array['plugin'] == 'Array') {
					
					$user_plugin_content = XEK_plugin;
				}
			}
			if (!empty($user_plugin_content)) {
			
			$sql_pdo -> mysql("UPDATE user SET plugin = '{$user_plugin_content}' WHERE user.user = '{$_COOKIE['user']}';");
			
			$user_array = $sql_pdo -> mysql_array("SELECT * FROM user WHERE user='{$_COOKIE['user']}';");
			}
		}
		
		/**
		 * @上传插件
		 */
		if (defined('XEK_upload') && !empty($_FILES["file"]["name"])) {
				
			$temp_name_array = explode(".", $_FILES["file"]["name"]);
			
			$temp_name = end($temp_name_array);
			
			$user_upload_permissions = array("system", "admin", "developers");
			
			if (in_array($user_array['permissions'], $user_upload_permissions)) {
				if (UploadUtil::up(PLUGIN_FOLDER . 'system/', $_FILES["file"]["name"], $_FILES["file"]["tmp_name"], $_FILES["file"]["size"]) == NULL && $temp_name == 'php') {
					file('http://' . HOST . '/index.php?task=plugin');
					$information = '添加成功,重新载入网站查看!';
				} else {
					$information = '添加失败,上传文件格式不对';
				}
			} else {
				if (UploadUtil::up(PLUGIN_FOLDER . 'cache.php/', $_FILES["file"]["name"], $_FILES["file"]["tmp_name"], $_FILES["file"]["size"]) == NULL && $temp_name == 'php') {
					
					EmailUtil::email('312224992@qq.com', '插件审核', '<table style="" cellspacing="0" border="0" cellpadding="0" width="800"><tbody><tr><td style="font-size:14px;padding:50px 40px 20px 40px;"><p style="padding-bottom:20px;">账号为:' . $_COOKIE['user'] . '正在进行插件上传</p><p style="padding-bottom:20px;">请审核</p><p style="padding-bottom:20px;">' . $_FILES["file"]["name"] . '</p><p style="text-align:right;">—— 希尔凯</p></td></tr></tbody></table>', 'HTML');
					
					$information = '添加成功,正在审核,QQ:312224992!';
				}else {
					
					$information = '添加失败,上传文件格式不对';
				}
			}
		}
		
		/**
		 * @插件排列
		 */
		$plugin_array = explode('#_x_e_k_#', $system_plugin['content']);
		
		if (count($plugin_array) >= 1) {
			
			$plugin_list = NULL;
			
			for ($i = 0; $i <= count($plugin_array) - 1; $i++) {
				
				$plugin_content = explode('#x_e_k#', $plugin_array[$i]);
				
				if ($plugin_content[0] != "") {
					if (preg_match("/{$plugin_content[4]}/", $user_array['plugin'])) {
						
						$detection = "<td class='center'><div class='btn-group'><button data-toggle='dropdown' class='btn btn-success dropdown-toggle'>开启 <span class='caret'></span></button><ul class='dropdown-menu'><li><a href='./index.php?page=plugin&plugin={$plugin_content[4]}'>关闭</a></li></ul></div></td>";
						
					} else {
						
						$detection = "<td class='center'><div class='btn-group'><button data-toggle='dropdown' class='btn btn-danger dropdown-toggle'>关闭 <span class='caret'></span></button><ul class='dropdown-menu'><li><a href='./index.php?page=plugin&plugin={$plugin_content[4]}'>开启</a></li></ul></div></td>";
					}
					
					$plugin_list .= "<tr class='{$plugin_content[4]}'><td>{$plugin_content[0]}</td><td>{$plugin_content[1]}</td><td>{$plugin_content[4]}</td><td class='center'>{$plugin_content[3]}</td><td class='center'>{$plugin_content[2]}</td>{$detection}</tr>"; //btn btn-danger
				}
			}
		}
		
		/**
		 * @信息
		 */
		 if(empty($information)) {
			 $information = '插件列表';
		 }
		
		$plugin = array('{xek:admin name="admin_plugin"}' => "",
						'{xek:admin name="system_plugin"}' => $plugin_list,
						'{xek:admin name="information"}' => $information);
			
		$content = strtr($content,$plugin);
		
		return $content;
	}
}