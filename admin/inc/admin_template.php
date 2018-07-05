<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @后台模块
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class admin_template {
	/**
	 * @后台模块标签
	 * @param boolean $content 传入格式化内容
	 */
	public function template($content) {
		
		$sql_pdo = new CoreSql();
		
		$sql_pdo -> PDO();
		
		$domain = DOMAIN_FOLDER;
		
		$permissions_inspection = array('admin', 'system','root');
		
		$user_array = $sql_pdo -> mysql_array(BaseSql::SELECT('*', 'user', 'user', $_COOKIE['user']));
		
		/**
		 * @检测隶属组
		 */
		if (!in_array($user_array['permissions'], $permissions_inspection)) {
			
			ErrorUtil::output('希尔凯表示您无权限访问{' . XEK_page . '}这个页面,请问你打开想干嘛!');
		}
		
		if(defined('XEK_save')) {
		}
		
		if(defined('XEK_delete')) {
			
			$sql_pdo -> mysql(BaseSql::DELETE('template', 'name', XEK_name));
		}
		if(defined('XEK_add')) {
			
			if(defined('XEK_name')) {
				
				$name = $sql_pdo -> mysql_array(BaseSql::SELECT('*', 'template', 'name', XEK_name));
				
				if(empty($name['name'])) {
					
					$column_array = array('name', 'menu', 'file', 'permissions', 'icon');
					
					$value_array  = array(XEK_name, XEK_menu, XEK_file, XEK_permissions, XEK_icon);
					
					$sql_pdo -> mysql(BaseSql::INSERT('template', $column_array, $value_array));
				}
			}else {
				
				echo '名称不能为空';
			}
		}
		
		$template_object = $sql_pdo -> mysql(BaseSql::SELECT('*', 'template'));
		
		foreach($template_object as $template_array[]){}
		
		$template = NULL;
		
		for ($i = 0; $i < count($template_array); $i++) 
		{
			$operation = "<td class='center'><div class='btn-group'><button data-toggle='dropdown' class='btn btn-success dropdown-toggle'>操作 <span class='caret'></span></button><ul class='dropdown-menu'><li><a href='{$domain}index.php?page=template&name={$template_array[$i]['name']}&save=1'>保存</a></li><li><a href='{$domain}index.php?page=template&name={$template_array[$i]['name']}&delete=1'>删除</a></li></ul></div></td>";
			$template .=  "<tr class='{$template_array[$i]['name']}'>\n\r<td>{$template_array[$i]['name']}</td>\n\r<td>{$template_array[$i]['menu']}</td>\n\r<td>{$template_array[$i]['file']}</td>\n\r<td>{$template_array[$i]['permissions']}</td>\n\r<td>{$template_array[$i]['icon']}</td>\n\r{$operation}\n\r";
		}
		
		$template = array('{xek:admin name="$template"}' => $template);
			
		$content = strtr($content,$template);
		
		return $content;
	}
}