<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    // === JWT Methods ===
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // === Fillable fields ===
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'id_documento',
        'status',
        'registration_date'
    ];

    // === Hidden fields (para respuestas JSON) ===
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // === Casting automático (Laravel 10+) ===
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // === Relaciones ===
    public function properties() { return $this->hasMany(Property::class); }
    public function contracts() { return $this->hasMany(Contract::class); }
    public function reports() { return $this->hasMany(Report::class); }
    public function maintenances() { return $this->hasMany(Maintenance::class); }
    public function rentalRequest() { return $this->hasMany(RentalRequest::class); }
    public function ratings() { return $this->hasMany(Rating::class); }

    // === Filtros dinámicos ===
    protected $allowIncluded = [
        'properties',
        'contracts',
        'reports',
        'maintenances',
        'rentalRequest',
        'ratings'
    ];

    protected $allowFilter = [
        'id', 'name', 'email', 'phone', 'address',
        'id_documento', 'status', 'registration_date'
    ];

    protected $allowSort = [
        'id', 'name', 'email', 'phone', 'address',
        'id_documento', 'status', 'registration_date'
    ];

    public function scopeIncluded(Builder $query)
    {
        if (!request()->has('included')) return;

        $relations = collect(explode(',', request('included')))
            ->intersect($this->allowIncluded)
            ->all();

        if (!empty($relations)) {
            $query->with($relations);
        }
    }

    public function scopeFilter(Builder $query)
    {
        if (!request()->has('filter')) return;

        foreach (request('filter') as $field => $value) {
            if (in_array($field, $this->allowFilter)) {
                $query->where($field, 'LIKE', "%$value%");
            }
        }
    }

    public function scopeSort(Builder $query)
    {
        if (!request()->has('sort')) return;

        foreach (explode(',', request('sort')) as $sortField) {
            $direction = str_starts_with($sortField, '-') ? 'desc' : 'asc';
            $field = ltrim($sortField, '-');

            if (in_array($field, $this->allowSort)) {
                $query->orderBy($field, $direction);
            }
        }
    }

    public function scopeGetOrPaginate(Builder $query)
    {
        $perPage = request('perPage');
        return $perPage ? $query->paginate((int)$perPage) : $query->get();
    }
}
