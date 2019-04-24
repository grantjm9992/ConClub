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
use \App\MenuCategories;
use \App\MenuItems;

class HomeController extends BaseController
{

    public function __construct() {
        parent::__construct();
    }
    
    public function defaultAction() {
        $js = /*( isset( $_REQUEST['make'] ) && $_REQUEST['make'] == "1" ) ? view('home/successjs') : */"";
        $eventData = Events::getUpcoming(9);
        $events = array();
        foreach ( $eventData as $ed )
        {
            $ed->date = new \DateTime( $ed->date );
            $events[] = view('home/event', array( "event" => $ed ) );
        }

        $MenuCategories = MenuCategories::orderBy('order', 'ASC')->get();
        $tabs = "";
        $panels = "";
        $i = 0;
        foreach ( $MenuCategories as $row )
        {
            $row->hashid = $row->id."_tab_panel";
            $class = ( $i === 0 ) ? "active" : "";
            $tabs .= view('home/tabs', array(
                "cat" => $row,
                "class" => $class
            ));
            $panels .= $this->panelForCategory( $row, $class );
            $i++;
        }

        $this->cont->body = view('home/index',
                array(
                    'events' => $events,
                    'panels' => $panels,
                    'tabs' => $tabs    
                )
        ).$js;
        return $this->RenderView();
    }

    protected function panelForCategory( $cat, $class )
    {
        $items = MenuItems::where('id_category', $cat->id)->orderBy('order', 'ASC')->get();
        $left = "";
        $right = "";
        $i = 0;
        foreach ( $items as $row )
        {
            if ( !file_exists( $row->image ) ) $row->image = "images/nophoto.png";
            if ( $i % 2 )
            {
                $right .= view('home/item', array(
                    "item" => $row
                ));
            }
            else
            {
                $left .= view('home/item', array(
                    "item" => $row
                ));
            }
            $i++;
        }

        return view('home/panel', array(
            "left" => $left,
            "right" => $right,
            "active" => $class,
            "cat" => $cat
        ));
    }

}