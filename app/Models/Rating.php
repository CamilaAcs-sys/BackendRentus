<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Rating extends Model
{
    use HasFactory;
    public function contract(){
        return $this->belongsTo(Contract::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
