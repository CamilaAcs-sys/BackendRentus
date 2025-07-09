<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Maintenance extends Model
{
    use HasFactory;
    
    function property(){
        return $this->belongsTo(Property::class);
    }
    function user(){
        return $this->belongsTo(User::class);
    }
}
