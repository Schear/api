<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @后台词库
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class admin_dictionary {
	
	/**
	 * @后台词库标签
	 * @param boolean $content 传入格式化内容
	 */
	public function dictionary($content) {
		
		$sql_pdo = new CoreSql();
		
		$sql_pdo -> PDO();
		
		if (defined('XEK_delete')) 
		{
			$sql_pdo -> mysql("DELETE FROM qa_{$_COOKIE['user']} WHERE q = '" . XEK_delete . "';");
		}
		
		$dictionary_object = $sql_pdo -> mysql("SELECT * FROM `qa_{$_COOKIE['user']}`");
		
		foreach ($dictionary_object as $dictionary[]) {}

		$dictionary_qa = NULL;
		
		for ($x = 0;$x <= count($dictionary) - 1; $x++)
		{
			
			$dictionary_content = str_replace("#x_e_k#","--***--",$dictionary[$x]['a']);
			
			$delete = "<td class='center'><div class='btn-group'><button data-toggle='dropdown' class='btn btn-danger dropdown-toggle'>删除 <span class='caret'></span></button><ul class='dropdown-menu'><li><a href='".DOMAIN_FOLDER."index.php?page=dictionary&delete={$dictionary[$x]['q']}'>确定</a></li></ul></div></td>";
			
			$dictionary_qa .= "<tr class='{$dictionary[$x]['q']}'><td>{$dictionary[$x]['q']}</td><td>{$dictionary_content}</td>{$delete}</tr>\r\n";
		   }
		
		$dictionary = array('{xek:admin name="admin_dictionary"}' => "",
							'{xek:admin name="dictionary"}' => $dictionary_qa);
			
		$content = strtr($content,$dictionary);
		
		return $content;
	}
}