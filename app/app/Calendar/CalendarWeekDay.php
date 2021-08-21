<?php
namespace App\Calendar;
use Carbon\Carbon;

class CalendarWeekDay {
	protected $carbon;
	protected $isHoliday = false;

	function __construct($date){
		$this->carbon = new Carbon($date);
	}
	function getClassName(){
			$classNames = [ "day-" . strtolower($this->carbon->format("D")) ];
		
			//祝日フラグを出す
			if($this->isHoliday){
				$classNames[] = "day-close";
			}
		
			return implode(" ", $classNames);
	}
	// function getClassName(){
	// 	return "day-" . strtolower($this->carbon->format("D"));//format()関数に「D」を指定すると「Sun」「Mon」などの曜日を省略形式で取得できる
	// }

	/**
	 * @return 
	 */
	function render(){
		return '<p class="day">' . $this->carbon->format("j"). '</p>';//format()関数に「j」を指定すると先頭にゼロをつけない日付けを取得できる
	}

	/**
	 * 休みかどうかを判定する
	 */
	function checkHoliday(HolidaySetting $setting){
		
		if($this->carbon->isMonday() && $setting->isCloseMonday()){
			$this->isHoliday = true;	
		}
		else if($this->carbon->isTuesday() && $setting->isCloseTuesday()){
			$this->isHoliday = true;	
		}
		else if($this->carbon->isWednesday() && $setting->isCloseWednesday()){
			$this->isHoliday = true;	
		}
		else if($this->carbon->isThursday() && $setting->isCloseThursday()){
			$this->isHoliday = true;	
		}
		else if($this->carbon->isFriday() && $setting->isCloseFriday()){
			$this->isHoliday = true;	
		}
		else if($this->carbon->isSaturday() && $setting->isCloseSaturday()){
			$this->isHoliday = true;	
		}
		else if($this->carbon->isSunday() && $setting->isCloseSunday()){
			$this->isHoliday = true;	
		}
		
		//祝日は曜日とは別に判定する
		if($setting->isCloseHoliday() && $setting->isHoliday($this->carbon)){
			$this->isHoliday = true;
		}
		
	}
}