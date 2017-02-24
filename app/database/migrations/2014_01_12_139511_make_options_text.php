<?php

use Illuminate\Database\Migrations\Migration;

class MakeOptionsText extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE '.getenv('DB_PREFIX').'options MODIFY COLUMN value TEXT');		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement('ALTER TABLE '.getenv('DB_PREFIX').'options MODIFY COLUMN value VARCHAR(255)');
	}

}