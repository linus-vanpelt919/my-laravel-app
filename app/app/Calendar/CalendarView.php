<?php
namespace App\Calendar;

use Carbon\Carbon;

class CalendarView {//カレンダーを出力するためのCalendarViewクラスを作成

	private $carbon;

    protected function getWeeks(){
		$weeks = [];

		//初日2021-8月を例に
		$firstDay = $this->carbon->copy()->firstOfMonth(); // date: 2021-08-01 00:00:00.0 +00:00
        
		//月末まで
		$lastDay = $this->carbon->copy()->lastOfMonth(); //date: 2021-08-31 00:00:00.0 +00:00
        
		//1週目
		$week = new CalendarWeek($firstDay->copy());
        //dump($week);
		$weeks[] = $week;
        
		//作業用の日
		$tmpDay = $firstDay->copy()->addDay(7)->startOfWeek(); //$firstDay->copy() 8/1 ->addDay(7) 8/8 ->startOfWeek() 8/2 
        //dump($tmpDay); //date: 2021-08-02 00:00:00.0 +00:00
		//月末までループさせる
        
		//月末までループしながら一週毎にCalendarWeekを作成
		while($tmpDay->lte($lastDay)){ //$tmpDay <= $lastDay
			
			//週カレンダーViewを作成する
			$week = new CalendarWeek($tmpDay, count($weeks));//weeksの数
			//dd($week);
			$weeks[] = $week;
			
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

	/**
	 * カレンダーを出力する
	 */
	function render(){
		//HolidaySetting
		$setting = HolidaySetting::firstOrNew();
		$setting->loadHoliday($this->carbon->format("Y"));
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
			foreach($days as $day){
				$html[] = '<td class="'.$day->getClassName().'">';
				$html[] = $day->render();
				$html[] = '</td>';
			}
			$html[] = '</tr>';
		}
		
		$html[] = '</tbody>';

		$html[] = '</table>';
		$html[] = '</div>';
		return implode("", $html);
	}

}