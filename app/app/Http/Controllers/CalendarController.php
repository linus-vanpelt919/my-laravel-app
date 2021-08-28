<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
//use App\Calendar\CalendarView;//読み込み
use App\Calendar\Output\CalendarOutputView;//use句を使用することで、エイリアスを省略できる

class CalendarController extends Controller
{
//    public function show(){//カレンダー表示用コントローラー

// 		//$calendar = new CalendarView(time());
// 		$calendar = new CalendarOutputView(time());
// 		return view('calendar', [//第一引数はcalendar.blade.phpのこと
// 			"calendar" => $calendar
// 		]);
// 	}
	public function show(Request $request){

		//クエリーのdateを受け取る
		$date = $request->input("date");
		//dateがYYYY-MMの形式かどうか判定する
		if($date && preg_match("/^[0-9]{4}-[0-9]{2}$/", $date)){
			$date = $date . "-01";
			//$date = strtotime($date);
		}else{
			$date = null;
		}

		//取得出来ない時は現在(=今月)を指定する
		//if(!$date)$date = time();
		if(!$date)$date = Carbon::now('Asia/Tokyo')->format("Y-m-d");
		//カレンダーに渡す
		$calendar = new CalendarOutputView($date);
		return view('calendar', [
			"calendar" => $calendar
		]);
	}
}
