<?php
	class MSet{
		private $s;
		public function __construct($set = array()){
			$this->s = array();
			foreach($set as $value){
				if(!$this->contain($value))
					$this->s[] = $value;
			}
		}
		public function addElements($set){
			foreach($set as $value){
				if(!$this->contain($value))
					$this->s[count($this->s)] = $value;
			}
		}
		public function addElement($e){
			if(!$this->contain($e))
				$this->s[count($this->s)] = $e;
		}
		public function contain($e){
			foreach($this->s as $value){
				if($e == $value)
					return true;
			}
			return false;
		}
		public function removeElement($e){
			$count = count($this->s);
			for($i=0; $i<$count; $i++){
				if($this->s[$i]==$e){
					$this->s[$i] = $this->s[$count-1];
					unset($this->s[$count-1]);
					return;
				}
			}
		}
		public function getLength(){
			return count($this->s);
		}
		public function getAt($i){
			return $this->s[$i];
		}
		public function getNewValues(){
			
		}
		public function getOldValues(){
			
		}
	}
?>