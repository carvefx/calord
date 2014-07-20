<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
    Schema::create('events', function($table)
      {
        $table->increments('id')->unsigned();
        $table->dateTime('date');
        $table->integer('event_type_id')->unsigned()->nullable();
        $table->string('title');
        $table->text('description')->nullable();
        $table->timestamps();

        $table->foreign('event_type_id')->references('id')->on('event_types')->onDelete('cascade');
      });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('events');
	}

}
