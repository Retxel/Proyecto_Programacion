<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alergia extends Model
{
    use HasFactory;

    protected $table = 'alergias';
    protected $primaryKey = 'id_alergia';

    protected $fillable = [
        'sustancia',
        'categoria',
    ];

    public function antecedentes()
    {
        return $this->belongsToMany(Antecedente::class, 'antecedente_alergia', 'id_alergia', 'id_antecedente')
            ->withPivot('severidad')
            ->withTimestamps();
    }
}
