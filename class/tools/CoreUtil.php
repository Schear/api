<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @核心工具
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class CoreUtil {
	
	/**
	 * 处理页面接收的参数，防止SQL注入
	 * @param string $param 接收的参数
	 * @param unknown $defVal 当没有此参数时的默认值
	 * @param boolean $is_bool 接收的参数是否转换为0/1（一般当参数的值为true、false、0、1时使用）
	 * @return string 返回经过处理的参数值
	 */
	public static function param_mysql_filter($param, $defVal = null, $is_bool = false) {
		$return_param = $defVal;
		if (isset($_GET["$param"])) $return_param = $_GET["$param"];
		elseif (isset($_POST["$param"])) $return_param = $_POST["$param"];
		if ($is_bool) return ($return_param == null || $return_param == "false" || $return_param === "0") ? 0 : 1;
		return ($return_param == null) ? null : trim(addslashes($return_param));
	}
	
	/**
	 * 判断是否接收到某参数
	 * @param string $param
	 * @return boolean
	 */
	public static function is_exits($param) {
		return isset($_GET["$param"]) ? true : (isset($_POST["$param"]) ? true : false);
	}
	
	/**
	 * 判断参数是否为空
	 * @param string $param 变量
	 * @return boolean 为空返回true，否则返回false
	 */
	public static function is_empty($param) {
		return ($param == null || $param == "") ? true : false;
	}
	
	/**
	 * 根据传入的数组，随机返回该数组的一个元素
	 * @param array $arraySrc		原数组
	 * @param boolean $is_shuffle	是否重新给数组排序
	 * @return unknown
	 */
	public static function random_array($arraySrc, $is_shuffle = false) {
		if ($is_shuffle) shuffle($arraySrc);
		$rowCount = count($arraySrc);
		$rowRand = rand(1, $rowCount) - 1;
		return $arraySrc[$rowRand];
	}

	/**
	 * 把字符串的首字母变成小写，因为PHP5.3之前不支持lcfirst函数，所有重写了此函数
	 * @param string $input
	 * @return string
	 */
	public static function lcfirst($input) {
		$first = mb_strtolower(mb_substr($input, 0, 1, "utf8"), "utf8");
		$other = mb_substr($input, 1, mb_strlen($input, "utf8") - 1, "utf8");
		return $first . $other;
	}
	
	/**
	 * 生成随机字符
	 * @param int $length
	 * @param int $type
	 * @return string | int
	 */
	public static function getRandString($length = 12, $type = 0) {
		$lower	= range('a', 'z');
		$upper	= range('A', 'Z');
		$number	= range(0, 9);

		if($type == 0) {
			$chars = array_merge($lower, $upper, $number);
		} elseif($type == 1) {
			$chars = $lower;
		} elseif($type == 2) {
			$chars = $upper;
		} elseif($type == 3) {
			$chars = array_merge($lower, $upper);
		} elseif($type == 4) {
			$chars = $number;
		}

		shuffle($chars);
		$char_keys	= array_rand($chars, $length);
		shuffle($char_keys);

		$rand = '';
		foreach($char_keys as $key) {
			$rand .= $chars[$key];
		}
		return $rand;
	}

	/**
	 * 把数组的VALUE拼成字符串，用port隔开
	 * @param array $array
	 * @param string $port
	 * @return string
	 */
	public static function arrayToString($array, $port) {
		$str = "";
		foreach ($array as $key=>$value) {
			$str .= ($value . $port); 
		}
		return rtrim($str, $port);
	}

	/**
	 * 获取访问者IP
	 * @return Ambigous <string, unknown>
	 */
	public static function getIP() {
		$ip = "";
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
			$ip = getenv("HTTP_CLIENT_IP");
		} else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		} else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
			$ip = getenv("REMOTE_ADDR");
		} else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
			$ip = $_SERVER['REMOTE_ADDR'];
		} else {
			$ip = "unknown";
		}
		if (strpos($ip, ',')) {
			$ipArr = explode(',', $ip);
			$ip = $ipArr[0];
		}
		return $ip;
	}
	
	/**
	 * 取出中间字符串
	 * @param string $str 欲取出字符原文
	 * @param string $leftStr 左边字符
	 * @param string $rightStr 右边字符
	 */
	public static  function middle($str, $leftStr, $rightStr)  {
		  $left = strpos($str, $leftStr);
		  $right = strpos($str, $rightStr,$left);
		  if($left < 0 or $right < $left) return '';
		  $v=substr($str, $left + strlen($leftStr), $right-$left-strlen($leftStr));
          return $v;
	 }
	 
	/**
	 * 判断某个字符串的头是否为某个字符或字符串
	 * @param string $string 字符
	 * @param string $full 要判断的原字符串
	 * @return boolean 如果是返回true，不是返回false
	 */
	public static function head_key($string, $full) {
		$array = explode($string, $full);
		$number = count($array) -1;
		if ($number >= 1 && $array[0] == NULL) {
			return true;
		}
		return false;
	}
	
	/**
	 * 判断某个字符串是否为某个字符或字符串
	 * @param string $string 字符
	 * @param string $full 要判断的原字符串
	 * @return boolean 如果是返回true，不是返回false
	 */
	public static function text_key($string, $full) {
		$array = explode($string, $full);
		$number = count($array) -1;
		if ($number >= 1) {
			return true;
		}
		return false;
	}
	
	/**
	 * 判断某个字符串的结尾是否为某个字符或字符串
	 * @param string $char 字符
	 * @param string $input 要判断的原字符串
	 * @return boolean 如果是返回true，不是返回false
	 */
	public static function tail_key($string, $full) {
		$array = explode($string, $full);
		$number = count($array) -1;
		if ($array[$number] == NULL) {
			return true;
		}
		return false;
	}
	
	/**
	 * @html格式化
	 * @param string $str为传入格式化内容
	 */
	public static function html($str) {
		$str = strip_tags($str);
		$str = trim($str); //清除字符串两边的空格
		$str = preg_replace("/\t/","",$str); //使用正则表达式替换内容，如：空格，换行，并将替换为空。
		$str = preg_replace("/\r\n/","",$str); 
		$str = preg_replace("/\r/","",$str); 
		$str = preg_replace("/\n/","",$str); 
		$str = preg_replace("/ /","",$str);
		return $str; //返回字符串
	}
	
	/**
	 * @key
	 * @param string $key 内容
	 */
	public static function key($key) {
		
		$key = md5( base64_encode( $key));
		
		return $key;
	}
}
?>