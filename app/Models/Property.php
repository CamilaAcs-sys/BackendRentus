<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
  function user(){
        return $this->belongsTo(User::class);
    }

    function maintenances(){
        return $this->hasMany(Maintenance::class);
    }
    function contracts(){
        return $this->hasMany(Contract::class);
    }

    public function rentalRequests() {
        return $this->hasMany(RentalRequest::class);
    }
    protected $fillable = [
    'title',
    'description',
    'address',
    'city',
    'status',
    'monthly_price',
    'area_m2',
    'num_bedrooms',
    'num_bathrooms',
    'included_services',
    'publication_date',
    'user_id',
    'image_url'
];
}
