<?php
	class DBException extends Exception{
		public function __construct($msg){
			parent::__construct($msg);
		}
	}
	class MissingPrivilegeException extends Exception{
		public function __construct($msg){
			parent::__construct($msg);
		}
	}
	class ExistedUserException extends Exception{
		public function __construct($msg){
			parent::__construct($msg);
		}
	}
	class ExistedDepartmentException extends Exception{
		public function __construct($msg){
			parent::__construct($msg);
		}
	}
	class DatabaseErrorException extends Exception{
		public function __construct($msg){
			parent::__construct($msg);
		}
	}
	class NotExistedGroupException extends Exception{
		public function __construct($msg){
			parent::__construct($msg);
		}
	}
	class NotExistedDepartmentException extends Exception{
		public function __construct($msg){
			parent::__construct($msg);
		}
	}
	class NotExistedUserException extends Exception{
		public function __construct($msg){
			parent::__construct($msg);
		}
	}
	class ExistedLegalDocumentException extends Exception{
		public function __construct($msg){
			parent::__construct($msg);
		}
	}
	class NotExistedLegalDocumentException extends Exception{
		public function __construct($msg){
			parent::__construct($msg);
		}
	}
	class ExistedDocTypeException extends Exception{
		public function __construct($msg){
			parent::__construct($msg);
		}
	}
	class NotExistedDocTypeException extends Exception{
		public function __construct($msg){
			parent::__construct($msg);
		}
	}
	class ExistedIssuedUnitException extends Exception{
		public function __construct($msg){
			parent::__construct($msg);
		}
	}
	class NotExistedIssuedUnitException extends Exception{
		public function __construct($msg){
			parent::__construct($msg);
		}
	}
	class MultipleErrorException extends Exception{
		private $errors;
		public function __construct($errors){
			$this->errors = $errors;
		}
		public function getErrors(){
			return $this->errors;
		}
	}
	class NotValidFormDataException extends Exception{
		private $errors;
		public function __construct($errors){
			$this->errors = $errors;
		}
		public function getErrors(){
			return $this->errors;
		}
	}
	class LoginFailedException extends Exception{
		public function __construct($msg){
			parent::__construct($msg);
		}
	}
?>