<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuCategories extends Model
{

    protected $table = "menu_categories";
    
    public function setOrden( $i = null )
    {
        if ( $i === null )
        {
            $categories = self::get();
            $i = count( $categories ) + 1;
        }
        $this->order = $i;
        $this->save();
    }

    public function getItems()
    {
        return MenuItems::where('id_category', $this->id)->orderBy('order', 'ASC')->get();
    }
}
