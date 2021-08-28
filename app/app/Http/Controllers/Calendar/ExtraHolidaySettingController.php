<?php
namespace App\Http\Controllers\Calendar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendar\Form\CalendarFormView;//viewを使用
use App\Calendar\ExtraHoliday;//モデルを使用
class ExtraHolidaySettingController extends Controller
{
	public function form(Request $request){
		
		// $calendar = new CalendarFormView(time());
		// return view('calendar/extra_holiday_setting_form', [
		// 	"calendar" => $calendar
		// ]);

		//クエリーのdateを受け取る
		$date = $request->input("date");

		//dateがYYYY-MMの形式かどうか判定する
		if($date && strlen($date) == 7){
			//$date = strtotime($date . "-01");
			$date = $date . "-01";
		}else{
			$date = null;
		}
		
		//取得出来ない時は現在(=今月)を指定する
		//if(!$date)$date = time();
		if(!$date)$date = Carbon::now('Asia/Tokyo')->format("Y-m-d");
		//フォームを表示
		$calendar = new CalendarFormView($date);

		return view('calendar/extra_holiday_setting_form', [
			"calendar" => $calendar
		]);
	}
	// public function update(Request $request){

	// 	$input = $request->get("extra_holiday");

	// 	ExtraHoliday::updateExtraHolidayWithMonth(date("Ym"), $input);
		
	// 	return redirect()
	// 		->action("\App\Http\Controllers\Calendar\ExtraHolidaySettingController@form")
	// 		->withStatus("保存しました");
	// }
	public function update(Request $request){
		$input = $request->get("extra_holiday");
		$ym = $request->input("ym");
		$date = $request->input("date");
		
		ExtraHoliday::updateExtraHolidayWithMonth($ym, $input);
		return redirect()
			->action("\App\Http\Controllers\Calendar\ExtraHolidaySettingController@form", ["date" => $date])
			->withStatus("保存しました");
	}
}