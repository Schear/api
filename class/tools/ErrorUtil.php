<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @Error错误页
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class ErrorUtil {
	
	/**
	 * @die
	 * @param boolean $error  错误内容
	 * @param boolean $output 输出 默认直接echo格式输出
	 * @param boolean $die    暂停程序 默认为暂停
	 */
	static function output($error, $output = false, $die = true) {
		
		$label = new LabelUtil();
		
		$content = $label -> file(ROOT.TEMPLATE_FOLDER.'404.html');
	
		$content = strtr($content,array('{xek:error}' => $error));
		
		$content = $label -> formatting($content);
		
		if($output) {return $content;}else{echo $content;}
		
		if($die) die();
		}
}