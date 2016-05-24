<?php

use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderProductLineTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('purchaseOrderLine', function ($newPurchase) {
				$newPurchase->increments('id');
				$newPurchase->integer('quantity');

				$newPurchase->integer('purchaseOrderId')->unsigned()->onDelete('cascade');
				$newPurchase->foreign('purchaseOrderId')->references('id')->on('purchaseOrder');

				$newPurchase->string('productName');
				$newPurchase->float('unitPrice');
				$newPurchase->text('details')->nullable();
				$newPurchase->string('color');
				$newPurchase->string('categoryName');

				$newPurchase->timestamps();
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('purchaseOrderLine');
	}

}
