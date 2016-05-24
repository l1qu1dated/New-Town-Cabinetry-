<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		//$this->call('AddressesTableSeeder');
		$this->call('SuppliersTableSeeder');
		$this->call('CategoriesTableSeeder');
		$this->call('ProductsTableSeeder');
	}

}
