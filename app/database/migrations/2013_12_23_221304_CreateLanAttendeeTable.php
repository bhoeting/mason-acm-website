<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanAttendeeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('lan_attendees'))
		{
			Schema::create('lan_attendees', function($table)
			{
				$table->increments('id');
				$table->unsignedInteger('lanparty_id');
				$table->unsignedInteger('user_id')->nullable();
				$table->string('firstname', 50)->nullable();
				$table->string('lastname', 50)->nullable();
				$table->unsignedInteger('year')->nullable();
				$table->boolean('has_attended')->default(false);
				$table->timestamps();
			});
		}
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('lan_attendees');
	}
}
