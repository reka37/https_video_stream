<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeoUrlCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('categories', function (Blueprint $table) {
			$table->string('seo_url',200)->after('isVisiable')->nullable;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('categories', function (Blueprint $table) {
             $table->dropColumn('seo_url');
        });
    }
}
