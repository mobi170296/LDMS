<?php
	require_once __DIR__.'/../../../config/defines.php';
	require_once __DIR__.'/../../classes/exceptions.php';
	class MDBFunctionData{
		private $fn;
		public function __construct($fn){
			$this->fn = $fn;
		}
		public function toDBValueString(){
			return $fn;
		}
	}
	class MDBPasswordData{
		private $data;
		public function __construct($data){
			$this->data = $data;
		}
		public function toDBValueString(){
			return "aes_encrypt('{$this->data}', '".DATABASE['AES_KEY']."')";
		}
	}
	class MDatabase{
		private $connection;
		public function __construct($host, $username, $password, $dbname = '', $port = 3306){
			$this->connection = @new MySQLi($host, $username, $password, $dbname, $port);
			if($this->connection->connect_errno){
				throw new DBException($this->connection->connect_error);
			}
		}
		public static function toDBValueString($value){
			switch(gettype($value)){
				case 'integer':
				case 'double':
					return $value;
				case 'boolean':
					return $value ? 1 : 0;
				case 'string':
					return "'$value'";
				case 'object':
					if(get_class($value)=='MDBPasswordData') return $value->toDBValueString();
					if(get_class($value)=='MDBFunctionData') return $value->toDBValueString();
					break;
				case 'NULL':
					return 'NULL';
			}
			return '';
		}
		public function getConnectError(){
			return $this->connection->connect_error;
		}
		public function getConnectErrno(){
			return $this->connection->connect_errno;
		}
		public function getError(){
			return $this->connection->error;
		}
		public function getErrno(){
			return $this->connection->errno;
		}
		public function query($sqlstring){
			$result = $this->connection->query($sqlstring);
			if(!$result){
				throw new DBException($this->connection->error);
			}
			return $result;
		}
		public function getInsertID(){
			return $this->connection->insert_id;
		}
		public function getConnection(){
			return $this->connection;
		}
		public function realEscapeString($str){
			return $this->connection->real_escape_string($str);
		}
		public function insert($tablename, $ps, $vs){
			$count = count($ps);
			$sqlstring = 'INSERT INTO ' .$tablename. '(';
			for($i=0; $i<$count-1; $i++){
				$sqlstring .= $ps[$i].',';
			}
			$sqlstring .= $ps[$i] . ') VALUES(';
			for($i=0; $i<$count-1; $i++){
				$sqlstring .= self::toDBValueString($vs[$i]) .',';
			}
			$sqlstring .= self::toDBValueString($vs[$i]). ')';
			$result = $this->connection->query($sqlstring);
			if(!$result){
				throw new DBException($this->connection->error);
			}
			return $result;
		}
		public function startTransactionRW(){
			$result = $this->connection->query('start transaction read write');
			if(!$result){
				throw new DBException($this->connection->error);
			}
			return $result;
		}
		public function startTransactionRO(){
			$result = $this->connection->query('start transaction read only');
			if(!$result){
				throw new DBException($this->connection->error);
			}
			return $result;
		}
		public function lockRow($sqlstring){
			$sqlstring .= ' for update';
			$result = $this->query($sqlstring);
			if(!$result){
				throw new DBException($this->connection->error);
			}
			return $result;
		}
		public function commit(){
			$result = $this->connection->query('commit');
			if(!$result){
				throw new DBException($this->connection->error);
			}
			return $result;
		}
		public function rollback(){
			$result = $this->connection->query('rollback');
			if(!$result){
				throw new DBException($this->connection->error);
			}
			return $result;
		}
		public function lockTableW($tablename){
			$result = $this->query('lock table ' . $tablename . ' write');
			if(!$result){
				throw new DBException($this->connection->error);
			}
			return $result;
		}
		public function lockTableR($tablename){
			$result = $this->query('lock table ' . $tablename . ' read');
			if(!$result){
				throw new DBException($this->connection->error);
			}
			return $result;
		}
		public function close(){
			$result = $this->connection->close();
			if(!$result){
				throw new DBException($this->connection->error);
			}
			return $result;
		}
		public function __toString(){
			return $this->connection->client_info;
		}
	}
?>