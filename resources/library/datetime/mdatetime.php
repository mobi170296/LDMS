<?php
	class MDateTime{
		private $day, $month, $year, $hour, $minute, $second;
		public function __construct($day, $month, $year, $hour=0, $minute=0, $second=0){
			$this->day = $day;
			$this->month = $month;
			$this->year = $year;
			$this->hour = $hour;
			$this->minute = $minute;
			$this->second = $second;
		}
		public static function parseDate($date){
			if(preg_match('/(\d{1,4})-(\d{1,2})-(\d{1,2})/', $date, $adate)){
				return new MDateTime($adate[3], $adate[2], $adate[1]);
			}else{
				return null;
			}
		}
		public static function parseTime($time){
			if(preg_match('/(\d{1,2}):(\d{1,2}):(\d{1,2})/', $time, $adate)){
				return new MDateTime($adate[1], $adate[2], $adate[3]);
			}else{
				return null;
			}
		}
		public static function parseDateTime($datetime){
			if(preg_match('/(\d{1,4})-(\d{1,2})-(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})/', $datetime, $adate)){
				return new MDateTime($adate[3], $adate[2], $adate[1], $adate[4], $adate[5], $adate[6]);
			}else{
				return null;
			}
		}
		public function getDay(){
			return $this->day;
		}
		public function getMonth(){
			return $this->month;
		}
		public function getYear(){
			return $this->year;
		}
		public function getHour(){
			return $this->hour;
		}
		public function getMinute(){
			return $this->minute;
		}
		public function getSecond(){
			return $this->second;
		}
		public function getDate($delimiter='/'){
			return sprintf('%02d' . $delimiter . '%02d' . $delimiter . '%04d', $this->day, $this->month, $this->year);
		}
		public function getTime($delimiter=':'){
			return sprintf('%02d' . $delimiter . '%02d' . $delimiter . '%02d', $this->hour, $this->minute, $this->second);
		}
		public function getDateTime($dd='/', $td=':'){
			return $this->getDate() . ' ' . $this->getTime();
		}
	}
?>