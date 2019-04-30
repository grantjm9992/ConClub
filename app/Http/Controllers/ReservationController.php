<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use \App\Providers\TranslationProvider;
use Illuminate\Http\Request;

use \App\Mail\ReservationRequest;
use \App\Mail\ReservationResponse;
use \App\Reservations;


class ReservationController extends BaseController
{
    const ADMIN = array(
        "thesimo@hotmail.co.uk",
        "lynn.simo@yahoo.co.uk",
        "paulandrachel2010@hotmail.com",
        "thecondadoclub2019@gmail.com"
    );

    public function __construct() {
        parent::__construct();
    }

    public function makeAction() {
        $date = new \DateTime($_REQUEST['date']." ".$_REQUEST['time']);
        $reservation = new Reservations;
        $reservation->name = $_REQUEST['name'];
        $reservation->email = $_REQUEST['email'];
        $reservation->people = $_REQUEST['people'];
        $reservation->phone = $_REQUEST['tel'];
        $reservation->date = $date->format('Y-m-d H:i:s');
        $reservation->save();

        $notification = new \App\Notifications;
        $notification->date = $date->format('Y-m-d H:i:s');
        $notification->save();

        \Mail::to( self::ADMIN )->send( new ReservationRequest( $reservation ) );
        
        return "OK";
    }

    public function defaultAction()
    {
        $this->cont->body = view('home/success');
        return $this->RenderView();
    }

    public function responseAction()
    {
        $response = (int)$_REQUEST['response'];
        $id = base64_decode( $_REQUEST['id'] );
        $reservation = Reservations::where('id', $id)->first();

        if ( $response === 1 )
        {
            $reservation->confirmed = 1;
            $txt = "Your reservation has been accepted, see you soon";
        }
        else
        {
            $reservation->confirmed = 0;
            $txt = "Unfortunately we haven't been able to confirm your reservation this time.";
        }

        $reservation->save();

        \Mail::to( $reservation->email )->send( new ReservationResponse( $txt ) );
        \Redirect::to('/Reservations')->send();
    }
}