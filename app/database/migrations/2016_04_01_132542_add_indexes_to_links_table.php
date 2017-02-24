<?php

use Illuminate\Database\Migrations\Migration;

class AddIndexesToLinksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('links', function($table)
		{
    		$table->index('approved');
    		$table->index('title_id');
    		$table->index('season');
    		$table->index('episode');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}