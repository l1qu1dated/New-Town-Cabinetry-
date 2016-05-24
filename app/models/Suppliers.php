<?php

class Suppliers extends Eloquent {
	public function supplierProducts() {
		return $this->hasMany('Products');
	}

	public function exists($id) {
		$exists = Products::where('supplierId', $id)->first();

		if ($exists == null) {
			return false;
		} else {
			return true;
		}
	}
}