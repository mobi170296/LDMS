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
		public function getHours(){
			return $this->hour;
		}
		public function getMinutes(){
			return $this->minute;
		}
		public function getSeconds(){
			return $this->second;
		}
		public function getDateString($delimiter='/'){
			return sprintf('%02d' . $delimiter . '%02d' . $delimiter . '%04d', $this->day, $this->month, $this->year);
		}
		public function getTimeString($delimiter=':'){
			return sprintf('%02d' . $delimiter . '%02d' . $delimiter . '%02d', $this->hour, $this->minute, $this->second);
		}
		public function getDateTimeString($dd='/', $td=':'){
			return $this->getTimeString($td) .' '. $this->getDateString($dd);
		}
		
		
		public function getDateDBString($delimiter='/'){
			return sprintf('%04d' . $delimiter . '%02d' . $delimiter . '%02d', $this->year, $this->month, $this->day);
		}
		public function getTimeDBString($delimiter=':'){
			return sprintf('%02d' . $delimiter . '%02d' . $delimiter . '%02d', $this->hour, $this->minute, $this->second);
		}
		public function getDateTimeDBString($dd='/', $td=':'){
			return $this->getDateDBString($dd) . ' ' . $this->getTimeDBString($td);
		}
	}
	class MCalendar{
		public static function getMaxDayOfMonth($month, $year){
			if($month<=0 || $month>12 || $year<=0) return false;
			$m4 = $year % 4 == 0;
			$m100 = $year % 100 == 0;
			$m400 = $year % 400 == 0;
			$maxday = [31, ($m4 & !($m100 ^ $m400)) ? 29 : 28 , 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
			return $maxday[$month-1];
		}
	}
?>