<?php 
	
	class DB {
		public static $pdo = [];

		public static function mq($sql, $arr = []) {
			if (!self::$pdo) {
				self::$pdo = new PDO("mysql:host=localhost; dbname=rco; charset=utf8mb4", "", "", [
					19 => 2,
					3 => 2,
				]);
			}

			$q = self::$pdo->prepare($sql);
			$q->execute(arr($arr));

			return $q;
		}

		public static function find($table, $sql, $arr = []) {
			return self::mq("SELECT * FROM $table WHERE $sql", $arr)->fetch();
		}

		public static function findall($table, $sql, $arr = []) {
			return self::mq("SELECT * FROM $table WHERE $sql", $arr)->fetchAll();
		}

		public static function count($table, $sql, $arr = []) {
			return self::mq("SELECT * FROM $table WHERE $sql", $arr)->rowcount();
		}

		public static function insert($table, $data) {
    	   	$sql = implode(" = ?, " , array_keys($data));
    	   	self::mq("INSERT INTO $table SET {$sql} = ?", array_values($data));
    	  	return self::$pdo->lastInsertId();
    	}

	}




 ?>