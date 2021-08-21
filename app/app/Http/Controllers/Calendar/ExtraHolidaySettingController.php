<?php
namespace App\Http\Controllers\Calendar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendar\Form\CalendarFormView;
use App\Calendar\ExtraHoliday;
class ExtraHolidaySettingController extends Controller
{
	public function form(){
		
		$calendar = new CalendarFormView(time());
		return view('calendar/extra_holiday_setting_form', [
			"calendar" => $calendar
		]);
	}
	public function update(Request $request){
		return redirect()
			->action("Calendar\ExtraHolidaySettingController@form")
			->withStatus("保存しました");
	}
}