<?php

use Illuminate\Database\Migrations\Migration;

class CreateAdditionalServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('additionalServices', function ($newServices) {
				$newServices->increments('id');
				$newServices->string('description')->nullable();
				$newServices->integer('cost');

				$newServices->integer('invoiceId')->unsigned()->onDelete('cascade');
				$newServices->foreign('invoiceId')->references('id')->on('invoices');
				$newServices->timestamps();
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('additionalServices');
	}

}
