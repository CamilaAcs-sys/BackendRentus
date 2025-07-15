<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Rating extends Model
{
    use HasFactory;

    // Campos que se pueden asignar masivamente (por create, update, etc.)
    protected $fillable = [
        'recipient_role',    // Rol del destinatario (inquilino, propietario, etc.)
        'score',             // Puntuación otorgada (ej: 1 a 5)
        'comment',           // Comentario adicional sobre la calificación
        'date',              // Fecha de la calificación
        'contract_id',       // ID del contrato asociado a la calificación
        'user_id'            // ID del usuario que realizó la calificación
    ];

    // Relaciones permitidas para ser incluidas desde la URL con ?included=
    protected $allowIncluded = [
        'contract',
        'user'
    ];

    // Campos permitidos para ser filtrados desde la URL con ?filter[]
    protected $allowFilter = [
        'id',
        'recipient_role',
        'score',
        'comment',
        'date',
        'contract_id',
        'user_id'
    ];

    // Campos permitidos para ser ordenados desde la URL con ?sort=
    protected $allowSort = [
        'id',
        'recipient_role',
        'score',
        'comment',
        'date',
    ];

    public function contract(){return $this->belongsTo(Contract::class);}

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
