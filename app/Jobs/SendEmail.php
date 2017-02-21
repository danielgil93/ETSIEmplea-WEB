<?php

namespace ETSIEmplea\Jobs;

use ETSIEmplea\Jobs\Job;
use ETSIEmplea\Oferta;
use ETSIEmplea\Egresado;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $oferta;

    public function __construct(Oferta $oferta)
    {
        $this->oferta = $oferta;
    }

    public function handle(Mailer $mailer)
    {
        //Tomamos los correos de la base de datos
        $users = Egresado::all();
        foreach ($users as $user){
            if($user->subscribed == 1){
                $iduser= Crypt::encrypt($user->id);
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
                Mail::queue(['html' => 'mail'], $data1, function($message) use($oferta, $user) {
                    $message->to('etsiemplea@uhu.es'); //Aqui se mandaria a la lista de egresados, se pone este correo para pruebas
                    //$message->to($user->email); //Se manda a los correos de la BD de egresados
                    $message->subject($oferta->type." - ".$oferta->name);
                });
            }
        }
    }
}