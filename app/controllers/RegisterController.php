<?php

class registerController extends BaseController {

	public function showRegister() {
		return View::make('profile.register');
	}

	public function doRegister() {
		$user            = new User;
		$user->username  = Input::get('username');
		$user->email     = Input::get('email');
		$user->firstName = Input::get('firstName');
		$user->lastName  = Input::get('lastName');
		$user->phone     = Input::get('phone');
		$user->password  = Hash::make(Input::get('password'));
		$user->save();

		return View::make('profile.login');
	}
}

?>