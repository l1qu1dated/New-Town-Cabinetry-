<?php

class InvoiceController extends Controller {

	public function index() {

		/*if (Input::get('search') != null) {
		$cat = new Categories;

		return $this->search(Input::get('search'));
		} else {

		$categories = Categories::all();
		return View::make('categories.index')
		->with('categories', $categories);
		}*/
		if (Input::get('search') != null) {
			$inv = new Invoices;

			return $this->search(Input::get('search'));
		} else {

			$invoices = Invoices::all();

			return View::make('invoices.index')->with('invoices', $invoices);
		}

	}

	public function edit($id) {

		$invoice    = Invoices::find($id);
		$products   = Products::lists('name', 'id');
		$suppliers  = Suppliers::lists('name', 'id');
		$categories = Categories::lists('name', 'id');

		$services        = DB::table('additionalServices')->where('additionalServices.invoiceId', $id)->get();
		$invoiceProducts = DB::table('invoicesProductLine')->where('invoicesProductLine.invoiceId', $id)->get();

		return View::make('invoices.edit', ['invoice' => $invoice, 'categories' => $categories, 'suppliers' => $suppliers, 'products' => $products, 'invoiceProducts' => $invoiceProducts, 'services' => $services]);
	}

	public function loadSuppliers() {
		$id = Input::get('selectedCategory');

		$query = DB::table('suppliers');

		$query->join('products', 'suppliers.id', '=', 'products.supplierId')
		      ->join('categories', 'categories.id', '=', 'products.categoryId')
		      ->where('products.categoryId', $id)
		      ->select('suppliers.id', 'suppliers.name');

		$result = $query->get();

		if ($result) {
			$suppliers = [];
			foreach ($result as $supplier):
			$suppliers[$supplier->id] = $supplier->name;
			endforeach;

			return $suppliers;
		}

		return null;
	}

	public function loadProducts() {
		$id = Input::get('selectedSupplier');

		$result = DB::table('products')->where('supplierId', $id)->get();

		if ($result) {
			$products = [];
			foreach ($result as $product):
			$products[$product->id] = $product->name;
			endforeach;

			return $products;
		}

		return null;
	}

	/*
	public function getProducts($id) {
	$products = DB::table('products')->where('categoryId', $id)->get();
	return View::make('invoices.create', ['products' => $products]);
	}
	 */

	/**
	 * Show the form for creating a new invoice.
	 *
	 * @return Response
	 */
	public function create() {
		$products  = Products::lists('name', 'id');
		$suppliers = Suppliers::lists('name', 'id');

		/*
		$categories = DB::table('categories')->get();
		$products  = DB::table('products')->get();
		 */

		$categories = Categories::lists('name', 'id');

		/*
		$categories = [];
		foreach (Categories::all() as $category):
		$categories[$category->id] = $category->name;
		endforeach;
		 */

		/*

		$categories = DB::table('categories')->get();
		$categories_pack = [];
		foreach($categories as $category):
		$category_products = DB::table('products')->where('categoryId', $category->id)->lists('products');
		$categories_pack[$category->name] = $category_products;
		endforeach
		$jsonified = json_encode($categories_pack);
		$data = ['categories' => $jsonified];


		return View:make('invoices.create', $data);
		 */

		return View::make('invoices.create', ['categories' => $categories, 'suppliers' => $suppliers, 'products' => $products]);
	}

	public function search($id) {
		$invoice = $id;

		$terms = explode(' ', $invoice);

		$query = DB::table('invoices');

		//For now just search everything.

		foreach ($terms as $term) {
			$query->where('name', 'LIKE', '%'.$term.'%')
			      ->orwhere('phone', 'LIKE', '%'.$term.'%')
			      ->orwhere('email', 'LIKE', '%'.$term.'%')
			      ->orwhere('address', 'LIKE', '%'.$term.'%')
			      ->orwhere('province', 'LIKE', '%'.$term.'%')
			      ->orwhere('country', 'LIKE', '%'.$term.'%')
			      ->orwhere('date', 'LIKE', '%'.$term.'%');
		}
		$results = $query->get();

		return View::make('invoices.index')->with('invoices', $results);
	}

	/**
	 * Store a newly created category in database.
	 *
	 * @return Response
	 */
	public function store() {

		$rules = array(
			'name'     => 'required',
			'phone'    => 'required',
			'email'    => 'required|email|unique:users',
			'address'  => 'required',
			'country'  => 'required',
			'province' => 'required',
			'date'     => 'required',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			$messages = $validator->messages();

			return Redirect::to('invoices/create')
				->withErrors($validator)
				->withInput(Input::all());
		} else {

			$invoice = new Invoices;

			$invoice->name     = Input::get('name');
			$invoice->phone    = Input::get('phone');
			$invoice->email    = Input::get('email');
			$invoice->address  = Input::get('address');
			$invoice->country  = Input::get('country');
			$invoice->province = Input::get('province');
			$invoice->date     = Input::get('date');
			$invoice->save();

			$products   = Input::get('products');
			$quantities = Input::get('quantities');

			for ($i = 0; $i < count($products); $i++) {
				$line            = new InvoicesProductLine;
				$line->invoiceId = $invoice->id;
				//$line->productId = $products[$i];
				$line->quantity = $quantities[$i];

				$product           = Products::find($products[$i]);
				$line->productName = $product->name;
				$line->unitPrice   = $product->unitPrice;
				$line->details     = $product->details;
				$line->color       = $product->color;

				$category           = Categories::find($product->categoryId);
				$line->categoryName = $category->name;

				$supplier           = Suppliers::find($product->supplierId);
				$line->supplierName = $supplier->name;

				$line->save();
			}

			$descriptions = Input::get('descriptions');
			$costs        = Input::get('costs');

			for ($i = 0; $i < count($descriptions); $i++) {
				$service              = new AdditionalServices;
				$service->invoiceId   = $invoice->id;
				$service->description = $descriptions[$i];
				$service->cost        = $costs[$i];
				$service->save();
			}

			return Redirect::to('invoices');
		}
	}

	public function update($id) {
		$rules = array(
			'name' => 'required',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			$messages = $validator->messages();

			return Redirect::to('invoices/'.$id.'/edit')
				->withErrors($validator)
				->withInput(Input::all());
		} else {

			$invoice = Invoices::find($id);

			$invoice->name     = Input::get('name');
			$invoice->phone    = Input::get('phone');
			$invoice->email    = Input::get('email');
			$invoice->address  = Input::get('address');
			$invoice->country  = Input::get('country');
			$invoice->province = Input::get('province');
			$invoice->date     = Input::get('date');
			$invoice->save();

			$invoiceProductLineIds = Input::get('invoiceProductLineIds');
			$invoiceProducts       = DB::table('invoicesProductLine')->where('invoicesProductLine.invoiceId', $id)->get();
			for ($i = 0; $i < count($invoiceProducts); $i++) {
				if (!in_array($invoiceProducts[$i]->id, $invoiceProductLineIds)) {
					InvoicesProductLine::find($invoiceProducts[$i]->id)->delete();
				}
			}

			$products   = Input::get('products');
			$quantities = Input::get('quantities');

			for ($i = 0; $i < count($products); $i++) {
				$line            = new InvoicesProductLine;
				$line->invoiceId = $invoice->id;
				//$line->productId = $products[$i];
				$line->quantity = $quantities[$i];

				$product           = Products::find($products[$i]);
				$line->productName = $product->name;
				$line->unitPrice   = $product->unitPrice;
				$line->details     = $product->details;
				$line->color       = $product->color;

				$category           = Categories::find($product->categoryId);
				$line->categoryName = $category->name;

				$supplier           = Suppliers::find($product->supplierId);
				$line->supplierName = $supplier->name;

				$line->save();
			}

			$additionalServiceIds = Input::get('additionalServiceIds');
			$additionalServices   = DB::table('additionalServices')->where('additionalServices.invoiceId', $id)->get();
			for ($i = 0; $i < count($additionalServices); $i++) {
				if (!in_array($additionalServices[$i]->id, $additionalServiceIds)) {
					AdditionalServices::find($additionalServices[$i]->id)->delete();
				}
			}

			$descriptions = Input::get('descriptions');
			$costs        = Input::get('costs');

			for ($i = 0; $i < count($descriptions); $i++) {
				$service              = new AdditionalServices;
				$service->invoiceId   = $invoice->id;
				$service->description = $descriptions[$i];
				$service->cost        = $costs[$i];
				$service->save();
			}

			return Redirect::to('invoices');
		}

	}

	public function details($id) {

		$invoice = Invoices::find($id);

		$query = DB::table('invoicesProductLine');
		$query->where('invoicesProductLine.invoiceId', $id);

		$products = $query->get();

		$query2 = DB::table('invoices');
		$query2->join('additionalServices', 'invoices.id', '=', 'additionalServices.invoiceId')
		       ->where('invoices.id', $id)
		       ->select('additionalServices.id', 'additionalServices.description', 'additionalServices.cost');

		$services = $query2->get();

		return View::make('invoices.details', array('invoice' => $invoice, 'products' => $products, 'services' => $services));
	}

	public function destroy($id) {

		$invoice = Invoices::find($id);
		DB::table('InvoicesProductLine')->where('invoiceId', '=', $id)->delete();
		DB::table('AdditionalServices')->where('invoiceId', '=', $id)->delete();

		$invoice->delete();

		// redirect
		return Redirect::to('invoices');
	}

}