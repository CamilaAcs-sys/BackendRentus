<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Report extends Model
{
     public function user(){
        return $this->belongsTo(User::class);
     }
     
    // Campos que se pueden asignar masivamente (por create, update, etc.)
    protected $fillable = [
        'type',
        'applied_filter',
        'generation_date',
        'user_id'
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

    // Scope para incluir relaciones si están permitidas y se solicitan desde la URL
    public function scopeIncluded(Builder $query)
    {
        // Si no hay relaciones definidas o no se enviaron por request, se sale
        if (empty($this->allowIncluded) || empty(request('included'))) {
            return;
        }

        // Se separan las relaciones solicitadas por comas
        $relations = explode(',', request('included'));

        // Se convierte el array de relaciones permitidas en una colección
        $allowIncluded = collect($this->allowIncluded);

        // Se eliminan las relaciones no permitidas
        foreach ($relations as $key => $relationship) {
            if (!$allowIncluded->contains($relationship)) {
                unset($relations[$key]);
            }
        }

        // Se agregan las relaciones válidas al query
        $query->with($relations);
    }

    // Scope para aplicar filtros dinámicos desde la URL
    public function scopeFilter(Builder $query)
    {
        // Si no hay filtros definidos o no se enviaron por request, se sale
        if (empty($this->allowFilter) || empty(request('filter'))) {
            return;
        }

        // Se obtienen los filtros enviados
        $filters = request('filter');

        // Se convierte el array de filtros permitidos en colección
        $allowFilter = collect($this->allowFilter);

        // Se recorren los filtros enviados
        foreach ($filters as $filter => $value) {
            // Si el filtro está permitido, se aplica el where con LIKE
            $query->where($filter, 'LIKE', '%' . $value . '%');
        }
    }
}
