<?php

class PurchaseOrder extends Eloquent {

		protected $fillable = array('date', 'details', 'supplierName', 'phone', 'email', 'address', 'city', 'province', 'postalCode', 'country', );

	public $table = "PurchaseOrder";

	public function PurchaseOrderLine() {
		return $this->hasMany('PurchaseOrderLine');
	}
}