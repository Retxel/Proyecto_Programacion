<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriaMedica extends Model
{
    use HasFactory;

    protected $table = 'historias_medicas';
    protected $primaryKey = 'id_historia';

    protected $fillable = [
        'id_paciente',
        'numero_expediente',
        'tipo_sangre',
        'factor_rh',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente', 'id_paciente');
    }

    public function antecedentes()
    {
        return $this->hasMany(Antecedente::class, 'id_historia', 'id_historia');
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'id_historia', 'id_historia');
    }
}
