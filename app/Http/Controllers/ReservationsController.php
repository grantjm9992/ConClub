<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use \App\Providers\TranslationProvider;
use Illuminate\Http\Request;

use \App\Reservations;

use \App\Mail\ReservationResponse;

class ReservationsController extends Controller
{
    protected $reservation;

    public function __construct()
    {
        $this->secure = 1;
        parent::__construct();
        if ( isset( $_REQUEST['id'] ) && $_REQUEST['id'] != "" )
        {
            $this->reservation = Reservations::where('id', $_REQUEST['id'])->first();
        }
    }
    
    public function defaultAction()
    {
        $reservations = "";//$this->createSchedule( "App\Http\Controllers\ReservationsController", "dataAction" );

        $this->botonera = "<a class='btn btn-primary' href='Reservations.admin'><i class='fas fa-cogs'></i> Admin</a>";
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

    public function adminAction()
    {

        $table = $this->getListadoAction();
        $this->pageTitle = "Reservation Admin";
        $this->iconClass = "fas fa-table";
        $this->botonera = "<a href='Reservations.new' class='btn btn-primary'><i class='fas fa-plus'></i> New reservation</a>";
        $this->cont->body = view('reservations/admin', array(
            "table" => $table
        ));

        return $this->RenderView();
    }


    public function getListadoAction()
    {
        $this->detailURL = "Reservations.detail?id=";
        $this->campos[] = array(
            "name" => "name",
            "title" => "Name"
        );
        $this->campos[] = array(
            "name" => "email",
            "title" => "Email"
        );
        $this->campos[] = array(
            "name" => "people",
            "title" => "People"
        );
        $this->campos[] = array(
            "name" => "date",
            "title" => "Date"
        );
        $this->data = Reservations::whereRaw( $this->makeWhere() )->orderBy('date', 'DESC')->get();
        return $this->createTable();
    }

    protected function makeWhere()
    {
        $where = " 1 ";
        if ( isset( $_REQUEST['str_query'] ) && $_REQUEST['str_query'] != "" ) $where .= " AND ( email LIKE '%".$_REQUEST['str_query']."%' OR name LIKE '%".$_REQUEST['str_query']."%' ) ";
        if ( isset( $_REQUEST['when'] ) && $_REQUEST['when'] == "fut" ) $where .= " AND date > NOW() ";
        if ( isset( $_REQUEST['when'] ) && $_REQUEST['when'] == "pas" ) $where .= " AND date <= NOW() ";
        if ( isset( $_REQUEST['when'] ) && $_REQUEST['when'] == "all" ) $where .= " ";
        if ( !isset( $_REQUEST['when'] ) || $_REQUEST['when'] == "" ) $where .= " AND date > NOW() ";
        if ( !isset( $_REQUEST['status'] ) || $_REQUEST['status'] == "" ) $where .= " AND ( confirmed IS NULL OR confirmed = 0 ) ";
        if ( isset( $_REQUEST['status'] ) && $_REQUEST['status'] == "0" ) $where .= " AND ( confirmed IS NULL OR confirmed = 0 ) ";
        if ( isset( $_REQUEST['status'] ) && $_REQUEST['status'] == "1" ) $where .= " AND ( confirmed = 1 ) ";
        if ( isset( $_REQUEST['status'] ) && $_REQUEST['status'] == "all" ) $where .= "  ";

        return $where;

    }

    public function sendMailAction()
    {
        $response = (int)$_REQUEST['response'];
        if ( $response === 1 )
        {
            $txt = "Your reservation has been accepted, see you soon";
        }
        else
        {
            $txt = "Unfortunately we haven't been able to confirm your reservation this time.";
        }

        \Mail::to( $this->reservation->email )->send( new ReservationResponse( $txt ) );
        return "OK";
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


    public function newAction()
    {
        $this->pageTitle = "Make reservation";
        $this->iconClass = "fas fa-table";
        $this->botonera = view('reservations/newbuttons');
        $this->cont->body = view('reservations/new');
        return $this->RenderView();
    }

    public function detailAction()
    {
        $this->pageTitle = "Edit reservation";
        $this->iconClass = "fas fa-pencil-alt";
        $this->botonera = view('reservations/editbuttons');
        $this->cont->body = view('reservations/detail', array(
            "reservation" => $this->reservation
        ));
        return $this->RenderView();
    }

    public function saveAction()
    {
        if ( isset( $_REQUEST['id'] ) && $_REQUEST['id'] != "" ){
            $this->reservation->update( $_REQUEST );
        }
        else
        {
            Reservations::create( $_REQUEST );
        }

        \Redirect::to('Reservations.admin')->send();
    }

    public function deleteAction()
    {
        $this->reservation->delete();
        return "OK";
    }
}
