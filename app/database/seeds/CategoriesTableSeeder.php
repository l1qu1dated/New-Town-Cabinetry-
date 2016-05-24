<?php

class CategoriesTableSeeder extends Seeder {
	public function run() {
		$faker = Faker\Factory::create();

		//Categories::truncate();

		for ($i = 0; $i < 10; $i++) {
			$category = Categories::create(array(
					'name'        => $faker->word,
					'description' => $faker->text,
				));
		}
	}
}