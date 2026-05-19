<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antecedente extends Model
{
    use HasFactory;

    protected $table = 'antecedentes';
    protected $primaryKey = 'id_antecedente';

    protected $fillable = [
        'id_historia',
        'tipo_antecedente',
        'descripcion',
        'fecha_diagnostico',
    ];

    public function historiaMedica()
    {
        return $this->belongsTo(HistoriaMedica::class, 'id_historia', 'id_historia');
    }

    public function alergias()
    {
        return $this->belongsToMany(Alergia::class, 'antecedente_alergia', 'id_antecedente', 'id_alergia')
            ->withPivot('severidad')
            ->withTimestamps();
    }
}
