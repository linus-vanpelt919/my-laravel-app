<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHolidaySettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holiday_setting', function (Blueprint $table) {
            $table->id();
			$table->integer("flag_mon")->default(1);
			$table->integer("flag_tue")->default(1);
			$table->integer("flag_wed")->default(1);
			$table->integer("flag_thu")->default(1);
			$table->integer("flag_fri")->default(1);
			$table->integer("flag_sat")->default(1);
			$table->integer("flag_sun")->default(1);
			$table->integer("flag_holiday")->default(1);
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holiday_setting');
    }
}
