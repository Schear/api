<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @种子插件
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class plugin_seeds {
    /**
     * @插件内容填写
     */
    public $plugin_name = "资源搜索"; //插件名称
    public $plugin_author = "希尔凯"; //开发者
    public $plugin_about = "格式:资源:xx（你懂的）[page为页数参数]"; //功能介绍
    public $plugin_version = "1.0.0"; //版本号
    
    /**
     *插件主体
     */
    public function XEK() {
        //初始化
        $name = XEK_USER;
        $text = XEK_MSG;
        $stable = XEK_STABLE;
		$page = defined('XEK_page') ? XEK_page : NULL;
        $results = NULL;
        //正则判断
        if (preg_match("/资源/", $text)) {
            $text1 = "#x_e_k#" . $text . "#x_e_k#";
            if (preg_match("/帮我找一下(.*)这资源/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '帮我找一下', '这资源');
            }
            if (preg_match("/帮我搜索一下(.*)这资源/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '帮我搜索一下', '这资源');
            }
            if (preg_match("/资源:(.*)#x_e_k#/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '资源:', '#x_e_k#');
            }
            if (preg_match("/资源(.*)#x_e_k#/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '资源', '#x_e_k#');
            }
            if (preg_match("/#x_e_k#(.*)资源/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '#x_e_k#', '资源');
            }
            $text = str_replace("#x_e_k#", "", $results);
            //如果内容不为空
            if ($text != NULL) {
                //读取内容
                $url ='http://chushihua.bthezi.net/acquisition.php?w='.urlencode($text)."&page={$page}";
                //创建资源
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 6);
                //取回资源
                $text = curl_exec($ch);
                //定义json为array数组
                $json = array();
                //把取回的json转换成数组
                $json = json_decode($text, true);
                $txt = array();
                $i = 0;
                //数组归类
                foreach ($json as $key => $val) {
                    if (is_numeric($val)) {
                        $txt[$i] = array('seeds' => $val['hash'], 'title' => $val['title'], 'size' => $val['size']);
                        $i++;
                    } else {
                        $txt[$i] = array('seeds' => $val['hash'], 'title' => $val['title'], 'size' => $val['size']);
                        $i++;
                    }
                }
                //生成格式化后的json
                $json = "";
                foreach ($txt as $val) {
                    $json.= "{";
                    foreach ($val as $k => $v) {
                        $v = str_replace('"', '\"', $v);
                        $json.= "\"$k\":\"$v\",";
                    }
                    $json = trim($json, ",");
                    $json.= "},";
                }
                $json = trim($json, ",");
                $json = str_replace("\n", " ", str_replace("\r\n", "\n", $json));
                //输出json
                return array('text' => urlencode($json));                
            }
        }
    }
}
?>