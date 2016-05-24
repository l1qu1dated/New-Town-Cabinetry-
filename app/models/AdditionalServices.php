<?php

class AdditionalServices extends Eloquent {
	public $table = "AdditionalServices";

	public function AdditionalServices() {
		return $this->hasOne('Invoices');
	}
}