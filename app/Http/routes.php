<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
	Route::get('/', function () {
		return view('index');
	});

	Route::get('admin', ['middleware' => 'auth', function()
	{
		return 'entra';
	}]);


	Route::get('/unsubscribed', function () {
		return view('unsubscribe');
	});


	Route::get('notifyconfirmed', function () {
		session()->flash('message', 'Oferta validada correctamente, gracias');
	    return redirect()->to('/#oferta');
	});

	Route::get('notifyrejected', function () {
		session()->flash('message', 'Oferta rechazada correctamente, gracias');
	    return redirect()->to('/#oferta');
	});

	Route::get('notifysended', function () {
		session()->flash('errormessage', 'Oferta validada con anterioridad, no puede ser rechazada, gracias');
	    return redirect()->to('/#oferta');
	});

	Route::get('notifyrejected2', function () {
		session()->flash('errormessage', 'Oferta rechazada con anterioridad. Gracias');
	    return redirect()->to('/#oferta');
	});

	Route::get('unsubscribedconfirmed', function () {
		session()->flash('message', 'Se ha desuscrito correctamente, gracias');
	    return redirect()->to('/#oferta');
	});

	Route::get('usernotifyconfirmed', function () {
		session()->flash('message', 'Usuario aceptado correctamente, gracias');
	    return redirect()->to('/#oferta');
	});
	
	Route::get('usernotifyreject', function () {
		session()->flash('message', 'Usuario rechazado correctamente, gracias');
	    return redirect()->to('/#oferta');
	});

	Route::get('notifycaptcha', function () {
		session()->flash('errormessage', 'Captcha Incorrecto');
	    return redirect()->to('/#oferta');
	});

	Route::get('newusernotifyconfirm', function () {
		session()->flash('message', 'Petición de alta solicitada correctamente, gracias');
	    return redirect()->to('/#oferta');
	});


	
	Route::get('/confirm/{id}', ['uses' => 'OfertaController@confirm']);

	Route::get('/reject/{id}', ['uses' => 'OfertaController@reject']);

	Route::post('/confirmreject', ['uses' => 'OfertaController@confirmreject']);

	Route::get('/unsubscribe/{id}', ['uses' => 'UserController@unsubscribe']);

	Route::get('/subscribe/{email}', ['uses' => 'UserController@subscribe']);

	Route::get('/login/{email}', ['uses' => 'UserController@login']);

	Route::get('/newuser/{requestencrypt}', ['uses' => 'UserController@newuser']);

	//Route::get('/userconfirm/{email}', ['uses' => 'UserController@confirm']);
	Route::get('/userconfirmm/{email}', ['uses' => 'UserController@confirmm']);
	
	Route::get('/userreject/{email}', ['uses' => 'UserController@reject']);

	Route::get('/userverify/{email}', ['uses' => 'UserController@verify']);

	Route::get('/confirm_newuser', ['uses' => 'UserController@confirm_newuser']);

	Route::get('/sync/{fecha}', ['uses' => 'OfertaController@syncoffers']);
});

//Route::get('/ofertas', ['uses' => 'OfertaController@store']);

//Route::controllers('ofertas', 'OfertaController');

Route::resource('confirm', 'OfertaController', ['except' => [
    'create', 'edit', 'update', 'destroy'
]]);