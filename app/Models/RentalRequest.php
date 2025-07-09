<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalRequest extends Model
{
    public function contract(){
        return $this->belongsTo(Contract::class);
    }
    public function property(){
        return $this->hasMany(Property::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
