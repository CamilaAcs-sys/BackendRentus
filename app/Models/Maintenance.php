<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    function property(){
        return $this->belongsTo(Property::class);
    }
    function user(){
        return $this->belongsTo(User::class);
    }
}
