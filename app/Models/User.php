<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

     public function properties(){
        return $this->hasMany(Property::class);
    }
     public function contracts(){
        return $this->hasMany(Contract::class);
    }

    public function reports(){
        return $this->hasMany(Report::class);
    }

    public function maintenances(){
        return $this->hasMany(Maintenance::class);
    }

    public function rentalRequest(){
        return $this->hasMany(RentalRequest::class);
    }

    public function ratings(){
        return $this->hasMany(Rating::class);
    }


    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
