<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $table = "events";
    protected $fillable = ["str_title", "str_description", "image", "date", "date_created"];


    public static function getUpcoming($i)
    {
        $events = self::whereRaw('date > NOW() ')->orderBy('date', 'ASC')->take($i)->get();
        return $events;
    }

    public static function tableData()
    {
        $events = self::whereRaw( self::makeWhere() )->orderBy('date', 'ASC' )->get();
        return $events;
    }

    public static function makeWhere()
    {
        $where = " 1 ";
        $query = (isset ( $_REQUEST['query'] ) && $_REQUEST['query'] != "" ) ? $_REQUEST['query'] : null;
        $when = (isset ( $_REQUEST['when'] ) && $_REQUEST['when'] != "" ) ? $_REQUEST['when'] : null;
        if ( !is_null( $query ) ) $where .= " AND (str_title LIKE '%$query%' OR str_description LIKE '%$query%') ";
        if ( !is_null( $when ) )
        {
            
            if ( (int)$when === -1 )
            {
                $where .= " AND date < NOW() ";
            }
            else if ( (int)$when === 1 )
            {
                $where .= " AND date > NOW() ";
            }
        }
        else
        {
            $where .= " AND date > NOW() ";
        }

        return $where;
    }

    public static function updateThis()
    {
        if ( !isset( $_REQUEST['id'] ) || $_REQUEST['id'] == "" ) return self::createThis();
        $id = $_REQUEST['id'];
        $event = self::where('id', $id)->first();
        foreach ( $_REQUEST as $key => $value )
        {
            if ( !is_null( $event->$key ) )
            {
                $event->$key = $value;
            }
        }
        $event->save();
        return $event->id;
    }

    public static function createThis()
    {
        $event = new Events;
        if( isset( $_REQUEST['str_title'] ) && $_REQUEST['str_title'] != "" ) $event->str_title = $_REQUEST['str_title'];
        if( isset( $_REQUEST['str_description'] ) && $_REQUEST['str_description'] != "" ) $event->str_description = $_REQUEST['str_description'];
        if( isset( $_REQUEST['date'] ) && $_REQUEST['date'] != "" ) $event->date = $_REQUEST['date'];
        $event->save();
        return $event->id;
    }
}
