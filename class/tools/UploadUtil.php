<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @上传文件
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class UploadUtil {
	
	/**
	 * @die
	 * @param boolean $address  存放地址
	 * @param boolean $name     插件名称
	 * @param boolean $tmp_name 临时地址
	 * @param boolean $size     文件大小
	 */
	static function up($address, $name, $tmp_name, $size) {
		
		$allowedExts = array("txt" ,"php" ,"html" ,"css" ,"js" ,"xml" ,"sap" ,"zip");
		
		$temp = explode(".", $name);
		
		$extension = end($temp);
		
		if (($size < 204800) && in_array($extension, $allowedExts)) {
			
			if(!move_uploaded_file($tmp_name, $address. '/' . $name)) {
				
				return '502';
			}
		}else {
			
			return "501";
		}
	}
}