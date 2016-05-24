<?php

class ProfileController extends Controller {

	public function getLogin() {
		// show the form
		return View::make('profile.login');
	}

	public function postLogin() {
		$input = Input::all();

		$credentials = array('username' => $input['username'], 'password' => $input['password']);
		if (Auth::attempt($credentials)) {
			$user            = User::find(1);
			$date            = new DateTime();
			$user->lastLogin = $date;

			$user->save();
			return Redirect::intended('home');
		} else {
			$wrong = 'wrong';
			return Redirect::to('login')->with($wrong);
		}
	}

	public function logout() {
		Auth::logout();
		return Redirect::to('login');
	}

	public function getUser() {
		$user = User::find(1);

		return View::make('profile.user')->with('user', $user);
	}

	public function update($id) {

		$rules = array(
			'username'  => 'required',
			'firstName' => 'required',
			'lastName'  => 'required',
			'email'     => 'required',
			'phone'     => 'required',

		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			$messages = $validator->messages();

			return Redirect::to('profile/edit')
				->withErrors($validator)
				->withInput(Input::all());
		} else {
			$user            = User::find($id);
			$user->username  = Input::get('username');
			$user->firstName = Input::get('firstName');
			$user->lastName  = Input::get('lastName');
			$user->email     = Input::get('email');
			$user->phone     = Input::get('phone');
			$user->save();
			//return View::make('show_product')->with('supplier', $supplier);
			//->with('category', $product);
			//return View::make('view_product_details')->with('product', $product);
			return Redirect::to('profile.user');
		}

	}

	public function edit() {
		$user = User::find(1);

		return View::make('profile.edit')->with('user', $user);
	}

}