<?php

class Products extends Eloquent {

	protected $fillable = array('name', 'quantity', 'unitPrice', 'details', 'color', 'supplierProductId');

	public function productSuppliers() {
		return $this->hasOne('Suppliers');
	}

	public function productCategories() {
		return $this->hasOne('Categories');
	}
}