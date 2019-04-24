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

class EventsController extends BaseController
{

    public function __construct() {
        $this->secure = 1;
        parent::__construct();
    }
    
    public function defaultAction() {
        $this->botonera = view('comun/addbtn', array(
            "url" => "Events.edit"
        ));
        $this->pageTitle = "Events";
        $this->iconClass = "fa-calendar";
        $table = $this->eventTableAction();
        $this->cont->body = view('admin/events', array(
            "table" => $table
        ));

        return $this->RenderView();
    }

    public function eventTableAction()
    {
        $this->detailURL = "Events.edit?id=";
        $this->data = Events::tableData();
        $this->campos[] = array(
            "name" => "str_title",
            "title" => "Title"
        );
        $this->campos[] = array(
            "name" => "date",
            "title" => "Date"
        );

        return $this->createTable();
    }

    public function editAction()
    {
        $this->botonera = view('comun/standardbtn');
        $this->pageTitle = "Edit Event";
        $this->iconClass = "fa-calendar";
        if ( isset( $_REQUEST['id'] ) && $_REQUEST['id'] != "" )
        {
            $id = $_REQUEST['id'];
            $event = Events::where('id', $id)->first();
            if( !is_object( $event ) ) return \Redirect::to('Events')->send();
        }
        else
        {
            $event = new Events;
        }
        $image = ( file_exists( $event->image ) ) ? view('events/hasimage', array("event" => $event ) ) : view('events/uploadimage');

        $this->cont->body = view('events/detail', array(
            "event" => $event,
            "image" => $image
        ));
        return $this->RenderView();
    }
    
    public function updateEventAction()
    {
        $id = Events::updateThis();
        $this->checkImage($id);
        return \Redirect::to('Events')->send();
    }
    
    protected function checkImage($id)
    {
        if ( isset( $_FILES['file'] ) && $_FILES['file']['name'] != "" )
        {
            $files = $_FILES['file'];
            $temp = $_FILES['file']['tmp_name'];
            $time = \time();
            $arr = explode('.',$_FILES['file']['name']);
            $file_ext=strtolower($arr[count($arr)-1]);
            if ( !is_dir( "data/events/$id/" ) ) mkdir( "data/events/$id/", 0777, true );
            $file_url = "data/events/$id/$id.$file_ext";
            move_uploaded_file($temp, $file_url);
            $event = Events::where('id', $id)->first();
            $event->image = $file_url;
            $event->save();
        }
    }

    public function returnEvents()
    {
        $html = "";
        $events = Events::whereRaw('date > NOW()')->orderBy('date', 'ASC')->get();
        foreach ( $events as $event )
        {
            $date = new \DateTime( $event->date );
            $event->date = $date->format('g:ia \o\n l jS F Y');
            $html .= view('events/event', array(
                "event" => $event
            ));
        }
        if ( $html == "" )
        {
            $html = "<div style='width: 100%;' class='alert alert-warning'><i class='fas fa-exclamation-circle'></i>There are no upcoming events</div>";
        }
        return $html;
    }

    public function returnImageAction()
    {
        $id = $_REQUEST['id'];
        $event = Events::where('id', $id)->first();

        return view('events/imageViewer', array(
            "event" => $event
        ));
    }

    public function addImageAction()
    {
        $files = $_FILES['file'];
        $temp = $files['tmp_name'];
        $time = \time();
        $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
        $_SESSION['file_name'] = "$time.$file_ext";
        $_SESSION['file_upload'] = "data/uploadwait/$time.$file_ext";
        move_uploaded_file($file_tmp, "data/uploadwait/$time.$file_ext");
        return json_encode(
            array(
                "success" => 1
            )
        );
    }

    public function deleteAction()
    {
        $id = $_REQUEST['id'];
        $event = Events::where('id', $id)->first();
        $event->delete();
        
        return json_encode(
            array(
                "success" => 1
            )
        );
    }

    public function postAction()
    {
        $id = $_REQUEST['id'];
        $event = Events::where('id', $id)->first();

        $page_access_token = 'EAAfLuBBC5qIBALZADCm8lkoVLZBmKfZApZCkeHYnJIzZCMaxZBr5rVvsNXxBkXOd1zoafZCBdErOiEYYVD4InnzQgDfZBsWXB2QUOEsvM4fF3lrlTnVstmliHUScIRZCHbg8K02JyJq8uXP2D86eVK3eKQDbtsHfWZBnd56S4f6qMyxyh0JwWyA6QA7mp5xE673QUZD';
        $page_id = '1413333812249138';

        $data['picture'] = "http://www.example.com/image.jpg";
        $data['link'] = url('');
        $data['message'] = $event->str_title;
        $data['caption'] = "Caption";
        $data['description'] = $event->str_description;

        $data['access_token'] = $page_access_token;
        $post_url = 'https://graph.facebook.com/'.$page_id.'/feed';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $post_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $return = curl_exec($ch);
        curl_close($ch);

        return json_encode(
            array(
                "success" => 1
            )
            );

    }

}