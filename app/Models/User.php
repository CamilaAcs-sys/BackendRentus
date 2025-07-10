<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
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


    // Campos que se pueden asignar masivamente (por create, update, etc.)
    protected $fillable = [
        'name',
        'email',
        'password_hash',
        'phone',
        'address',
        'id_documento',
        'status',
        'registration_date',
        'password'
    ];

    // Relaciones permitidas para ser incluidas desde la URL con ?included=
    protected $allowIncluded = [];

    // Campos permitidos para ser filtrados desde la URL con ?filter[]
    protected $allowFilter = [
        'id',
        'name',
        'email',
        'phone',
        'address',
        'id_documento',
        'status',
        'registration_date'
    ];

    // Ocultar campos sensibles en respuestas JSON
    protected $hidden = [
        'password',
        'remember_token',
        'password_hash'
    ];

    // Convertir automáticamente ciertos campos a tipos nativos
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    // Scope para incluir relaciones si están permitidas y se solicitan desde la URL
    public function scopeIncluded(Builder $query)
    {
        if (empty($this->allowIncluded) || empty(request('included'))) {
            return;
        }

        $relations = explode(',', request('included'));
        $allowIncluded = collect($this->allowIncluded);

        foreach ($relations as $key => $relationship) {
            if (!$allowIncluded->contains($relationship)) {
                unset($relations[$key]);
            }
        }

        $query->with($relations);
    }

    // Scope para aplicar filtros dinámicos desde la URL
    public function scopeFilter(Builder $query)
    {
        if (empty($this->allowFilter) || empty(request('filter'))) {
            return;
        }

        $filters = request('filter');
        $allowFilter = collect($this->allowFilter);

        foreach ($filters as $filter => $value) {
            $query->where($filter, 'LIKE', '%' . $value . '%');
        }
    }
    
    
    
    
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
 

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
