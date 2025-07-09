<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public function contract(){
        return $this->belongsTo(Contract::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
