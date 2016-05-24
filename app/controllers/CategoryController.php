<?php

class CategoryController extends Controller {

	/*public function showProfile() {
	$this->layout->content = View::make('categories.profile');
	}*/

	public function index() {

		if (Input::get('search') != null) {
			$cat = new Categories;

			return $this->search(Input::get('search'));
		} else {

			$categories = Categories::all();
			return View::make('categories.index')
				->with('categories', $categories);
		}

	}

	public function search($id) {
		$category = $id;

		$terms = explode(' ', $category);

		$query = DB::table('categories');

		foreach ($terms as $term) {
			$query->where('name', 'LIKE', '%'.$term.'%')
			      ->orwhere('description', 'LIKE', '%'.$term.'%');
		}
		$results = $query->get();

		return View::make('categories.index')->with('categories', $results);
	}

	/**
	 * Show the form for creating a new category.
	 *
	 * @return Response
	 */
	public function create() {
		return View::make('categories.create');
	}

	/**
	 * Store a newly created category in database.
	 *
	 * @return Response
	 */
	public function store() {
		$rules = array(
			'name' => 'required',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			$messages = $validator->messages();

			return Redirect::to('categories/create')
				->withErrors($validator)
				->withInput(Input::all());
		} else {
			$category              = new Categories;
			$category->name        = Input::get('name');
			$category->description = Input::get('description');
			$category->save();
			return Redirect::to('categories');
		}
	}

	/**
	 * Show the form for editing the specified category.
	 *
	 * @return Response
	 */
	public function edit($id) {
		$category = Categories::find($id);

		return View::make('categories.edit')->with('category', $category);
	}

	/**
	 * Update the specified category in database.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) {
		$rules = array(
			'name' => 'required',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			$messages = $validator->messages();

			return Redirect::to('categories/'.$id.'/edit')
				->withErrors($validator)
				->withInput(Input::all());
		} else {
			$category              = Categories::find($id);
			$category->name        = Input::get('name');
			$category->description = Input::get('description');
			$category->save();
			return Redirect::to('categories');
		}
	}

	/**
	 * Remove the specified category from database.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {

		$category = Categories::find($id);
		$check    = new Categories;
		$error    = "You can not delete this category because some products depend on it";
		if ($check->exists($id) == true) {

			return Redirect::to('categories')->with('error', $error);
		} else {
			$category->delete();
		}
		// redirect
		return Redirect::to('categories');
	}

	/*public function show($id) {
$category = Categories::find($id);

return View::make('categories.show')->with('category', $category);
}*/
}