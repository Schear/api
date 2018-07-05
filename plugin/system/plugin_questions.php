<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @问答插件
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class plugin_questions {
    /**
     * @插件内容填写
     */
    public $plugin_name = "问答插件"; //插件名称
    public $plugin_author = "希尔凯"; //开发者
    public $plugin_about = "格式:问:xx答:xx"; //功能介绍
    public $plugin_version = "1.0.0"; //版本号
    
    /**
     *插件主体
     */
    public function XEK() {
        $name = XEK_USER;
        $text = XEK_MSG;
		$sql_pdo = new CoreSql();
		$sql_pdo -> PDO();
        if (preg_match("/问:(.*)/", $text)) {
            $json['a'] = NULL;
            $text = str_replace("问:", "", $text);
            if ($text != NULL && preg_match('/[^ ]+$/', $text)) {
                if (count(explode('答:', $text)) > 1) {
                    $text = array_merge(explode('答:', $text));
                    if (preg_match('/[^ ]+$/', $text[1])) {
                        $sql = "SELECT * FROM qa_{$name} WHERE q='{$text[0]}';";
                        //json返回
                        $sql_json = $sql_pdo -> mysql($sql);
						foreach($sql_json as $json){}
                    } else {
                        return array('text' => urlencode('内容不能是空格开头或全空格!'));
                        $json['a'] = NULL;
                    }
                } else {
                    return array('text' => urlencode('请输入回复内容!'));
                    $json['a'] = NULL;
                }
            } else {
                return array('text' => urlencode('格式 问:xx答:xx(开头不能为空格或者全空格)'));
            }
            if ($json['a'] != NULL) {
                //分析
                $results = explode('#x_e_k#', $json['a']);
                $processing = "0";
                for ($i = 0;$i <= count($results) - 1;$i++) { //如果已经存在
                    if ($results[$i] == $text[1]) {
                        $processing = "1";
                    };
                }
                if ($processing != "1") { //内容更新模块($name为用户名$json['a']为数据库内容$text[1]为问题内容$text[0]为问题)
                    $sql = "UPDATE qa_{$name} SET a = '{$json['a']}#x_e_k#{$text[1]}' WHERE qa_{$name}.q = '{$text[0]}';";
                    if (!$sql_pdo -> mysql_exec($sql)) {
                        return array('text' => urlencode('数据库内容更新失败!'), 'results' => urlencode("keywords:{$text[0]}reply:{$text[1]}"));
                    }
                    return array('text' => urlencode('内容更新成功!'), 'results' => urlencode("keywords:{$text[0]}reply:{$text[1]}"));
                } else { //检测重复模块
                    return array('text' => urlencode('内容重复已忽略!'), 'results' => urlencode("keywords:{$text[0]}reply:{$text[1]}"));
                }
            }
            if ($json['a'] == NULL) { //学习模块
				$sql_json = $sql_pdo -> mysql("SELECT `q` FROM `qa_{$name}`");
				$jsons = array();
				foreach($sql_json as $jsons[]){}
				$sql_json = $sql_pdo -> mysql_array("SELECT * FROM user WHERE user='{$name}';");
                $memory = $sql_json['memory'];
                if (count($jsons) <= $memory) {
                    if (PinyinUtil::pinyin($text[0]) == NULL) {
                        $pinyin = $text[0];
                    } else {
                        $pinyin = PinyinUtil::pinyin($text[0]);
                    }
                    $sql = "INSERT INTO`qa_{$name}`(`q`,`a`,`pinyin`) VALUES('{$text[0]}', '{$text[1]}', '{$pinyin}');";
                    if (!$sql_pdo -> mysql_exec($sql)) {
                        return array('text' => urlencode('学习失败!'), 'results' => urlencode("keywords:{$text[0]}reply:{$text[1]}"));
                    }
                    return array('text' => urlencode('学习成功!'), 'results' => urlencode("keywords:{$text[0]}reply:{$text[1]}"));
                } else {
                    return array('text' => urlencode('词库已上限,请升级!'), 'error' => '403');
                }
            }
        }
    }
}
?>