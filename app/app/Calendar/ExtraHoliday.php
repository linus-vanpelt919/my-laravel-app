<?php
namespace App\Calendar;
use Illuminate\Database\Eloquent\Model;
class ExtraHoliday extends Model
{
	const OPEN = 1;
	const CLOSE = 2;
	protected $table = "extra_holiday";
	
	protected $fillable = [
		"date_flag",
		"comment"
	];
	function isClose(){
		return $this->date_flag == ExtraHoliday::CLOSE;
	}
	function isOpen(){
		return $this->date_flag == ExtraHoliday::OPEN;
	}
}