<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @SQL核心(类处理)
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */
 
class CoreSql {
	
	protected $sql_pdo;
	
	/**
	 * @建立PDO连接
	 */
	public function PDO(){
		try {

		$this->sql_pdo = new PDO('mysql:host='.XEK_HOST_SQL.';
		
		dbname='.XEK_DB_SQL, 
		
		XEK_USER_SQL, 
		
		XEK_PASS_SQL,
		
		array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));} 
		
		catch (PDOException $error) {
		
		ErrorUtil::output(
		
		'Connection failed: ' . 
		
		iconv("GBK", "UTF-8", $error -> getMessage()));}
		
		$this->sql_pdo->query('set names "UTF8"');
		
		return $this->sql_pdo;
	}
	
	/**
	 * @mysql语句查询
	 * @param boolean $text sql语句
	 */
	public function mysql($text){
		
		if(empty($this->sql_pdo)){
			
			$this -> sql_pdo = $this -> PDO();}
			
		return $this -> sql_pdo -> query($text);
	}
	
	/**
	 * @mysql_array数组查询(返回数组)
	 * @param boolean $text sql语句
	 */
	public function mysql_array($text){
		
		if(empty($this->sql_pdo)){
			
			$this->sql_pdo = $this->PDO();}
			
		$results_object = $this -> sql_pdo -> query($text);
		
		$results_array = NULL;
		
		foreach($results_object as $results_array){}
		
		unset($results_object);
		
		return $results_array;
	}
	
	/**
	 * @mysql_array数组管理(返回数组)
	 * @param boolean $text sql语句
	 */
	public function mysql_array_management($text){
		
		if(empty($this->sql_pdo)){
			
			$this->sql_pdo = $this->PDO();}
			
		$results_object = $this -> sql_pdo -> query($text);
		
		$results_array = NULL;
		
		foreach($results_object as $results_array[]){}
		
		unset($results_object);
		
		return $results_array;
	}
	
	/**
	 * @mysql_exec语句真假查询(返回真或假)
	 * @param boolean $text sql语句
	 */
	public function mysql_exec($text){
		
		if(empty($this->sql_pdo)){
			
			$this->sql_pdo = $this->PDO();}
			
		return $this->sql_pdo->exec($text);
	}
}
?>