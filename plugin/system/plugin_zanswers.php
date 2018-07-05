<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @回复插件
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class plugin_zanswers {
    /**
     * @插件内容填写
     */
    public $plugin_name = "回复插件"; //插件名称
    public $plugin_author = "希尔凯"; //开发者
    public $plugin_about = "格式:xx"; //功能介绍
    public $plugin_version = "1.0.0"; //版本号
    
    /**
     *插件主体
     */
    public function XEK() {
        $name = XEK_USER;
		
        $text = XEK_MSG;
		
		$sql_pdo = new CoreSql();
		
		$sql_pdo -> PDO();
		
		$sql_json = $sql_pdo -> mysql_array("SELECT * FROM qa_{$name} WHERE q='{$text}'");
		
		if($sql_json != NULL) {
			
			$results = explode('#x_e_k#', $sql_json['a']);
			
			$i = count($results) - 1;
			
			$i = mt_rand(0, $i);
			
			if ($results[$i] != NULL) {
				return array('text' => urlencode($results[$i]));
			}
		}else {
			return array('text' => '');
		}
    }
}
?>