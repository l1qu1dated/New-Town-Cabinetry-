<?php

class ProductController extends Controller {

	public function index() {

		if (Input::get('search') != null) {
			$sup = new Products;

			return $this->search(Input::get('search'));
		} else {

			$products   = Products::all();
			$categories = Categories::lists('name', 'id');
			$suppliers  = Suppliers::lists('name', 'id');

			return View::make('products.index', array('categories' => $categories, 'suppliers' => $suppliers))
				->with('products', $products);
		}

	}

	public function search($id) {
		$product = $id;

		//$terms = explode(' ', $product);
		$term  = $product;
		$query = DB::table('products');

		//SEARCH ONLY WORKS WITH CATEGORY/SUPPLIER ID
		//MUST SOMEHOW EXTRACT supplierId/categoryId THAT THE TERM
		//IS BEING COMPARED TO, CHECK WHAT ITS NAME IS AND SEE WHETHER
		//IT IS THE SAME AS THE TERM.

		//something like this:
		// ->orwhere('SELECT name FROM Suppliers WHERE id = supplierId', 'LIKE', '%' .$term. '%')
		//which obviously does not work since syntax is wrong

		//foreach ($terms as $term) {

		$query
			->join('categories', 'products.categoryId', '=', 'categories.id')
			->join('suppliers', 'products.supplierId', '=', 'suppliers.id')
			->where('products.name', 'LIKE', "%{$term}%")
			->orwhere('suppliers.name', 'LIKE', "%{$term}%")
			->orwhere('categories.name', 'LIKE', "%{$term}%")
			->orwhere('products.color', 'LIKE', "%{$term}%")
			->select('products.id', 'products.name', 'products.unitPrice', 'products.quantity', 'products.color',
			'products.supplierId', 'products.categoryId');
		//}
		$results = $query->get();

		return View::make('products.index')->with('products', $results);
	}

	public function create() {

		$categories = Categories::lists('name', 'id');
		$suppliers  = Suppliers::lists('name', 'id');

		return View::make('products.create', array('categories' => $categories, 'suppliers' => $suppliers));
	}

	public function store() {
		$rules = array(
			'name'              => 'required',
			'quantity'          => 'required|integer',
			'unitPrice'         => 'required|numeric',
			'color'             => 'required|alpha',
			'supplierProductId' => 'required|unique:products',
			'suppliers_id'      => 'required',
			'categories_id'     => 'required',

		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			$messages = $validator->messages();

			return Redirect::to('products/create')
				->withErrors($validator)
				->withInput(Input::all());
		} else {
			$product                    = new Products;
			$product->name              = Input::get('name');
			$product->quantity          = Input::get('quantity');
			$product->unitPrice         = Input::get('unitPrice');
			$product->details           = Input::get('description');
			$product->color             = Input::get('color');
			$product->supplierProductId = Input::get('supplierProductId');
			$product->supplierId        = Input::get('suppliers_id');
			$product->categoryId        = Input::get('categories_id');
			$product->save();
			//return View::make('show_product')->with('supplier', $supplier);
			//->with('category', $product);
			//return View::make('view_product_details')->with('product', $product);
			return Redirect::to('products');
		}
	}

	public function edit($id) {
		$product    = Products::find($id);
		$categories = Categories::lists('name', 'id');
		$suppliers  = Suppliers::lists('name', 'id');

		return View::make('products.edit', array('product' => $product, 'categories' => $categories, 'suppliers' => $suppliers));
	}

	public function update($id) {
		$rules = array(
			'name'          => 'required',
			'quantity'      => 'required|integer',
			'unitPrice'     => 'required|numeric',
			'color'         => 'required|alpha',
			'suppliers_id'  => 'required',
			'categories_id' => 'required',

		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			$messages = $validator->messages();

			return Redirect::to('products/'.$id.'/edit')
				->withErrors($validator)
				->withInput(Input::all());
		} else {
			$product             = Products::find($id);
			$product->name       = Input::get('name');
			$product->quantity   = Input::get('quantity');
			$product->unitPrice  = Input::get('unitPrice');
			$product->details    = Input::get('description');
			$product->color      = Input::get('color');
			$product->supplierId = Input::get('suppliers_id');
			$product->categoryId = Input::get('categories_id');
			$product->save();
			//return View::make('show_product')->with('supplier', $supplier);
			//->with('category', $product);
			//return View::make('view_product_details')->with('product', $product);
			return Redirect::to('products');
		}
	}

	public function destroy($id) {

		$product = Products::find($id);

		$product->delete();

		// redirect
		return Redirect::to('products');
	}

	public function show($id) {
		$rules = array(
			'name'              => 'required',
			'quantity'          => 'required|integer',
			'unitPrice'         => 'required|numeric',
			'color'             => 'required|alpha',
			'supplierProductId' => 'required|unique:products',
			'suppliers_id'      => 'required',
			'categories_id'     => 'required',

		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			$messages = $validator->messages();

			return Redirect::to('products/'.$id.'/details')
				->withErrors($validator)
				->withInput(Input::all());
		} else {
			$product                    = Products::find($id);
			$product->name              = Input::get('name');
			$product->quantity          = Input::get('quantity');
			$product->unitPrice         = Input::get('unitPrice');
			$product->details           = Input::get('description');
			$product->color             = Input::get('color');
			$product->supplierProductId = Input::get('supplierProductId');
			$product->supplierId        = Input::get('suppliers_id');
			$product->categoryId        = Input::get('categories_id');
			$product->save();
			//return View::make('show_product')->with('supplier', $supplier);
			//->with('category', $product);
			//return View::make('view_product_details')->with('product', $product);
			return Redirect::to('products');
		}
	}

	public function details($id) {
		$product = Products::find($id);

		return View::make('products.details')->with('product', $product);
	}

}