<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @压缩类
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class ZipUtil {
	
	/**
	 * @压缩
	 * @param boolean $zip_address  zip地址
	 * @param boolean $address      文件地址array类型
	 * @param boolean $name         文件名字array类型
	 * @param boolean $download     是否需要下载
	 */
	public function zip($zip_address, $address, $name, $download = false){
		
		$zip=new ZipArchive();
		  
		$zip -> open($zip_address . 'download.zip', ZipArchive::CREATE);
		
		for ($i = 0; $i < count($address); $i++){
			
			 $zip -> addFile($address[$i], $name[$i]);
		}
		
		$zip -> close();
		
		if(!file_exists($zip_address . 'download.zip')) {
			
			return '压缩失败';
		}
		
		if($download) {
			
			  $this -> download($zip_address . 'download.zip' ,"download.zip"); //下载文件
			  
			  unlink($zip_address . 'download.zip'); //下载完成后要进行删除   
		} 
	}
	
	/**
	 * @下载
	 */
	public function download($zip_address, $name) {
		
		header("Pragma: public");  
		header("Expires: 0");  
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");  
		header("Cache-Control: public");   
		header("Content-Description: File Transfer");  
		header("Content-Type: $ctype");
		header("Content-Disposition: attachment; filename={$name};");  
		header("Content-Transfer-Encoding: binary");  
		header("Content-Length: ".filesize($zip_address));  
		ob_clean();
		flush();
		@readfile($zip_address);  
	}
}