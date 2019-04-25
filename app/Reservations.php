<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{
    
    protected $fillable = ['name', 'people', 'email', 'phone', 'date', 'confirmed'];
    
}
