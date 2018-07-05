<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @百科插件
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class plugin_wikipedia {
    /**
     * @插件内容填写
     */
    public $plugin_name = "百科插件"; //插件名称
    public $plugin_author = "希尔凯"; //开发者
    public $plugin_about = "格式:百科：xx"; //功能介绍
    public $plugin_version = "1.0.0"; //版本号
    
    /**
     *插件主体
     */
    public function XEK() {
        $name = XEK_USER;
        $text = XEK_MSG;
		$results = NULL;
        if (preg_match("/百科/", $text)) {
            $text1 = "#x_e_k#" . $text . "#x_e_k#";
            if (preg_match("/帮我百科一下(.*)这/", $text1)) {
                $results = CoreUtil::middle($text1, '帮我百科一下', '这');
            }
            if (preg_match("/帮我百科一下(.*)#x_e_k#/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '帮我百科一下', '#x_e_k#');
            }
            if (preg_match("/帮我百科(.*)这/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '帮我百科', '这');
            }
            if (preg_match("/帮我百科(.*)#x_e_k#/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '帮我百科', '#x_e_k#');
            }
            if (preg_match("/百科一下(.*)这/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '百科一下', '这');
            }
            if (preg_match("/百科一下(.*)#x_e_k#/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '百科一下', '#x_e_k#');
            }
            if (preg_match("/百科(.*)这/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '百科', '这');
            }
            if (preg_match("/百科:(.*)#x_e_k#/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '百科:', '#x_e_k#');
            }
            if (preg_match("/百科(.*)#x_e_k#/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '百科', '#x_e_k#');
            }
            if (preg_match("/#x_e_k#(.*)的百科/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '#x_e_k#', '的百科');
            }
            if (preg_match("/#x_e_k#(.*)百科/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '#x_e_k#', '百科');
            }
            //进入判断
            $text = str_replace("#x_e_k#", "", $results);
            $textfh = $text;
            if ($text != NULL) {
                $text = urlencode($text);
                $text = file_get_contents("http://baike.baidu.com/item/{$text}");
                $img = CoreUtil::middle($text, '<img src="', '" />');
                if (preg_match("/[\x7f-\xff]/", $img)) {
                    $img = CoreUtil::middle($text, '<img src="', '"/>');
                }
                $text = CoreUtil::middle($text, '<dd class="lemmaWgt-lemmaTitle-title">', '</dl></div>');
                $text = str_replace("&nbsp;", "", $text);
                $text = str_replace("编辑", "", $text);
                $text = str_replace("锁定", "", $text);
                $text = CoreUtil::html($text);
                $text = str_replace("本词条缺少名片图，补充相关内容使词条更完整，还能快速升级，赶紧来吧！", "", $text);
                if (mb_substr($text, 0, 10, 'utf-8') == '全球最大中文百科全书' || mb_substr($text, 0, 3, 'utf-8') == 'ad>') {
                    $text = "百科查询失败！";
                    $img = NULL;
                }
            } else {
                $text = "请输入内容";
                $img = NULL;
            }
            return array('text' => urlencode($text), 'goods' => urlencode($textfh), 'img' => urlencode($img));
        }
    }
}
?>