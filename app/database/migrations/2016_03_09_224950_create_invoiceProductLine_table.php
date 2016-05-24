<?php

use Illuminate\Database\Migrations\Migration;

class CreateInvoiceProductLineTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		//
		Schema::create('invoicesProductLine', function ($newInvoiceLine) {

				$newInvoiceLine->increments('id');

				$newInvoiceLine->integer('invoiceId')->unsigned()->onDelete('cascade');
				$newInvoiceLine->foreign('invoiceId')->references('id')->on('invoices');

				$newInvoiceLine->integer('quantity');

				$newInvoiceLine->string('productName');
				$newInvoiceLine->float('unitPrice');
				$newInvoiceLine->text('details')->nullable();
				$newInvoiceLine->string('color');
				$newInvoiceLine->string('categoryName');
				$newInvoiceLine->string('supplierName');

				$newInvoiceLine->timestamps();

			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		//
		Schema::drop('invoicesProductLine');
	}

}
