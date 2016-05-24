<?php

class Invoices extends Eloquent {

	public function InvoicesLine() {
		return $this->hasMany('InvoicesProductLine');
	}

	public function InvoicesAdditionalServices() {
		return $this->hasMany('AdditionalServices');
	}
}