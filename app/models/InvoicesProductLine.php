<?php

Class InvoicesProductLine extends Eloquent {

	protected $fillable = array('invoiceId', 'quantity', 'productName', 'unitPrice', 'details', 'color', 'categoryName', 'supplierName');
	public $table       = "InvoicesProductLine";


	public function InvoicesLineInvoices() {
		return $this->hasOne('Invoices');
	}

}