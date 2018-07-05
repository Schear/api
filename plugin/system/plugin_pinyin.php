<?php if (!defined('XEK')) exit('You can not directly access the file.');

/**
 * @回复插件
 * @希尔凯
 * @http://www.14eowi.com
 * @1.0
 */
class plugin_pinyin{
	
	/**
	 * @插件内容填写
	 */
	public $plugin_name="概率测试模块";//插件名称
	public $plugin_author="希尔凯";//开发者
	public $plugin_about="xx,xx";//功能介绍
	public $plugin_version="1.0.0";//版本号
	
	/**
	 *插件主体
	 */
	 public function XEK()
	{
		$name=XEK_USER;
		$text=XEK_MSG;
		if(count(explode(',', $text))>1 )
		{
			$text=array_merge(explode(',', $text));
			similar_text($text[0],$text[1],$text);
			return array('text'=>urlencode($text));
		}
   }
}
?>