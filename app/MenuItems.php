<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuItems extends Model
{
    protected $table = "menu_items";

    protected $fillable = ["id_category", "category", "image", "name", "price"];

    public function setOrden( $i = null )
    {

        if ( $i === null )
        {
            $items = self::where('id_category', $this->id_category)->get();
            $i = count( $items ) + 1;
        }
        $this->order = $i;
        $this->save();
    }

    public function updateItem()
    {
        $this->name = $_REQUEST['name'];
        $this->description = $_REQUEST['description'];
        $this->price = $_REQUEST['price'];
        $this->save();
    }
}
