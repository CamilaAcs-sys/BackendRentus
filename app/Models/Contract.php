<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Contract extends Model
{
    use HasFactory;

    // Define los campos que pueden ser asignados masivamente al modelo
    protected $fillable = [
        'start_date',                 // Fecha de inicio del contrato
        'end_date',                   // Fecha de finalización del contrato
        'status',                     // Estado actual del contrato
        'document_path',              // Ruta del documento del contrato
        'validated_by_support',       // Validación por parte del equipo de soporte (booleano)
        'support_validation_date',    // Fecha en que fue validado por soporte
        'accepted_by_tenant',         // Aceptación por parte del inquilino (booleano)
        'tenant_acceptance_date',     // Fecha en que fue aceptado por el inquilino
        'property_id',                // ID de la propiedad relacionada
        'user_id'                     // ID del usuario (inquilino o arrendador)
    ];

    // Relaciones que pueden ser incluidas mediante la query string ?included=...
    protected $allowIncluded = [
        'property',
        'user'
    ];

    // Campos que pueden ser utilizados para filtrar con ?filter[]
    protected $allowFilter = [
        'id',
        'status',
        'start_date',
        'end_date',
        'validated_by_support',
        'accepted_by_tenant',
        'user_id',
        'property_id'
    ];

    // Campos que pueden ser utilizados para ordenar con ?sort=
    protected $allowSort = [
        'id',
        'start_date',
        'end_date',
        'status',
        'document_path',
        'validated_by_support',
        'support_validation_date',
        'accepted_by_tenant',
        'tenant_acceptance_date',
    ];

    public function property(){return $this->belongsTo(Property::class);}

    public function payments(){return $this->hasMany(Payment::class);}

    public function ratings(){return $this->hasMany(Rating::class);}
    
    public function user(){return $this->belongsTo(User::class);}

    public function rentalRequest(){return $this->hasOne(RentalRequest::class);}

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
