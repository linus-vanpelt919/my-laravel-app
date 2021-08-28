<?php
namespace App\Calendar;

use Carbon\Carbon;
use App\Calendar\ExtraHoliday;
class CalendarView {//カレンダーを出力するためのCalendarViewクラスを作成
	protected $carbon;
	protected $holidays = [];

    protected function getWeeks(){
		$weeks = [];

		//初日2021-8月を例に
		$firstDay = $this->carbon->copy()->firstOfMonth(); // date: 2021-08-01 00:00:00.0 +00:00
        
		//月末まで
		$lastDay = $this->carbon->copy()->lastOfMonth(); //date: 2021-08-31 00:00:00.0 +00:00
        
		//1週目
		//$week = new CalendarWeek($firstDay->copy());
		//$weeks[] = $week;
		$weeks[] = $this->getWeek($firstDay->copy());
        
		//作業用の日
		$tmpDay = $firstDay->copy()->addDay(7)->startOfWeek(); //$firstDay->copy() 8/1 ->addDay(7) 8/8 ->startOfWeek() 8/2 
        //dump($tmpDay); //date: 2021-08-02 00:00:00.0 +00:00
		//月末までループさせる
        
		//月末までループしながら一週毎にCalendarWeekを作成
		while($tmpDay->lte($lastDay)){ //$tmpDay <= $lastDay
			
			//週カレンダーViewを作成する
			//$week = new CalendarWeek($tmpDay, count($weeks));//weeksの数
			//$weeks[] = $week;

			$weeks[] = $this->getWeek($tmpDay->copy(), count($weeks));
            //次の週=+7日する
			$tmpDay->addDay(7);
		}

		return $weeks;//週カレンダーを一月分用意した配列$weeksを返却
	}

	function __construct($date){
		$this->carbon = new Carbon($date);
	}
	/**
	 * タイトル
	 */
	public function getTitle(){
		return $this->carbon->format('Y年n月');
	}
	protected function getWeek(Carbon $date, $index = 0){
		return new CalendarWeek($date, $index);
	}
	/**
	 * カレンダーを出力する
	 */
	function render(){
		//HolidaySetting
		$setting = HolidaySetting::firstOrNew();
		$setting->loadHoliday($this->carbon->format("Y"));

		//臨時営業日の読み込み
		$this->holidays = ExtraHoliday::getExtraHolidayWithMonth($this->carbon->format("Ym"));

		$html = [];
		$html[] = '<div class="calendar">';
		$html[] = '<table class="table">';
		$html[] = '<thead>';
		$html[] = '<tr>';
		$html[] = '<th>月</th>';
		$html[] = '<th>火</th>';
		$html[] = '<th>水</th>';
		$html[] = '<th>木</th>';
		$html[] = '<th>金</th>';
		$html[] = '<th>土</th>';
		$html[] = '<th>日</th>';
		$html[] = '</tr>';
		$html[] = '</thead>';
		
		$html[] = '<tbody>';
		
		$weeks = $this->getWeeks();//週カレンダーオブジェクトの配列を取得
		foreach($weeks as $week){
			$html[] = '<tr class="'.$week->getClassName().'">';
			$days = $week->getDays($setting);
			// foreach($days as $day){
			// 	$html[] = '<td class="'.$day->getClassName().'">';
			// 	$html[] = $day->render();
			// 	$html[] = '</td>';
			// }
			foreach($days as $day){
				$html[] = $this->renderDay($day);
			}

			$html[] = '</tr>';
		}
		
		$html[] = '</tbody>';

		$html[] = '</table>';
		$html[] = '</div>';
		return implode("", $html);
	}
	/**
	 * 日を描画する
	 */
	protected function renderDay(CalendarWeekDay $day){
		$html = [];
		$html[] = '<td class="'.$day->getClassName().'">';
		$html[] = $day->render();
		$html[] = '</td>';
		return implode("", $html);
	}
	/**
	 * 次の月
	 */
	public function getNextMonth(){
		return $this->carbon->copy()->addMonthsNoOverflow()->format('Y-m');
	}
	/**
	 * 前の月
	 */
	public function getPreviousMonth(){
		return $this->carbon->copy()->subMonthsNoOverflow()->format('Y-m');
	}
}