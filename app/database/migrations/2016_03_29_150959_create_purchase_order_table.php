<?php

use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::create('purchaseOrder', function ($newPurchase) {
				$newPurchase->increments('id');
				$newPurchase->date('date');
				$newPurchase->string('details')->nullable();
				$newPurchase->string('supplierName');
				$newPurchase->string('phone');
				$newPurchase->string('email');
				$newPurchase->string('address');
				$newPurchase->string('city');
				$newPurchase->string('province');
				$newPurchase->string('postalCode');
				$newPurchase->string('country');
				$newPurchase->timestamps();
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {

		Schema::drop('purchaseOrder');
	}

}
