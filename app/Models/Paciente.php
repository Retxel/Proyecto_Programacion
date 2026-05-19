<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $table = 'pacientes';
    protected $primaryKey = 'id_paciente';

    protected $fillable = [
        'documento_identidad',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'fecha_nacimiento',
        'genero',
        'telefono',
        'correo',
        'id_usuario_creador',
    ];

    public function creador()
    {
        return $this->belongsTo(User::class, 'id_usuario_creador', 'id_usuario');
    }

    public function historiaMedica()
    {
        return $this->hasOne(HistoriaMedica::class, 'id_paciente', 'id_paciente');
    }
}
