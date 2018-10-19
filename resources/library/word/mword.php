<?php
class MWord{
	public static function trim($str){
		$str = trim($str);
		return preg_replace('/\s+/', ' ', $str);
	}
	public static function count($str){
		$str = self::trim($str);
		$word = 0;
		$length = mb_strlen($str, 'UTF-8');
		for($i=0;$i<$length; $i++){
			$char = mb_substr($str, $i, 1);
			if($char == ' '){
				$word++;
			}
		}
		if($length!=0){
			$word++;
		}
		return $word;
	}
}