<?php

Class PurchaseOrderLine extends Eloquent {

	protected $fillable = array('purchaseOrderId', 'quantity', 'productName', 'unitPrice', 'details', 'color', 'categoryName');
	public $table = "PurchaseOrderLine";


	public function PurchaseLineOrder() {
		return $this->hasOne('PurchaseOrder');
	}

}