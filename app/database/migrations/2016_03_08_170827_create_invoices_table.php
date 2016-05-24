<?php

use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('invoices', function ($newInvoices) {
				$newInvoices->increments('id');
				$newInvoices->string('name');
				$newInvoices->string('phone');
				$newInvoices->string('email');
				$newInvoices->string('address');
				$newInvoices->string('country');
				$newInvoices->string('province');
				$newInvoices->date('date');
				$newInvoices->timestamps();
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('invoices');
	}

}
