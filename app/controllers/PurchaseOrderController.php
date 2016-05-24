<?php

class PurchaseOrderController extends Controller {

	public function index() {

		if (Input::get('search') != null) {
			$purchase = new PurchaseOrder;

			return $this->search(Input::get('search'));
		} else {

			$purchaseOrder = PurchaseOrder::all();
			return View::make('purchaseOrder.index')
				->with('purchaseOrder', $purchaseOrder);
		}
	}

	public function search($id) {
		$purchaseOrder = $id;

		$terms = explode(' ', $purchaseOrder);

		$query = DB::table('purchaseOrder');

		//For now just search everything.

		foreach ($terms as $term) {
			$query->where('supplierName', 'LIKE', '%'.$term.'%')
			      ->orwhere('details', 'LIKE', '%'.$term.'%')
			      ->orwhere('date', '=', $term);
		}
		$results = $query->get();

		return View::make('purchaseOrder.index')->with('purchaseOrder', $results);
	}

	public function loadCategoriesPO() {
		$id = Input::get('selectedSupplier');

		$query = DB::table('categories');

		$query->join('products', 'categories.id', '=', 'products.categoryId')
		      ->join('suppliers', 'products.supplierId', '=', 'suppliers.id')
		      ->where('suppliers.id', $id)
		      ->select('categories.id', 'categories.name');

		$result = $query->get();

		if ($result) {
			$categories = [];
			foreach ($result as $category):
			$categories[$category->id] = $category->name;
			endforeach;

			return $categories;
		}

		return null;
	}

	public function loadProductsPO() {
		$categoryId = Input::get('selectedCategory');
		$supplierId = Input::get('selectedSupplier');

		$query = DB::table('products');

		$query->where('categoryId', '=', $categoryId)
		      ->where('supplierId', '=', $supplierId)
		      ->select('products.id', 'products.name');

		$result = $query->get();

		if ($result) {
			$products = [];
			foreach ($result as $product):
			$products[$product->id] = $product->name;
			endforeach;

			return $products;
		}

		return null;

	}

	/**
	 * Show the form for creating a new category.
	 *
	 * @return Response
	 */
	public function create() {
		$products   = Products::lists('name', 'id');
		$suppliers  = Suppliers::lists('name', 'id');
		$categories = Categories::lists('name', 'id');

		return View::make('purchaseOrder.create', ['suppliers' => $suppliers]);
	}

	/**
	 * Store a newly created category in database.
	 *
	 * @return Response
	 */
	public function store() {

		$rules = array(
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			$messages = $validator->messages();

			return Redirect::to('purchaseOrder/create')
				->withErrors($validator)
				->withInput(Input::all());
		} else {

			$purchase = new PurchaseOrder;
			$purchase->date     = Input::get('date');
			$purchase->details = Input::get('details');

			$supplier = Suppliers::find(Input::get('supplier'));
			$purchase->supplierName = $supplier->name;
			$purchase->phone = $supplier->phone;
			$purchase->email = $supplier->email;
			$purchase->address = $supplier->address;
			$purchase->city = $supplier->city;
			$purchase->province = $supplier->province;
			$purchase->postalCode = $supplier->postalCode;
			$purchase->country = $supplier->country;	

			$purchase->save();

			$products   = Input::get('products');
			$quantities = Input::get('quantities');

			for ($i = 0; $i < count($products); $i++) {
				$line                  = new PurchaseOrderLine;
				$line->purchaseOrderId = $purchase->id;
				//$line->productId       = $products[$i];
				$line->quantity        = $quantities[$i];

				$product = Products::find($products[$i]);
				$line->productName = $product->name;
				$line->unitPrice = $product->unitPrice;
				$line->details = $product->details;
				$line->color = $product->color;

				$category = Categories::find($product->categoryId);
				$line->categoryName = $category->name;

				$line->save();
			}

			return Redirect::to('purchaseOrder');

		}
	}

	/**
	 * Show the form for editing the specified category.
	 *
	 * @return Response
	 */
	public function edit($id) {
		$purchaseOrder = PurchaseOrder::find($id);
		$products   = Products::lists('name', 'id');
		$suppliers  = Suppliers::lists('name', 'id');
		$categories = Categories::lists('name', 'id');

		$purchaseOrderProducts = DB::table('purchaseOrderLine')->where('purchaseOrderLine.purchaseOrderId', $id)->get();


		return View::make('purchaseOrder.edit', ['purchaseOrder' => $purchaseOrder, 'purchaseOrderProducts' => $purchaseOrderProducts, 'products' => $products, 'suppliers' => $suppliers, 'categories' => $categories]);
	}

	/**
	 * Update the specified category in database.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) {
		$rules = array(
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			$messages = $validator->messages();

			return Redirect::to('purchaseOrder/'.$id.'/edit')
				->withErrors($validator)
				->withInput(Input::all());
		} else {

			$purchase = PurchaseOrder::find($id);
			$purchase->date     = Input::get('date');
			$purchase->details = Input::get('details');	

			$purchase->save();


			$purchaseOrderLineIds = Input::get('purchaseOrderLineIds');
			$purchaseOrderProducts = DB::table('purchaseOrderLine')->where('purchaseOrderLine.purchaseOrderId', $id)->get();
			for ($i = 0; $i < count($purchaseOrderProducts); $i++) {
				if(!in_array($purchaseOrderProducts[$i]->id, $purchaseOrderLineIds)) {
					PurchaseOrderLine::find($purchaseOrderProducts[$i]->id)->delete();
				}
			}

			return Redirect::to('purchaseOrder');

		}
	}

	/**
	 * Remove the specified category from database.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {

		$purchaseOrders = PurchaseOrder::find($id);
		DB::table('PurchaseOrderLine')->where('purchaseOrderId', '=', $id)->delete();

		$purchaseOrders->delete();

		// redirect
		return Redirect::to('purchaseOrder');
	}

	public function show($id) {
		$purchase = PurchaseOrder::find($id);

		$query = DB::table('purchaseOrderLine');
		$query->where('purchaseOrderLine.purchaseOrderId', $id);

		$products = $query->get();

		return View::make('purchaseOrder.details', array('purchaseOrder' => $purchase, 'products' => $products));
	}
}