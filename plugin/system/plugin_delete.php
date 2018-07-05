<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @删除插件
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class plugin_delete {
    /**
     * @插件内容填写
     */
    public $plugin_name = "删除插件"; //插件名称
    public $plugin_author = "希尔凯"; //开发者
    public $plugin_about = "格式:删:xx,如果要删除随机中的某个词,删:xx词:xx"; //功能介绍
    public $plugin_version = "1.0.0"; //版本号
    
    /**
     *插件主体
     */
    public function XEK() {
        $name = XEK_USER;
        $text = XEK_MSG;
		$sql_pdo = new CoreSql();
		$sql_pdo -> PDO();
        if (preg_match("/删:(.*)/", $text)) {
            $json['a'] = NULL;
            $text = str_replace("删:", "", $text);
            if ($text != NULL) {
                if (count(explode('词:', $text)) > 1) {
                    $text = array_merge(explode('词:', $text));
                    $processing = "0";
                    $sql = "SELECT * FROM qa_{$name} WHERE q='{$text[0]}';";
                    $sql_json = $sql_pdo->mysql($sql);
						foreach($sql_json as $json){}
                    $results = explode('#x_e_k#', $json['a']);
                    $content = NULL;
                    for ($i = 0;$i <= count($results) - 1;$i++) {
                        if ($results[$i] != $text[1]) {
                            if ($content == NULL) {
                                $content = $results[$i];
                            } else {
                                $content = $content . '#x_e_k#' . $results[$i];
                            }
                        }
                    }
                    $sql = "UPDATE qa_{$name} SET a = '{$content}' WHERE qa_{$name}.q = '{$text[0]}';";
                    if (!$sql_pdo->mysql_exec($sql)) {
                        return array('text' => urlencode('删除内容失败!'), 'results' => urlencode("keywords:{$text[0]}reply:{$text[1]}"));
                    }
                    return array('text' => urlencode('删除内容成功!'), 'results' => urlencode("keywords:{$text[0]}reply:{$text[1]}"));
                } else {
                    $sql = "DELETE FROM qa_{$name} WHERE q = '{$text}';";
                    if (!$sql_pdo->mysql_exec($sql)) {
                        return array('text' => urlencode('删除问题失败!'), 'results' => urlencode("keywords:{$text}"));
                    }
                    return array('text' => urlencode('删除问题成功!'), 'results' => urlencode("keywords:{$text}"));
                }
            } else {
                return array('text' => urlencode('请输入删除的库或词！格式:删:xx,如果要删除随机中的某个词,删:xx词:xx'));
            }
        }
    }
}
?>