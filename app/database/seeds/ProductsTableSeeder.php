<?php

class ProductsTableSeeder extends Seeder {
	public function run() {
		$faker = Faker\Factory::create();

		//Products::truncate();

		$suppliers  = Suppliers::all()->lists('id');
		$categories = Categories::all()->lists('id');

		for ($i = 0; $i < 20; $i++) {
			$products = Products::create(array(
					'name'              => $faker->word,
					'quantity'          => $faker->numberBetween(1, 900),
					'unitPrice'         => $faker->randomFloat(5, 1, 5000),
					'details'           => $faker->text,
					'color'             => $faker->colorName,
					'supplierProductId' => $faker->randomNumber,
					'supplierId'        => $faker->randomElement($suppliers),
					'categoryId'        => $faker->randomElement($categories),
				));
		}
	}
}