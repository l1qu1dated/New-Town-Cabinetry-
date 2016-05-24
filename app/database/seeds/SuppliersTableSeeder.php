<?php

class SuppliersTableSeeder extends Seeder {
	public function run() {
		$faker = Faker\Factory::create();

		//Suppliers::truncate();

		for ($i = 0; $i < 20; $i++) {
			$suppliers = Suppliers::create(array(
					'name'       => $faker->company,
					'phone'      => $faker->phoneNumber,
					'email'      => $faker->email,
					'address'    => $faker->address,
					'city'       => $faker->city,
					'province'   => $faker->state,
					'postalCode' => $faker->postcode,
					'country'    => $faker->country,
				));
		}
	}
}