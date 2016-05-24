<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
 */
Route::get('logout', 'ProfileController@logout');
Route::get('login', 'ProfileController@getLogin');
Route::post('login', 'ProfileController@postLogin');
Route::post('register', 'RegisterController@doRegister');
Route::get('register', 'RegisterController@showregister');

Route::get('/', function () {
		return View::make('master');
	});

Route::get('password/reset', array(
		'uses' => 'PasswordController@remind',
		'as'   => 'password.remind',
	));
Route::post('password/reset', array(
		'uses' => 'PasswordController@request',
		'as'   => 'password.request',
	));
Route::get('password/reset/{token}', array(
		'uses' => 'PasswordController@reset',
		'as'   => 'password.reset',
	));
Route::post('password/reset/{token}', array(
		'uses' => 'PasswordController@update',
		'as'   => 'password.update',
	));
Route::group(array('before' => 'auth'), function () {
		Route::get('add_product', 'ProductController@showData');
		Route::post('view_product_details', 'ProductController@viewProductDetails');

		//Routes
		Route::resource('categories', 'CategoryController');

		Route::resource('purchaseOrder', 'PurchaseOrderController');
		Route::get('loadCategoriesPO', 'PurchaseOrderController@loadCategoriesPO');
		Route::get('loadProductsPO', 'PurchaseOrderController@loadProductsPO');

		Route::resource('invoices', 'InvoiceController');
		Route::get('loadProducts', 'InvoiceController@loadProducts');
		Route::get('loadSuppliers', 'InvoiceController@loadSuppliers');

		Route::resource('suppliers', 'SupplierController');

		Route::resource('products', 'ProductController');

		//Route::post('products.create', 'ProductController@create');

		Route::resource('suppliers.details', 'SupplierController@details');

		Route::resource('products.details', 'ProductController@details');

		Route::resource('invoices.details', 'InvoiceController@details');

		Route::resource('reports', 'ReportController');
		Route::resource('reports.details', 'ReportController@details');

		Route::resource('home', 'HomeController');
		Route::get('/home', 'HomeController@index');
		Route::get('user', 'ProfileController@getUser');
		Route::get('edit', 'ProfileController@edit');
		//Route::get('users', 'ProfileController');

	});