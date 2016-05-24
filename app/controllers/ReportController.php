<?php

class ReportController extends Controller {

	public $startDate;
	public $endDate;

	public function index() {

		return View::make('reports.index');

	}

	public function create() {
		//return View::make('reports');
	}

	/**
	 * Store a newly created category in database.
	 *
	 * @return Response
	 */
	public function store() {

		return Redirect::to('reports/1/details');

	}

	public function show($id) {
		return Redirect::to('reports/1/details');
	}

	public function details($id) {

		$invoices       = Invoices::all();
		$purchaseOrders = PurchaseOrder::all();

		//$startDate = '2014-03-01';
		//new DateTime();
		//$endDate = '2016-03-31';
		//new DateTime();

		$startDate = Input::get('startDate');
		$endDate   = Input::get('endDate');

		$query = DB::table('invoices');
		$query->join('invoicesProductLine', 'invoices.id', '=', 'invoicesProductLine.invoiceId')
			  ->where('invoices.date', '>=', $startDate)
			  ->where('invoices.date', '<=', $endDate)
			  ->groupBy('invoices.id')
			  ->select(DB::raw('invoices.id, invoices.name, invoices.date, sum(invoicesProductLine.unitPrice*invoicesProductLine.quantity) as subtotal'));

		/*
		SELECT invoices.id, invoices.name, products.id, products.name, SUM(products.unitPrice*invoicesProductLine.quantity) AS subtotal FROM invoices INNER JOIN invoicesProductLine ON invoices.id = invoicesProductLine.invoiceId INNER JOIN products ON products.id = invoicesProductLine.productId WHERE invoices.date BETWEEN 2014-03-01 AND 2016-03-30 GROUP BY invoices.id

		$query->join('invoicesProductLine', 'invoices.id', '=', 'invoicesProductLine.invoiceId')
		->join('products', 'products.id', '=', 'invoicesProductLine.productId')
		//->join('additionalServices', 'invoices.id', '=', 'additionalServices.invoiceId')
		->where('invoices.date', '>=', $startDate)
		->where('invoices.date', '<=', $endDate)
		->select('invoice.id', 'invoice.name', 'products.id', 'products.name', 'products.unitPrice', 'products.details', 'invoicesProductLine.quantity');*/

		$products = $query->get();

		$query2 = DB::table('invoices');
		$query2->join('additionalServices', 'invoices.id', '=', 'additionalServices.invoiceId')
		       ->where('invoices.date', '>=', $startDate)
		       ->where('invoices.date', '<=', $endDate)
		       ->select(DB::raw('invoices.id, invoices.name, sum(additionalServices.cost) as subtotal'))
		       ->groupBy('invoices.id');

		$services = $query2->get();

		/*$query3 = DB::table('purchaseOrders');
		$query3->join('purchaseOrdersProductLine', 'purchaseOrders.id', '=', 'purchaseOrdersProductLine.purchaseOrderId')
		->join('products', 'products.id', '=', 'purchaseOrdersProductLine.productId')
		//->join('additionalServices', 'invoices.id', '=', 'additionalServices.invoiceId')
		->where('purchaseOrders.date', '>=', $startDate)
		->where('purchaseOrders.date', '<=', $endDate)
		->select('products.id', 'products.name', 'products.unitPrice', 'products.details', 'purchaseOrdersProductLine.quantity');

		$purProducts = $query3->get();*/

		return View::make('reports.details', array('products' => $products, 'services' => $services))->with('startDate', $startDate)->with('endDate', $endDate);
	}

}