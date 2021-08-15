<?php
namespace App\Calendar;
use Carbon\Carbon;

class CalendarWeekDay {
	protected $carbon;

	function __construct($date){
		$this->carbon = new Carbon($date);
	}

	function getClassName(){
		return "day-" . strtolower($this->carbon->format("D"));//format()関数に「D」を指定すると「Sun」「Mon」などの曜日を省略形式で取得できる
	}

	/**
	 * @return 
	 */
	function render(){
		return '<p class="day">' . $this->carbon->format("j"). '</p>';//format()関数に「j」を指定すると先頭にゼロをつけない日付けを取得できる
	}
}