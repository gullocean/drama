<?php

use Illuminate\Database\Migrations\Migration;

class AddIndexesToTitlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('titles', function($table)
		{
    		$table->index('mc_num_of_votes');
    		$table->index('created_at');
    		$table->index('release_date');
    		$table->index('title');
    		$table->index('mc_user_score');
		});

		DB::statement('ALTER TABLE titles MODIFY COLUMN type enum("movie", "series")');
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