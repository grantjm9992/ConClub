<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use \App\Providers\TranslationProvider;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    public function __construct()
    {
        $this->secure = 1;
        parent::__construct();
    }
    
    public function defaultAction()
    {
        $reservations = "";//$this->createSchedule( "App\Http\Controllers\ReservationsController", "dataAction" );

        //$this->botonera = "<a class='btn btn-primary' href='Reservations.make'><i class='fas fa-plus'></i> Create new</a>";
        $this->pageTitle = "Reservations";
        $this->iconClass = "fa-calendar";
        $this->cont->body = view('reservations/index', array(
            "reservations" => $reservations
        ));

        return $this->RenderView();
    }

    public function dataAction()
    {
        return $this->makeArray( \App\Reservations::where('confirmed', 1)->get() );
    }

    public function makeArray( $ds )
    {
        $arr = array();
        foreach ( $ds as $row )
        {
            $date = new \DateTime( $row->date );
            $date->modify('+ 1 hour');

            $arr[] = array(
                "id" => $row->id,
                "subject" => $row->name." for: ".$row->people,
                "startTime" => $row->date,
                "endTime" => $date->format('Y-m-d H:i:s')
            );
        }

        return $arr;
    }
}
