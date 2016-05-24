<?php

use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('products', function ($newProduct) {
				$newProduct->increments('id');
				$newProduct->string('name');
				$newProduct->integer('quantity');
				$newProduct->float('unitPrice');
				$newProduct->text('details')->nullable();
				$newProduct->string('color');
				$newProduct->string('supplierProductId');

				$newProduct->integer('supplierId')->unsigned()->onDelete('cascade');
				$newProduct->foreign('supplierId')->references('id')->on('suppliers');

				$newProduct->integer('categoryId')->unsigned()->onDelete('cascade');
				$newProduct->foreign('categoryId')->references('id')->on('categories');

				$newProduct->timestamps();
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('products');
	}

}
