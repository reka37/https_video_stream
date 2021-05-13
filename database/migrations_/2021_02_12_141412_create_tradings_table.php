<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tradings', function (Blueprint $table) {
            $table->increments('id');
			$table->string('ticker');
			$table->string('order_type');
			$table->string('buy_price');
			$table->string('take_profit');
			$table->string('stop_loss');
			$table->string('percent');
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
        Schema::dropIfExists('tradings');
    }
}
