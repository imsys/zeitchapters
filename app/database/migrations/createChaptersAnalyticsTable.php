<?php

use Illuminate\Database\Migrations\Migration;

class CreateChaptersAnalyticsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('chapters_analytics', function($table)
      {
        $table->increments('id');
		$table->integer('chapter_id'); //chapter 0 - total members
		$table->smallInteger('type_id'); //1 total members // 2 todays new membes //3 total subscribers // 4 todays new subscribers
		$table->date('date');
		$table->integer('value');

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
      Schema::drop('chapters_analytics');
    }

}