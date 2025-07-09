<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
     public function property(){
        return $this->belongsTo(Property::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function ratings(){
        return $this->hasMany(Rating::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function rentalRequest() {
        return $this->hasOne(RentalRequest::class);
    }
}
