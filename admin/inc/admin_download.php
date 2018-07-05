<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @后台下载
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class admin_download {
	/**
	 * @后台下载标签
	 * @param boolean $content 传入格式化内容
	 */
	public function download($content) {
		
		if(defined('XEK_download')) {
			
			$xek_cfg  = ROOT . 'admin/mapping/xek.cfg';
			
		    $document = ROOT . 'admin/mapping/document.txt';
			
		    $xek_exe  = ROOT . 'admin/mapping/' . XEK_download . '/xek';
			
			$xek='xek';
			
			unlink ($xek_cfg);
			
			if(!file_exists($xek_exe)) {
				
				$xek_exe = ROOT . 'admin/mapping/' . XEK_download . '/xek.exe';
				
				$xek='xek.exe';
			}
			$fp = fopen($xek_cfg, 'w+') or die('cant not create file');
			
			fwrite($fp, 'server_addr: "xek17.com:4443"
	trust_host_root_certs: false
	tunnels:
		http:
			proto:
				http: 8080
			hostname: '.$_COOKIE['user'].'.14eowi.com');
			
			fclose($fp);
			
			$address_array = array($xek_cfg, $document, $xek_exe);
			
			$address_name  = array('xek.cfg', 'document.txt', $xek);
			
			$zip = new ZipUtil();
			
			$zip -> zip(ROOT . 'admin/mapping/', $address_array, $address_name, true);
		}
		
		return $content;
	}
}