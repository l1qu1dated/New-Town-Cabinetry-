<?php

class SupplierController extends Controller {

	protected $layout = 'layouts.master';

	public function showProfile() {
		$this->layout->content = View::make('suppliers.profile');
	}

	public function index() {

		if (Input::get('search') != null) {
			$sup = new Suppliers;

			return $this->search(Input::get('search'));
		} else {

			$suppliers = Suppliers::all();
			return View::make('suppliers.index')
				->with('suppliers', $suppliers);
		}

	}

	public function search($id) {
		$supplier = $id;

		$terms = explode(' ', $supplier);

		$query = DB::table('suppliers');

		//For now just search everything.

		foreach ($terms as $term) {
			$query->where('name', 'LIKE', '%'.$term.'%')
			      ->orwhere('phone', 'LIKE', '%'.$term.'%')
			      ->orwhere('email', 'LIKE', '%'.$term.'%')
			      ->orwhere('city', 'LIKE', '%'.$term.'%')
			      ->orwhere('address', 'LIKE', '%'.$term.'%')
			      ->orwhere('postalCode', 'LIKE', '%'.$term.'%')
			      ->orwhere('province', 'LIKE', '%'.$term.'%')
			      ->orwhere('country', 'LIKE', '%'.$term.'%');
		}
		$results = $query->get();

		return View::make('suppliers.index')->with('suppliers', $results);
	}

	/**
	 * Show the form for creating a new supplier.
	 *
	 * @return Response
	 */
	public function create() {
		return View::make('suppliers.create');
	}

	/**
	 * Store a newly created supplier in database.
	 *
	 * @return Response
	 */
	public function store() {
		$rules = array(
			'name' => 'required',
			'phone'   => 'required',
			'email' => 'required',
			'city'  => 'required',
			'address' => 'required',
			'postalCode' => 'required',
			'province'   => 'required',
			'country'   => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			$messages = $validator->messages();

			return Redirect::to('suppliers/create')
				->withErrors($validator)
				->withInput(Input::all());
		} else {
			$supplier              = new Suppliers;
			$supplier->name        = Input::get('name');
			$supplier->phone       = Input::get('phone');
			$supplier->email       = Input::get('email');
			$supplier->address     = Input::get('address');
			$supplier->city        = Input::get('city');
			$supplier->province    = Input::get('province');
			$supplier->postalCode  = Input::get('postalCode');
			$supplier->country     = Input::get('country');
			$supplier->save();
			return Redirect::to('suppliers');
		}
	}

	/**
	 * Show the form for editing the specified supplier.
	 *
	 * @return Response
	 */
	public function edit($id) {
		$supplier = Suppliers::find($id);

		return View::make('suppliers.edit')->with('supplier', $supplier);
	}

	/**
	 * Update the specified supplier in database.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) {
		$rules = array(
			'name' => 'required',
			'phone'   => 'required',
			'email' => 'required',
			'city'  => 'required',
			'address' => 'required',
			'postalCode' => 'required',
			'province'   => 'required',
			'country'   => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			$messages = $validator->messages();

			return Redirect::to('suppliers/'.$id.'/edit')
				->withErrors($validator)
				->withInput(Input::all());
		} else {
			$supplier              = Suppliers::find($id);
			$supplier->name        = Input::get('name');
			$supplier->phone       = Input::get('phone');
			$supplier->email       = Input::get('email');
			$supplier->address     = Input::get('address');
			$supplier->city        = Input::get('city');
			$supplier->postalCode  = Input::get('postalCode');
			$supplier->province    = Input::get('province');
			$supplier->country     = Input::get('country');
			$supplier->save();
			return Redirect::to('suppliers');
		}
	}

	/**
	 * Remove the specified categroy from database.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {

		$supplier = Suppliers::find($id);
		$check    = new Suppliers;
		$error    = "You can not delete this supplier because some products depend on it";
		if ($check->exists($id) == true) {

			return Redirect::to('suppliers')->with('error', $error);
		} else {
			$supplier->delete();
		}
		// redirect
		return Redirect::to('suppliers');
	}

	public function show($id) {
		$rules = array(
			'name' => 'required',
			'phone'   => 'required',
			'email' => 'required',
			'city'  => 'required',
			'address' => 'required',
			'postalCode' => 'required',
			'province'   => 'required',
			'country'   => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			$messages = $validator->messages();

			return Redirect::to('suppliers/'.$id.'/details')
				->withErrors($validator)
				->withInput(Input::all());
		} else {
			$supplier              = Suppliers::find($id);
			$supplier->name        = Input::get('name');
			$supplier->phone       = Input::get('phone');
			$supplier->email       = Input::get('email');
			$supplier->address     = Input::get('address');
			$supplier->city        = Input::get('city');
			$supplier->postalCode  = Input::get('postalCode');
			$supplier->province    = Input::get('province');
			$supplier->country     = Input::get('country');
			$supplier->save();
			return Redirect::to('suppliers');
		}
	}

	public function details($id) {
		$supplier = Suppliers::find($id);

		return View::make('suppliers.details')->with('supplier', $supplier);
	}
}