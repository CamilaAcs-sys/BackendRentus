<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Report extends Model
{
    use HasFactory;
    public function user(){return $this->belongsTo(User::class);}

    // Campos que se pueden asignar masivamente (por create, update, etc.)
    protected $fillable = [
        'type',             // Tipo de reporte (ej: spam, contenido inapropiado, etc.)
        'applied_filter',   // Filtro aplicado al reporte (ej: por usuario, por fecha, etc.)
        'generation_date',  // Fecha de generación del reporte
        'user_id'           // ID del usuario que generó el reporte
    ];

    // Relaciones permitidas para ser incluidas desde la URL con ?included=
    protected $allowIncluded = [
        'user'
    ];

    // Campos permitidos para ser filtrados desde la URL con ?filter[]
    protected $allowFilter = [
        'id',
        'type',
        'applied_filter',
        'generation_date',
        'user_id'
    ];

    // Campos permitidos para ser ordenados desde la URL con ?sort=
    protected $allowSort = [
        'id',
        'type',
        'applied_filter',
        'generation_date',
    ];

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
