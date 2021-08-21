<?php
namespace App\Http\Controllers\Calendar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendar\HolidaySetting;
//use App\Calendar\HolidaySetting;//HolidaySettingクラスを使うための設定
class HolidaySettingController extends Controller
{

	function form(){

		//取得
		$setting =  HolidaySetting::firstOrNew();//Modelの機能で1件目を取得し、なかったら新規に作成
		//$setting->save(); // 追記
        //$setting = HolidaySetting::first();
        //if(!$setting)$setting = new HolidaySetting();
		return view("calendar/holiday_setting_form", [
			"setting" => $setting,
			"FLAG_OPEN" => HolidaySetting::OPEN,
			"FLAG_CLOSE" => HolidaySetting::CLOSE
		]);
	}
	function update(Request $request){
		//取得
		$form = $request->all();
		$holidaySetting = new HolidaySetting;
		$holidaySetting =  $holidaySetting->find(1);
		
		if(isset($holidaySetting)) {
			$holidaySetting->fill($request->all())->save();
		}else {
			$setting = HolidaySetting::firstOrNew(
				[
				"flag_mon" => $request->flag_mon,
				"flag_tue" => $request->flag_tue,
				"flag_wed" => $request->flag_wed,
				"flag_thu" => $request->flag_thu,
				"flag_fri" => $request->flag_fri,
				"flag_sat" => $request->flag_sat,
				"flag_sun" => $request->flag_sun,
				"flag_holiday" => $request->flag_holiday,
				]
			);
			$setting->save();
		}
		//$setting->save();
		//dd($request->flag_mon);
		//$setting->save(); // 追記
		//更新
		//$setting->update($request->all());
		//$setting->fill($request->all())->save();
		return redirect()
			->action("\App\Http\Controllers\Calendar\HolidaySettingController@form")
			->withStatus("保存しました");
	}
}
