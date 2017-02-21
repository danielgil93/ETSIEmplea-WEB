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
//use Illuminate\Foundation\Bus\DispatchesJobs;
use Input;
use ReCaptcha\ReCaptcha;

class OfertaController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
    public function index(){
        //$ofertas = Oferta::all();

        return view('confirm.index');
    }

    /**
     * Almacena una nueva oferta en la BD.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){	
		session_start();
		
		if($this->captchaCheck() == 0) {
			$_SESSION['name'] = $request->company_name;
			$_SESSION['mail'] = $request->email;
			$_SESSION['phone'] = $request->telephone;
			$_SESSION['descripcion'] = $request->descript;
			$_SESSION['enlaces'] = $request->url;
			$_SESSION['select'] = $request->select;
			$_SESSION['type'] = $request->TipoOferta;
			return Redirect::to('notifycaptcha');

		} else {
			session_destroy();
		
			$oferta = new Oferta;

			$oferta->name = $request->company_name;
			$oferta->email = $request->email;
			$oferta->phone = $request->telephone;

			$dest = "";
			$tam = count($request->select);
			foreach ($request->select as $valor) {
				if($tam > 1)
					$dest .= "Ingeniería ".$valor.",";
				else
					$dest .= "Ingeniería ".$valor."";
				$tam--;
			}

			$oferta->target = $dest;

			$oferta->type = $request->TipoOferta;
			$oferta->description = $request->descript;
			$oferta->urls = $request->url;
			$oferta->confirmed = 0;
			$oferta->save();

			$id = Crypt::encrypt($oferta->id);
			$url = action('OfertaController@confirm', $id);
            $url2 = action('OfertaController@reject', $id);

			$data = array(
				'name' => $oferta->name,
				'email' => $oferta->email,
				'phone' => $oferta->phone,
				'target' => $oferta->target,
				'type' => $oferta->type,
				'description' => $oferta->description,
				'urls' => $oferta->urls,
				'url' => $url,
                'url2' => $url2
			);

			//Email de Pendiente de Confirmación de ofertas
			Mail::send(['html' => 'mail'], $data, function($message) use($oferta){
				//$message->to('etsiemplea@uhu.es');
				$message->to('direccion@eps.uhu.es');
				$message->subject('[ETSIEmplea] Pendiente de Confirmación: '.$oferta->type." - ".$oferta->name);
			});
			
			//return Redirect::to('/confirm');
			return view('confirm', $data);
		}
    }



    /**
     * Función para confirmar que la oferta a sido aceptada.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirm($id){

        $idDecrypt = Crypt::decrypt($id);

        $oferta = Oferta::find($idDecrypt);
		
        if($oferta->confirmed == 0) { 
		
            $oferta->confirmed = 1;

            $oferta->save();

            $data2 = array(
                'name' => $oferta->name,
                'email' => $oferta->email,
                'phone' => $oferta->phone,
                'target' => $oferta->target,
                'type' => $oferta->type,
                'description' => $oferta->description,
                'urls' => $oferta->urls
            );

            //Correo a la empresa para informar que la oferta ha sido validada
            Mail::send(['html' => 'mail'], $data2, function($message) use($oferta) {
                $message->to($oferta->email);
                $message->subject('[ETSIEmplea] Oferta validada: '.$oferta->type." - ".$oferta->name);
            });

            //Tomamos todos los correos de los alumnos egresados de la base de datos
            $users = Egresado::all();
            foreach ($users as $user){
			//for ($i = 0; $i < 10; $i++){
            	if($user->subscribed == 1){
            		$iduser = Crypt::encrypt($user->id);
					//$iduser = '';
					//$urluns = '';
        			$urluns = action('UserController@unsubscribe', $iduser);
        			$data1 = array(
		                'name' => $oferta->name,
		                'email' => $oferta->email,
		                'phone' => $oferta->phone,
		                'target' => $oferta->target,
		                'type' => $oferta->type,
		                'description' => $oferta->description,
		                'urls' => $oferta->urls,
		                'urluns' => $urluns
		            );

		            Mail::send(['html' => 'mail'], $data1, function($message) use($oferta, $user) {
					//Mail::send(['html' => 'mail'], $data1, function($message) use($oferta) {
		                //$message->to('etsiemplea@uhu.es'); //Aqui se mandaria a la lista de egresados, se pone este correo para pruebas
		                $message->to($user->email); //Se manda a los correos de egresados de la BD de egresados
		                $message->subject("[ETSIEmplea] ".$oferta->type." - ".$oferta->name);
		            });
		        }
        	}

			//NOTIFICACION
            switch ($oferta->type) {
                case 'Oferta de Trabajo':
                    $type_n='0';
                    break;
                case 'Beca de Formación':
                    $type_n='1';
                    break;
                case 'Curso de Formación':
                    $type_n='2';
                    break;
                case 'Concurso':
                    $type_n='3';
                    break;
                default:
                    $type_n='4';
                    break;
            }

            $headers = [
                'Authorization' => 'key='.env('API_KEY'),
                'Content-Type' => 'application/json',
            ];

            $date = date("Y-m-d H:i:s", strtotime($oferta->updated_at));

            $data_notification = array(
                'id' => $oferta->id,
                'name' => $oferta->name,
                'email' => $oferta->email,
                'phone' => $oferta->phone,
                'target' => $oferta->target,
                'type' => $oferta->type,
                'description' => $oferta->description,
                'updated_at' => $date,
                'urls' => $oferta->urls,  
            );

            $messages = [
                'offer' => $data_notification,
                'type' => $type_n
            ];

            $body = [
                'to' => '/topics/global',
                'data' => $messages,
            ];

            $client = new Client;
            $res = $client->post('https://gcm-http.googleapis.com/gcm/send', [ 'headers' => $headers, 'json' => $body, ]);

        } else if($oferta->confirmed == 2) { 
            return Redirect::to('notifyrejected2');
        }
		
        return Redirect::to('notifyconfirmed');
    }



    /**
     * Función para rechazar la oferta.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reject($id){

        $idDecrypt = Crypt::decrypt($id);

        $oferta = Oferta::find($idDecrypt);
        
        if($oferta->confirmed == 0){ 
            
            //Retorna a la vista del formulario pasando por parámetro el id de la oferta
            return view('formreject', ['id' => $id]);

        } else if($oferta->confirmed == 2) { 
            return Redirect::to('notifyrejected2');
        }
            
        return Redirect::to('notifysended');
    }


    /**
     * Función para confirmar que la oferta a sido rechazada.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirmreject(Request $data){

        $id = $data->idhidden;

        $idDecrypt = Crypt::decrypt($id);

        $oferta = Oferta::find($idDecrypt);
        
        if($oferta->confirmed == 0){ 
            
            $oferta->confirmed = 2;

            $oferta->save();

            $data2 = array(
                'name' => $oferta->name,
                'email' => $oferta->email,
                'phone' => $oferta->phone,
                'target' => $oferta->target,
                'type' => $oferta->type,
                'description' => $oferta->description,
                'urls' => $oferta->urls,
                'motivo' => $data->motivo,
                'desc_motivo' => $data->descript
            );
            
            //Correo a la empresa para informar que la oferta ha sido rechazada
            Mail::send(['html' => 'mailrejected'], $data2, function($message) use($oferta) {
                $message->to($oferta->email);
                $message->subject('[ETSIEmplea] Oferta rechazada: '.$oferta->type." - ".$oferta->name);
            });
            
            return Redirect::to('notifyrejected');

        } else if($oferta->confirmed == 2) { 
            return Redirect::to('notifyrejected2');
        }
            
        return Redirect::to('notifysended');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $oferta = ETSIEmplea\Oferta::findOrFail($id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $oferta = ETSIEmplea\Oferta::find($id);

        $oferta->delete();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function create()
    {
        //
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function edit($id)
    {
        //
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function update(Request $request, $id)
    {
        //
    }*/
	

	public function captchaCheck(){
        $response = Input::get('g-recaptcha-response');
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $secret   = env('RE_CAP_SECRET');

        $recaptcha = new ReCaptcha($secret);
        $resp = $recaptcha->verify($response, $remoteip);
        if ($resp->isSuccess()) {
            return 1;
        } else {
            return 0;
        }
    }



    /**
     * Descarga de las ofertas desde una fecha determinada.
     *
     * @param  String $date
     * @return \Illuminate\Http\Response
     */
    public function syncOffers($fecha){

        $offers = Oferta::where('updated_at','>=', $fecha)->where('confirmed', 1)->get();
        return $offers;
    }

}
