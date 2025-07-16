<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class RentalRequest extends Model
{
    use HasFactory;
    // Campos que se pueden asignar masivamente (por create, update, etc.)
    protected $fillable = [
        'contract_id',   // ID del contrato asociado a la solicitud de alquiler
        'property_id',   // ID de la propiedad asociada a la solicitud de alquiler
        'user_id'        // ID del usuario que realiza la solicitud
    ];

    // Relaciones permitidas para ser incluidas desde la URL con ?included=
    protected $allowIncluded = [
        'contract',
        'property',
        'user'
    ];

    // Campos permitidos para ser filtrados desde la URL con ?filter[]
    protected $allowFilter = [
        'id',
        'contract_id',
        'property_id',
        'user_id'
    ];

    // Campos permitidos para ser ordenados desde la URL con ?sort=
    protected $allowSort = [
        'id',
        'contract_id',
        'property_id',
        'user_id'
    ];

    public function contract(){return $this->belongsTo(Contract::class);}

    public function property(){return $this->hasMany(Property::class);}

    public function user(){return $this->belongsTo(User::class);}

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
}
