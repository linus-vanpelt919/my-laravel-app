<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Calendar\CalendarView;//読み込み

class CalendarController extends Controller
{
   public function show(){//カレンダー表示用コントローラー
		
		$calendar = new CalendarView(time());

		return view('calendar', [//第一引数はcalendar.blade.phpのこと
			"calendar" => $calendar
		]);
	}
}