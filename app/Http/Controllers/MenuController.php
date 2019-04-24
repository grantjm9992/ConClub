<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use \App\Providers\TranslationProvider;
use Illuminate\Http\Request;

use \App\MenuCategories;
use \App\MenuItems;

class MenuController extends Controller
{

    public function __construct()
    {
        $this->secure = 1;
        parent::__construct();
    }
    
    public function defaultAction()
    {
        $this->botonera = "<div class='btn btn-outline-primary' onclick='addCategory()'><i class='fas fa-plus'></i> New category</div>";
        $this->pageTitle = "Menu Categories";
        $this->iconClass = "fa-sitemap"; 
        $data = MenuCategories::orderBy('order', 'ASC')->get();
        $cats = "";
        foreach ( $data as $row )
        {
            $cats .= $this->makeSectionAction( $row );
        }
        $this->cont->body = view('menu/index', array(
            "cats" => $cats
        ));

        return $this->RenderView();
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
            if ( !is_dir( "data/menu/$id/" ) ) mkdir( "data/menu/$id/", 0777, true );
            $file_url = "data/menu/$id/$id.$file_ext";
            move_uploaded_file($temp, $file_url);
            $event = MenuItems::where('id', $id)->first();
            $event->image = $file_url;
            $event->save();
        }
    }

    public function categoryAction()
    {
        $id = $_REQUEST['id'];
        $category = MenuCategories::where('id', $id)->first();
        $this->botonera = "<div class='btn btn-outline-primary' onclick='addItem()'><i class='fas fa-plus'></i> New item</div><a href='Menu' class='btn btn-secondary' style='color: #fff;'><i class='fas fa-arrow-left'></i> Go Back</a>";
        $this->pageTitle = "$category->name";
        $this->iconClass = "fa-utensils";
        $items = $category->getItems();
        $it = "";
        foreach ( $items as $el )
        {
            $it .= $this->makeItemSectionAction( $el );
        }

        $this->cont->body = view('menu/category', array(
            "it" => $it,
            "category" => $category
        ));

        return $this->RenderView();
        
    }

    public function itemAction()
    {
        $this->pageTitle = "Edit item";
        $this->iconClass = "fa-utensils";
        $id = $_REQUEST['id'];
        $item = MenuItems::where('id', $id)->first();
        $this->botonera = "<div class='btn btn-primary' onclick='submitForm()'><i class='fas fa-save'></i> Save</div><a href='Menu.category?id=$item->id_category' style='color: white;' class='btn btn-secondary'><i class='fas fa-arrow-left'></i> Go back</a>";

        $image = $this->makeImageSectionAction( $item );

        $this->cont->body = view('menu/item', array(
            "item" => $item,
            "image" => $image
        ));
        return $this->RenderView();
    }

    public function makeImageSectionAction( $item = null )
    {
        $item = ( $item === null ) ? MenuItems::where('id', $_REQUEST['id'])->first() : $item;

        $tpl = ( file_exists( $item->image ) ) ? 'menu/hasimage' : 'menu/uploadimage';

        return view($tpl, array(
            "item" => $item
        ));
    }

    public function saveItemAction()
    {
        $id = $_REQUEST['id'];
        $item = MenuItems::where('id', $id)->first();
        $item->updateItem();
        $this->checkImage($item->id);
        return \Redirect::to("Menu.category?id=$item->id_category")->send();
    }

    public function returnTableAction()
    {
        $this->data = MenuCategories::orderBy('name', 'ASC')->get();
        $this->campos[] = array(
            "name" => "name",
            "title" => "Name"
        );
        $this->detailURL = "Menu.category?id=";

        return $this->createGrid();
    }

    public function returnImageAction()
    {
        $id = $_REQUEST['id'];
        $item = MenuItems::where('id', $id)->first();

        return view('events/imageViewer', array(
            "event" => $item
        ));
    }

    public function makeSectionAction( $category = null ) 
    {
        if ( $category === null ) {
            $category = MenuCategories::create();
            $category->setOrden();
        } 
        else { 
            $category;
        }
        
        return view('menu/category_card', array(
            "category" => $category
        ));

    }

    public function makeItemSectionAction( $item = null ) 
    {
        $item = ( $item === null ) ? MenuItems::create(
            array(
                "id_category" => $_REQUEST['id_category']
            )
        ) : $item;
        $item->setOrden();
        return view('menu/item_card', array(
            "item" => $item
        ));

    }

    public function updateCategoryAction()
    {
        $id = $_REQUEST['id'];
        $name = $_REQUEST['name'];
        
        $category = MenuCategories::where('id', $id)->first();
        $category->name = $name;
        $category->save();
        return json_encode(
            array(
                "success" => 1
            )
            );
    }
    public function updateItemAction()
    {
        $id = $_REQUEST['id'];
        $name = $_REQUEST['name'];
        
        $category = MenuItems::where('id', $id)->first();
        $category->name = $name;
        $category->save();
        return json_encode(
            array(
                "success" => 1
            )
            );
    }

    public function updateOrderAction()
    {
        $ids = $_REQUEST['ids'];
        $idArray = explode("@#", $ids, -1 );
        $type = $_REQUEST['type'];
        if ( $type == "C" )
        {
            $class = "\App\MenuCategories";            
        }
        elseif ( $type == "I" )
        {
            $class = "\App\MenuItems";
        }

        $i = 1;
        foreach ( $idArray as $id )
        {
            $el = $class::where('id', $id)->first();
            $el->setOrden( $i );
            $i++;
        }

        return json_encode(
            array(
                "success" => 1
            )
        );
    }

    public function deleteCategoryAction()
    {
        $id = $_REQUEST['id'];
        $category = MenuCategories::where('id', $id)->first();
        $category->delete();
        return json_encode(
            array(
                "success" => 1
            )
        );
    }
    
    public function deleteItemAction()
    {
        $id = $_REQUEST['id'];
        $category = MenuItems::where('id', $id)->first();
        $category->delete();
        return json_encode(
            array(
                "success" => 1
            )
        );
    }
}
