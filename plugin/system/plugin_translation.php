<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @翻译插件
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class plugin_translation {
    /**
     * @插件内容填写
     */
    public $plugin_name = "翻译插件"; //插件名称
    public $plugin_author = "希尔凯"; //开发者
    public $plugin_about = "格式:翻译:文字,国家（默认中国）"; //功能介绍
    public $plugin_version = "2.0.0"; //版本号
    
    /**
     *插件主体
     */
    public function XEK() {
        //初始化
        $name = XEK_USER;
        $text = XEK_MSG;
        //创建资源
        $ch = curl_init();
        $results = NULL;
        //建立连接
        curl_setopt($ch, CURLOPT_URL, "http://api.fanyi.baidu.com/api/trans/vip/translate");
        //正则判断
        if (preg_match("/翻译/", $text)) {
            $text1 = "#x_e_k#" . $text . "#x_e_k#";
            if (preg_match("/帮我翻译一下(.*)这/", $text1)) {
                $results = CoreUtil::middle($text1, '帮我翻译一下', '这');
            }
            if (preg_match("/帮我翻译一下(.*)#x_e_k#/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '帮我翻译一下', '#x_e_k#');
            }
            if (preg_match("/帮我翻译(.*)这/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '帮我翻译', '这');
            }
            if (preg_match("/帮我翻译(.*)#x_e_k#/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '帮我翻译', '#x_e_k#');
            }
            if (preg_match("/翻译一下(.*)这/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '翻译一下', '这');
            }
            if (preg_match("/翻译一下(.*)#x_e_k#/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '翻译一下', '#x_e_k#');
            }
            if (preg_match("/翻译(.*)这/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '翻译', '这');
            }
            if (preg_match("/翻译：(.*)#x_e_k#/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '翻译：', '#x_e_k#');
            }
            if (preg_match("/翻译(.*)#x_e_k#/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '翻译', '#x_e_k#');
            }
            if (preg_match("/#x_e_k#(.*)的翻译/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '#x_e_k#', '的翻译');
            }
            if (preg_match("/#x_e_k#(.*)翻译/", $text1) && $results == NULL) {
                $results = CoreUtil::middle($text1, '#x_e_k#', '翻译');
            }
            $text = str_replace("#x_e_k#", "", $results);
            //如果内容不为空
            if ($text != NULL) {
                //分割文本
                if (count(explode(',', $text)) > 1) {
                    $txt = explode(',', $text);
                    if ($txt[1] == NULL) {
                        return array('text' => urlencode("请输入要翻译的国家\n\rzh中文\n\ren英语\n\ryue粤语\n\rwyw文言文\n\rjp日语\n\rkor韩语\n\rfra法语\n\rspa西班牙语\n\rth泰语\n\rara阿拉伯语\n\rru俄语\n\rpt葡萄牙语\n\rde德语\n\rit意大利语\n\rel希腊语\n\rnl荷兰语\n\rpl波兰语\n\rbul保加利亚语\n\rest爱沙尼亚语\n\rdan丹麦语\n\rfin芬兰语\n\rcs捷克语\n\rrom罗马尼亚语\n\rslo斯洛文尼亚语\n\rswe瑞典语\n\rhu匈牙利语\n\rcht繁体中文\n\rvie越南语"));
                    } else {
                        $text = $txt[0];
                        $language = 'zh,en,yue,wyw,jp,kor,fra,spa,th,ara,ru,pt,de,it,el,nl,pl,bul,est,dan,fin,cs,rom,slo,swe,hu,cht,vie';
                        if (preg_match("/{$txt[1]}/", $language)) {
                            $language = $txt[1];
                        } else {
                            return array('text' => urlencode("国家输入错误,请正确输入以下国家的简写\n\rzh中文\n\ren英语\n\ryue粤语\n\rwyw文言文\n\rjp日语\n\rkor韩语\n\rfra法语\n\rspa西班牙语\n\rth泰语\n\rara阿拉伯语\n\rru俄语\n\rpt葡萄牙语\n\rde德语\n\rit意大利语\n\rel希腊语\n\rnl荷兰语\n\rpl波兰语\n\rbul保加利亚语\n\rest爱沙尼亚语\n\rdan丹麦语\n\rfin芬兰语\n\rcs捷克语\n\rrom罗马尼亚语\n\rslo斯洛文尼亚语\n\rswe瑞典语\n\rhu匈牙利语\n\rcht繁体中文\n\rvie越南语"));
                        }
                    }
                } else {
                    $language = 'zh';
                }
                if ($language != NULL) {
                    //提交POST
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "q={$text}&from=auto&to={$language}&appid=20170306000041563&salt=520&sign=" . md5("20170306000041563{$text}520vrNIN_R1t6dPVl3GgpIw"));
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $text = curl_exec($ch);
                    //关闭资源
                    curl_close($ch);
                    //json解析
                    $json = array();
                    $json = json_decode($text, true);
                    //print_r($json);
                    if (!empty($json['error_code'])) {
                        return array('text' => urlencode('翻译失败:' . $json['error_code']));
                    }
                    $text = $json['trans_result'][0]['dst'];
                    return array('text' => urlencode($text));
                }
            }
        }
    }
}
?>