<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @分词插件
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class plugin_segmentation{
	
	/**
	 * @插件内容填写
	 */
	public $plugin_name="学习/分词系统";//插件名称
	public $plugin_author="希尔凯";//开发者
	public $plugin_about="分词:";//功能介绍
	public $plugin_version="1.0.0";//版本号
	
	/**
	 *插件主体
	 */
	 public function XEK()
	{
		$name=XEK_USER;
		$text=XEK_MSG;
		if(preg_match("/分词:/", $text))
		{
			$text=str_replace("分词:", "", $text);
			$pa=new PhpAnalysis();
			$pa->SetSource($text);
			$pa->differMax='';
			$pa->unitWord=1;
			$arr = $pa->StartAnalysis();
			return array('text'=> urlencode($pa->GetFinallyResult(',', $arr)));
		}
		if (preg_match("/(.*)是词/", $text)) {
                $results=str_replace("是词", "", $text);
            }
		if (preg_match("/(.*)是字/", $text)) {
                $results=str_replace("是字", "", $text);
            }
		if(!empty($results))
		{
			$sql_json = CoreSql::mysql_array("SELECT * FROM system WHERE name='xek_thesaurus';");
			$results_json = $sql_json['content'];
			if($results_json!=NULL)
			{
				if (!preg_match("/{$results}/", $results_json))
				{
					CoreSql::mysql("UPDATE system SET content = '{$results_json}|{$results}' WHERE system.name = 'xek_thesaurus';");
					return array('text'=> '学习成功!添加词\字为:'.$results);
				}
				else
				{
					return array('text'=> '检测到重复!重复词\字为:'.$results);
				}
			}
			else
			{
				CoreSql::mysql("UPDATE system SET content = '{$results}' WHERE system.name = 'xek_thesaurus';");
				return array('text'=> '学习成功!添加词\字为:'.$results);
			}
		}
   }
}
?>