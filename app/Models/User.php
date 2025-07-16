<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // Campos que se pueden asignar masivamente (por create, update, etc.)
    protected $fillable = [
        'name',                  // Nombre del usuario
        'email',                 // Correo electrónico del usuario
        'password_hash',         // Contraseña del usuario (almacenada como hash)
        'phone',                 // Teléfono del usuario
        'address',               // Dirección del usuario
        'id_documento',          // Documento de identificación del usuario
        'status',                // Estado del usuario (activo, inactivo, etc.)
        'registration_date',     // Fecha de registro del usuario
        'password'               // Contraseña del usuario (sin hash, se usa para autenticación)
    ];

    // Relaciones permitidas para ser incluidas desde la URL con ?included=
    protected $allowIncluded = [
        'properties',
        'contracts',
        'reports',
        'maintenances',
        'rentalRequest',
        'ratings'
    ];

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

    // Campos permitidos para ser ordenados desde la URL con ?sort=
    protected $allowSort = [
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

    public function properties(){return $this->hasMany(Property::class);}

    public function contracts(){return $this->hasMany(Contract::class);}

    public function reports(){return $this->hasMany(Report::class);}

    public function maintenances(){return $this->hasMany(Maintenance::class);}

    public function rentalRequest(){return $this->hasMany(RentalRequest::class);}

    public function ratings(){return $this->hasMany(Rating::class);}

    /**
     * Scope que incluye relaciones dinámicamente si están permitidas.
     */
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

    /**
     * Scope que aplica filtros dinámicamente a la consulta.
     */
    public function scopeFilter(Builder $query)
    {
        if (empty($this->allowFilter) || empty(request('filter'))) {
            return;
        }

        $filters = request('filter');
        $allowFilter = collect($this->allowFilter);

        foreach ($filters as $filter => $value) {
            if ($allowFilter->contains($filter)) {
                $query->where($filter, 'LIKE', '%' . $value . '%');
            }
        }
    }

    /**
     * Scope que aplica ordenamiento dinámico a la consulta.
     */
    public function scopeSort(Builder $query)
    {
        if (empty($this->allowSort) || empty(request('sort'))) {
            return;
        }

        $sortFields = explode(',', request('sort'));
        $allowSort = collect($this->allowSort);

        foreach ($sortFields as $sortField) {
            $direction = 'asc';

            if (substr($sortField, 0, 1) == '-') {
                $direction = 'desc';
                $sortField = substr($sortField, 1);
            }

            if ($allowSort->contains($sortField)) {
                $query->orderBy($sortField, $direction);
            }
        }
    }

    /**
     * Scope que retorna una colección paginada si se solicita con ?perPage=X,
     * o una colección completa si no se indica paginación.
     */
    public function scopeGetOrPaginate(Builder $query)
    {
        if (request('perPage')) {
            $perPage = intval(request('perPage'));

            if ($perPage) {
                return $query->paginate($perPage);
            }
        }
        return $query->get();
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
