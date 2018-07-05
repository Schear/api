<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @源码插件
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class plugin_source {
    /**
     * @插件内容填写
     */
    public $plugin_name = "源码抓取"; //插件名称
    public $plugin_author = "希尔凯"; //开发者
    public $plugin_about = "格式:源码:http://xxx.xx.xxx"; //功能介绍
    public $plugin_version = "1.0.0"; //版本号
    
    /**
     *插件主体
     */
    public function XEK() {
        $name = XEK_USER;
        $text = XEK_MSG;
		$results = NULL;
        if (preg_match("/源码/", $text)) {
            $text1 = "#x_e_k#" . $text . "#x_e_k#";
            if (preg_match("/帮我抓一下(.*)这源码/", $text1)) {
                $results = CoreUtil::middle($text1, '帮我抓一下', '这源码');
            }
            if (preg_match("/帮我抓取一下源码(.*)#x_e_k#/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '帮我抓取一下源码', '#x_e_k#');
            }
            if (preg_match("/抓取(.*)这源码/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '抓取', '这源码');
            }
            if (preg_match("/抓取源码(.*)#x_e_k#/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '抓取源码', '#x_e_k#');
            }
            if (preg_match("/源码：(.*)#x_e_k#/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '源码：', '#x_e_k#');
            }
            if (preg_match("/源码(.*)#x_e_k#/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '源码', '#x_e_k#');
            }
            if (preg_match("/#x_e_k#(.*)的源码/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '#x_e_k#', '的源码');
            }
            if (preg_match("/#x_e_k#(.*)源码/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '#x_e_k#', '源码');
            }
            //进入判断
            $text = str_replace("#x_e_k#", "", $results);
            if ($text != NULL) {
                $text = file_get_contents($text);
                return array('text' => urlencode($text));
            }
        }
    }
}
?>