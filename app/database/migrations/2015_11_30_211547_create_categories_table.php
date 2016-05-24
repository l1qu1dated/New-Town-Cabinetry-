<?php

use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('categories', function ($newCategory) {
				$newCategory->increments('id');
				$newCategory->string('name');
				$newCategory->text('description')->nullable();
				$newCategory->timestamps();
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('categories');
	}

}
