<?php if (!defined('XEK')) exit('You can not directly access the file.');
/**
 * @sql语法页
 * @希尔凯
 * @http://www.xek17.com
 * @version 4.3
 */

class BaseSql {
	
	/**
	 * @获取表
	 * @param boolean $column_name  列名字
	 * @param boolean $table_name   表名字
	 * @param boolean $column  列
	 * @param boolean $value   值
	 */
	static function SELECT($column_name, $table_name, $column = false, $value = false) {
		
		$column_name = $column_name == '*' ? '*' : '`' . $column_name . '`';
		
		if($column) {
			
			return "SELECT {$column_name} FROM `{$table_name}` WHERE {$column} = '{$value}';";
		}else {
			
			return "SELECT {$column_name} FROM `{$table_name}`;";
		}
	}
	
	/**
	 * @更改表
	 * @param boolean $table_name   表名字
	 * @param boolean $column_name  列名字
	 * @param boolean $newvalue     新值
	 * @param boolean $column       列
	 * @param boolean $value        值
	 */
	static function UPDATE($table_name, $column_name, $newvalue, $column, $value) {
		
		return "UPDATE {$table_name} SET {$column_name} = '{$newvalue}' WHERE {$table_name}.{$column} = '{$value}';";
	}
	
	/**
	 * @删除表
	 * @param boolean $table_name   表名字
	 * @param boolean $column       列
	 * @param boolean $value        值
	 */
	static function DELETE($table_name, $column = false, $value = false) {
		
		if($column) {
			return "DELETE FROM `{$table_name}` WHERE {$column} = '{$value}';";
		}else {
			return "DELETE FROM `{$table_name}`;";
		}
	}
	
	/**
	 * @添加列
	 * @param boolean $table_name    表名字
	 * @param boolean $column_array  列值
	 * @param boolean $value_array   值
	 */
	static function INSERT($table_name, $column_array, $value_array) {
		
		$column = NULL;
		
		$value = NULL;
		
		if($column_array == NULL) {
			for($i = 0; $i <= count($value_array) - 1; $i++) {
				
				if($value == NULL) {
					
					$value = "'{$value_array[$i]}'";
				}else {
					
					$value .= ", '{$value_array[$i]}'";
				}
			}
			
			return "INSERT INTO `{$table_name}` ($value);";
		}else {
			for($i = 0; $i <= count($column_array) - 1; $i++) {
				
				if($column == NULL) {
					
					$column = "`{$column_array[$i]}`";
					
					$value = "'{$value_array[$i]}'";
				}else {
					
					$column .= ", `{$column_array[$i]}`";
					
					$value .= ", '{$value_array[$i]}'";
				}
			}
			
			return "INSERT INTO `{$table_name}` ($column) VALUES ($value);";
		}
	}
	
	/**
	 * @创建表
	 * @param boolean $table_name   表名字
	 * @param boolean $column_name  列名字
	 */
	static function CREATE($table_name, $column_array) {
		
		$column = NULL;
		
		for($i = 0; $i <= count($column_array) - 1; $i++) {
			
			if($column == NULL) {
				
				$column = "`{$column_array[$i]}` text CHARACTER SET utf8 COLLATE utf8_bin";
			}else {
				
				$column .= ", `{$column_array[$i]}` text CHARACTER SET utf8 COLLATE utf8_bin";
			}
		}
		
		return "CREATE TABLE `{$table_name}` ({$column});";
	}
}