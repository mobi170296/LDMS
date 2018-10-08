<?php
	class MDatabase{
		private $connection;
		public function __construct($host, $username, $password, $dbname = '', $port = 3306){
			$this->connection = @new MySQLi($host, $username, $password, $dbname, $port);
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
			return $this->connection->query($sqlstring);
		}
		public function getConnection(){
			return $this->connection;
		}
		public function realEscapeString($str){
			return $this->connection->real_escape_string($str);
		}
		public function insert($tablename, $ps, $vs){
			$count = count($ps);
			$sqlstring = 'insert ' .$tablename. '(';
			for($i=0; $i<$count-1; $i++){
				$sqlstring .= $ps[$i].',';
			}
			$sqlstring .= $ps[$i] . ') values(';
			for($i=0; $i<$count-1; $i++){
				$vs[$i] = $this->connection->real_escape_string($vs[$i]);
				$sqlstring .= "'" . $vs[$i] . "'" . ',';
			}
			$sqlstring .= "'" . $vs[$i] . "'" . ')';
			echo $sqlstring;
			return $this->connection->query($sqlstring);
		}
		public function startTransactionRW(){
			return $this->connection->query('start transaction read write');
		}
		public function startTransactionRO(){
			return $this->connection->query('start transaction read only');
		}
		public function lockRow($sqlstring){
			$sqlstring .= ' for update';
			return $this->query($sqlstring);
		}
		public function commit(){
			return $this->connection->query('commit');
		}
		public function rollback(){
			return $this->connection->query('rollback');
		}
		public function lockTableW($tablename){
			return $this->query('lock table ' . $tablename . ' write');
		}
		public function lockTableR($tablename){
			return $this->query('lock table ' . $tablename . ' read');
		}
		public function close(){
			return $this->connection->close();
		}
	}
?>