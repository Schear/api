<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @报价插件
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class plugin_price {
    /**
     * @插件内容填写
     */
    public $plugin_name = "报价插件"; //插件名称
    public $plugin_author = "希尔凯"; //开发者
    public $plugin_about = "格式:报价:xx"; //功能介绍
    public $plugin_version = "1.0.0"; //版本号
    
    /**
     *插件主体
     */
    public function XEK() {
        $name = XEK_USER;
        $text = XEK_MSG;
        if (preg_match("/报(.*)价|(.*)的价钱|(.*)多少钱/", $text)) {
            $text1 = "#x_e_k#" . $text . "#x_e_k#";
            if (preg_match("/帮我报一下(.*)这价/", $text1)) {
                $results = CoreUtil::middle($text1, '帮我报一下', '这价');
            }
            if (preg_match("/帮我报一下(.*)多少钱/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '帮我报一下', '多少钱');
            }
            if (preg_match("/帮我报一下(.*)#x_e_k#/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '帮我报一下', '#x_e_k#');
            }
            if (preg_match("/报价一下(.*)多少钱/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '报价一下', '多少钱');
            }
            if (preg_match("/报价一下(.*)#x_e_k#/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '报价一下', '#x_e_k#');
            }
            if (preg_match("/报一下(.*)多少钱/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '报一下', '多少钱');
            }
            if (preg_match("/报一下(.*)的价钱/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '报一下', '的价钱');
            }
            if (preg_match("/报价(.*)的价/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '报价', '的价');
            }
            if (preg_match("/报价(.*)多少钱/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '报价', '多少钱');
            }
            if (preg_match("/#x_e_k#(.*)的价/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '#x_e_k#', '的价');
            }
            if (preg_match("/#x_e_k#(.*)多少钱/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '#x_e_k#', '多少钱');
            }
            if (preg_match("/报价(.*)这/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '报价', '这');
            }
            if (preg_match("/报价:(.*)#x_e_k#/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '报价:', '#x_e_k#');
            }
            if (preg_match("/报价(.*)#x_e_k#/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '报价', '#x_e_k#');
            }
            if (preg_match("/#x_e_k#(.*)的报价/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '#x_e_k#', '的报价');
            }
            if (preg_match("/#x_e_k#(.*)报价/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '#x_e_k#', '报价');
            }
            //进入判断
            $text = str_replace("#x_e_k#", "", $results);
            $textfh = $text;
            if ($text != NULL) {
                $text = strip_tags($text);
                $text = urlencode($text);
                $text = file_get_contents("http://wap.zol.com.cn/index.php?c=List_List&keyword={$text}");
                $number = CoreUtil::middle($text, "找到“{$textfh}”的结果", '条');
                $text = CoreUtil::middle($text, '<div class="products"><ul>', '</ul>');
                $text = str_replace("&nbsp;", "", $text);
                $text = str_replace("</li>", "/newline/", $text);
                $img = CoreUtil::middle($text, '<img src="', '" alt="" />');
                $text = CoreUtil::html($text);
                if ($text == NULL || $number == '0') {
                    $text = "报价查询失败请检查清楚！";
                    $img = "";
                }
            } else {
                $text = "请输入要报价的商品!";
                $img = NULL;
            }
            return array('text' => urlencode($text), 'goods' => urlencode($textfh), 'img' => urlencode($img));
        }
    }
}
?>