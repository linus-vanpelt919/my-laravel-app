<?php
namespace App\Calendar;

use Carbon\Carbon;

class CalendarWeek {//その週のカレンダーを出力するためのクラス

	protected $carbon;
	protected $index = 0;

	function __construct($date, $index = 0){
		$this->carbon = new Carbon($date);
		$this->index = $index;
	}

	function getClassName(){
		return "week-" . $this->index;
	}

	/**
	 * @return CalendarWeekDay[]
	 */
	function getDays(HolidaySetting $setting){
		$days = [];
		//開始日〜終了日
		$startDay = $this->carbon->copy()->startOfWeek();
		$lastDay = $this->carbon->copy()->endOfWeek();

		//作業用
		$tmpDay = $startDay->copy();

		//月曜日〜日曜日までループ
		while($tmpDay->lte($lastDay)){

			//前の月、もしくは後ろの月の場合は空白を表示
			if($tmpDay->month != $this->carbon->month){//月を比較
				$day = new CalendarWeekBlankDay($tmpDay->copy());
				$day->checkHoliday($setting);
				$days[] = $day;
				$tmpDay->addDay(1);
				continue;	
			}
				
			//今月
			//$day = new CalendarWeekDay($tmpDay->copy());
			$days[] = $this->getDay($tmpDay->copy(), $setting);	
			// $day->checkHoliday($setting);
			// $days[] = $day;
			//翌日に移動
			$tmpDay->addDay(1);
		}
		
		return $days;
	}
	function getDay(Carbon $date, HolidaySetting $setting){
				$day = new CalendarWeekDay($date);
				$day->checkHoliday($setting);
				return $day;
	}
}
