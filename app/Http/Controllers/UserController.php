<?php

namespace ETSIEmplea\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use ETSIEmplea\Oferta;
use ETSIEmplea\Egresado;
use PushNotification;
use GuzzleHttp\Client;
use ETSIEmplea\Http\Requests;
use ETSIEmplea\Http\Controllers\Controller;

class UserController extends Controller
{

    /**
     * Función para desubscribir un usuario.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function unsubscribe($id){
        $idDecrypt = Crypt::decrypt($id);

        $egresado = Egresado::find($idDecrypt);

        if( $egresado->subscribed == 1){ 
        	$egresado->subscribed = 0;

        	$egresado->save();
            return Redirect::to('unsubscribedconfirmed');
        }

        return 'No está suscrito.';
    }

    /**
     * Función para suscribir un usuario.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function subscribe($email){

        //$egresado = Egresado::findBy($email);
        $egresado = Egresado::where('email', '=', $email)->first();

        if( $egresado->subscribed == 0){ 
            $egresado->subscribed = 1;

            $egresado->save();
            return 'success';
        }
        return 'failure';
        //return Redirect::to('unsubscribedconfirmed');
    }


    /**
     * Función para comprobar si existe un usuario.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function login($email) {
        $egresado=Egresado::where('email', '=', $email)->first();

        if($egresado == null){ 
            return 'failure';
        } else {
            if( $egresado->can_login == 1) {
                $egresado->can_login = 0;
                $egresado->save();

                return 'success';
            } else {
                $email = Crypt::encrypt($egresado->email);
                $url = action('UserController@verify', $email);

                $data = array(
                    'email' => $egresado->email,
                    'url' => $url
                );

                //Validación de usuario
                Mail::send(['html' => 'verifyusermail'], $data, function($message) use($egresado){
                    $message->to($egresado->email);
                    //$message->to('etsiemplea@uhu.es');
                    $message->subject('[ETSIEmplea] Verificación de usuario: '.$egresado->email);
                });

                return 'verify';
            }
        }

    }

    /**
     * Función para solicitar el alta de un nuevo usuario.
     *
     * @param  Request $request
                        dni, name, email, degree
     * @return \Illuminate\Http\Response
     */
    public function newuser($requestencrypt){
    	$request = Crypt::decrypt($requestencrypt);

    	$user = Egresado::where('email', '=', $request['email'])->first();

        if($user == null){
            $email = Crypt::encrypt($request['email']);

            $url = action('UserController@confirmm', $email);
        	$url2 = action('UserController@reject', $email);

            $data = array(
                'dni' => $request['dni'],
                'name' => $request['name'],
                'email' => $request['email'],
                'degree' => $request['degree'],
                'url' => $url,
        		'url2' => $url2
            );

            //Email de confirmación de usuario
            Mail::send(['html' => 'usermail'], $data, function($message) use($request){
                $message->to('direccion@eps.uhu.es');
                //$message->to('etsiemplea@uhu.es');
                $message->subject('[ETSIEmplea] Peticion alta usuario: '.$request['name']);
            });

            $datainsert = array(
            	'email' => $request['email'],
            	'subscribed' => 0,
                'can_login' => 2
        	);

			Egresado::insert($datainsert);

            return view('registryverify');
        }

        return 'El correo ya ha sido verificado';

    }

    /**
     * Función para verificar el registro de un usuario 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirm_newuser(Request $request){

        $datauser = array(
                'dni' => $request->dni,
                'name' => $request->name,
                'email' => $request->email,
                'degree' => $request->degree
        );

		$dataencrypt = Crypt::encrypt($datauser);        

        $url = action('UserController@newuser', $dataencrypt);

        $data = array(
                'dni' => $request->dni,
                'name' => $request->name,
                'email' => $request->email,
                'degree' => $request->degree,
                'url' => $url
        );
        
        if($egresado=Egresado::where('email', '=', $request->email)->first() == null) {
            //Correo al usuario para verificar el registro
            Mail::send(['html' => 'usernewconfmail'], $data, function($message) use ($request) {
                $message->to($request->email);
                //$message->to('etsiemplea@uhu.es');
                $message->subject('[ETSIEmplea] Alta Usuario: '.$request->email.' solicitada.');
            });

            return 'success';
        }
        
        return 'exits';
        
    }


    /**
     * Función para confirmar el alta del nuevo usuario.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirmm($email){
        $emailDecrypt = Crypt::decrypt($email);

        $user = Egresado::where('email', '=', $emailDecrypt)->first();

        if ($user != null) {
	        $user->can_login = 1;
            $user->subscribed = 1;
			$user->save();

			$data = array(
	            'email' => $emailDecrypt
	        );

			//Correo al usuario informandole que ha sido aceptado
			Mail::send(['html' => 'userconfmail'], $data, function($message) use ($emailDecrypt) {
				$message->to($emailDecrypt);
				$message->subject('[ETSIEmplea] Alta Usuario: '.$emailDecrypt.' aceptada.');
			});
	        
	        return Redirect::to('usernotifyconfirmed');
	    }

	    return 'El usuario fue rechazado previamente';
    }

    /*public function confirm($email){
        $emailDecrypt = Crypt::decrypt($email);

        if (Egresado::where('email', '=', $emailDecrypt)->first() == null) {
	        //$user->can_login = 1;
			//$user->save();
			$data = array(
	            'email' => $emailDecrypt,
	            'can_login' => 1
	        );

	        Egresado::insert($data);

			//Correo al usuario informandole que ha sido aceptado
			Mail::send(['html' => 'userconfmail'], $data, function($message) use ($emailDecrypt) {
				$message->to($emailDecrypt);
				$message->subject('[ETSIEmplea] Alta Usuario: '.$emailDecrypt.' aceptada.');
			});
	        
	        return Redirect::to('usernotifyconfirmed');
	    }

	    return 'El usuario fue rechazado previamente';
    }*/


    /**
     * Función para denegar el alta como nuevo usuario.
     *
     * @param  string  $email
     * @return \Illuminate\Http\Response
     */
	public function reject($email){
        $emailDecrypt = Crypt::decrypt($email);

        $user = Egresado::where('email', '=', $emailDecrypt)->first();
        $user->delete();

        $data = array(
            'email' => $emailDecrypt,
        );
		
		//Correo al usuario informandole que ha sido denegado
		Mail::send(['html' => 'userrejectmail'], $data, function($message) use ($emailDecrypt) {
			$message->to($emailDecrypt);
			$message->subject('[ETSIEmplea] Solicitud de Usuario: '.$emailDecrypt.' rechazada.');
		});
        
        return Redirect::to('usernotifyreject');
    }


	/**
     * Función para verificar el login del usuario
     *
     * @param  string  $email
     * @return \Illuminate\Http\Response
     */
    public function verify($email){
        $emailDecrypt = Crypt::decrypt($email);

        $egresado = Egresado::where('email', '=', $emailDecrypt)->first();

        if( $egresado->can_login == 0){ 
            $egresado->can_login = 1;

            $egresado->save();
            return view('userverify');
        }
        return 'Usuario ya verificado';
    }
}
