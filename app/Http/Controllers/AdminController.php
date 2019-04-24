<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use \App\Providers\TranslationProvider;
use Illuminate\Http\Request;

use \App\Events;

class AdminController extends BaseController
{

    public function __construct() {
        $this->secure = 1;
        parent::__construct();
    }
    
    public function defaultAction() {
        $reservations = new \StdClass;
        $temp = \App\Reservations::whereRaw(' DATE( date ) = DATE( NOW() ) ')->get();
        $reservations->today = count( $temp );

        $temp = \App\Reservations::whereRaw(' WEEK( date ) = WEEK( NOW() ) ')->get();
        $reservations->week = count( $temp );

        $events = new \StdClass;
        $temp = Events::whereRaw(' WEEK( date ) = WEEK( NOW() ) ')->get();
        $events->week = count ( $temp );
        $temp = Events::whereRaw(' MONTH( date ) = MONTH( NOW() ) ')->get();
        $events->month = count( $temp );

        $this->pageTitle = "Dashboard";
        $this->iconClass = "fa-tachometer-alt";
        $this->cont->body = view('admin/index', array(
            "events" => $events,
            "reservations" => $reservations
        ));
        return $this->RenderView();
    }

    public function menuAction()
    {
        $this->botonera = view('admin/admenus');
        $this->pageTitle = "Menu Administration";
        $this->iconClass = "fa-plate";
        $menuCategoryTable = $this->menuCategoryTableAction();
        $menuItemTable = $this->menuItemTableAction();
        $menuCategories = MenuCategories::orderBy('name', 'ASC')->get();
        $this->cont->body = view('admin/menus', array(
            "menuItemTable" => $menuItemTable,
            "menuCategoryTable" => $menuCategoryTable,
            "menuCategories" => $menuCategories
        ));

        return $this->RenderView();
    }

    public function menuCategoryTableAction()
    {
        $this->detailURL = "Admin.editMenuCategory?id=";
        $this->data = MenuCategories::get();
        $this->campos[] = array(
            "name" => "name",
            "title" => "Name"
        );
        $this->campos[] = array(
            "name" => "order",
            "title" => "Order"
        );

        return $this->createTable();
    }

    public function menuItemTableAction()
    {
        $this->detailURL = "Admin.editMenuItem?id=";
        $this->data = MenuItems::get();
        $this->campos[] = array(
            "name" => "name",
            "title" => "Name"
        );
        $this->campos[] = array(
            "name" => "category",
            "title" => "Category"
        );

        return $this->createTable();
    }

    public function updateEventAction()
    {
        $id = Events::updateThis();
        $this->checkImage($id);
        return \Redirect::to('Events')->send();
    }


    public function getUploadImageSectionAction()
    {
        return view('events/uploadimage');
    }


}