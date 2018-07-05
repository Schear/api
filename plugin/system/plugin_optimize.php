<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @百度优化查询
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class plugin_optimize {
    /**
     * @插件内容填写
     */
    public $plugin_name = "百度优化查询"; //插件名称
    public $plugin_author = "希尔凯"; //开发者
    public $plugin_about = "格式:优化:关键词,网站"; //功能介绍
    public $plugin_version = "1.0.0"; //版本号
    
    /**
     *插件主体
     */
    public function XEK() {
        $name = XEK_USER;
        $text = XEK_MSG;
        if (preg_match("/优化:(.*)/", $text)) {
            $text = str_replace("优化:", "", $text);
            $text = str_replace("，", ",", $text);
            if ($text != NULL) {
                $text = explode(',', $text);
                if ($text[1] != NULL) {
                    $keywords = $text[0];
                    $text[0] = urlencode($text[0]);
                    $statistical = 0;
                    for ($x = 0;$x <= 10;$x++) {
                        $results = file_get_contents("http://www.baidu.com/s?wd={$text[0]}");
                        if ($results == NULL) {
                            return array('text' => urlencode("延迟过高或者关键词有误"), 'keywords' => urlencode($keywords));
                        }
                        if (preg_match("/{$text[1]}/", $results)) {
                            $statistical = $statistical + 1;
                        }
                    }
                    $statistical = $statistical * 10;
                    $content = array('text' => urlencode($statistical . '%'), 'keywords' => urlencode($keywords));
                    return urldecode(json_encode($content));
                } else {
                    return array('text' => urlencode("请输入网站"));
                }
            } else {
                return array('text' => urlencode("请输入关键词"));
            }
        }
    }
}
?>