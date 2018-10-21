<?php 
class AJAXEditResult{
	public $success, $messages;
	public function __construct($s, $ms){
		$this->success = $s;
		$this->messages = $ms;
	}
}