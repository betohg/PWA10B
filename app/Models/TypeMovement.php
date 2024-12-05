<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeMovement extends Model
{ 
    use HasFactory;

    /**
     * Tabla asociada al modelo.
     */
    protected $table = 'movement_types';

    /**
     * Clave primaria personalizada.
     */
    protected $primaryKey = 'movement_type_id';

    /**
     * Campos que pueden ser asignados masivamente.
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Indica si la clave primaria es autoincremental.
     */
    public $incrementing = true;

    /**
     * Tipo de clave primaria (entero en este caso).
     */
    protected $keyType = 'int';
}
