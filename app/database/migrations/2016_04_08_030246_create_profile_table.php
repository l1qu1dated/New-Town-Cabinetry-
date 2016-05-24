<?php

use Illuminate\Database\Migrations\Migration;

class CreateProfileTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('users', function ($user) {
				$user->increments('id');
				$user->string('username', 100)->unique();
				$user->string('password', 100);
				$user->date('lastLogin')->nullable();
				$user->string('firstName');
				$user->string('lastName');
				$user->string('phone');
				$user->string('email')->unique();
				$user->rememberToken();
				$user->timestamps();
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('users');
	}

}
