<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $table = 'consultas';
    protected $primaryKey = 'id_consulta';

    protected $fillable = [
        'id_historia',
        'id_medico',
        'fecha_consulta',
        'motivo_consulta',
        'signos_vitales',
        'examen_fisico',
        'diagnostico',
        'plan_tratamiento',
        'tratamiento_recetado',
        'examenes_solicitados',
    ];

    protected $casts = [
        'fecha_consulta' => 'datetime',
    ];

    public function historiaMedica()
    {
        return $this->belongsTo(HistoriaMedica::class, 'id_historia', 'id_historia');
    }

    public function medico()
    {
        return $this->belongsTo(User::class, 'id_medico', 'id_usuario');
    }
}
