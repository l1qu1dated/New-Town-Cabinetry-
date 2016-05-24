<?php

class Categories extends Eloquent {

	public function categoryProducts() {
		return $this->hasMany('Products');
	}

	public function exists($id) {
		$exists = Products::where('categoryId', $id)->first();

		if ($exists == null) {
			return false;
		} else {
			return true;
		}
	}
}