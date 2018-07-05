<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @邮件发送
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class EmailUtil {
	
	/**
	 * @邮件打包
	 * @param string $smtpemailto 收件人邮箱
	 * @param string $mailtitle   标题
	 * @param string $mailcontent 内容
	 * @param string $mailtype    格式
	 */
	public static function email($smtpemailto,$mailtitle,$mailcontent,$mailtype) {
		require_once CLASS_FOLDER . "email.class.php";
		//******************** 配置信息 ********************************
		 $smtpserver = 'smtp.163.com';//SMTP服务器
		 $smtpserverport =25;//SMTP服务器端口
	 	 $smtpusermail = 'xierkai@163.com';//SMTP服务器的用户邮箱
	 	 $smtpuser = 'xierkai@163.com';//SMTP服务器的用户帐号
	 	 $smtppass = 'bbjacky123eowi';//SMTP服务器的用户密码
		 //************************ 配置信息 ****************************
		 $smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
		 $smtp->debug = false;//是否显示发送的调试信息
		 $state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
		return $state; //返回字符串
	}
}
?>
