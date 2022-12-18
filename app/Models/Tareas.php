<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tareas extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'tareas';

    protected $fillable = [
        'id_user_asignado',
        'id_user_ordeno',
        'descripcion',    
        'tipo'
    ];
}
