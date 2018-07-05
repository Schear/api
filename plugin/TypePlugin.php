<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @类型解析
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class TypePlugin {
	public function json($text) {
		return urldecode(json_encode($text));
	}
	
	public function txt($text) {
		
		$txt = NULL;
		
		foreach ($text as $key => $val) {
			
			$txt .= $key . ":" . urldecode($val) . "\n\r";
		}
		
		return $txt;
	}
	
	public function xml($text) {
		
		$xml = "<xml>";
		
		foreach ($text as $key => $val) {
			
			$xml .= "\n\r<" . $key . ">" . urldecode($val) . "</" . $key . ">";
		}
		
		$xml .= "\n\r</xml>";
		
		return $xml;
	}
	public function test($text) {
		
		foreach ($text as $key => $val) {
			
			if($key == 'text') {
				
				$txt = urldecode($val);
			}
		}
		if(empty($txt)){ 
		
			$txt='未有匹配结果,不如你发送问:xx答:xx教我学习吧!';
		}
		
		return $txt;
	}
}

?>