<?php 

	
	namespace model;

	use \PDO;

	class _base {
		public static $pdo = [];
		public function mq($sql, $arr = []) {
			if (!self::$pdo) {
				// PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC == 19 => 2;
				self::$pdo = new PDO("mysql:host=localhost;charset=utf8;dbname=rco", "", "", [ PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ] );
			}

			$q = self::$pdo->prepare($sql);
			$q->execute($arr);

			return $q;
		}
		
		public function ma($sql, $arr = []) {
			return self::mq($sql, $arr)->fetchAll();
		}

		public function mr($sql, $arr = []) {
			return self::mq($sql, $arr)->rowcount();
		}

		public function insert($table, $data) {
    	   	$sql = implode(" = ?, " , array_keys($data));
    	   	self::mq("INSERT INTO $table SET {$sql} = ?", array_values($data));
    	  	return self::$pdo->lastInsertId();
    	}

		

		

	}


 ?>
