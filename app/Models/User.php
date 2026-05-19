<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'especialidad',
        'cedula',
        'email',
        'password',
        'name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Accessor for virtual "id" attribute to maintain compatibility with Breeze tests.
     */
    public function getIdAttribute()
    {
        return $this->attributes['id_usuario'] ?? null;
    }

    /**
     * Accessor for virtual "name" attribute.
     * Returns the first name ("nombre") to keep compatibility with Breeze tests.
     */
    public function getNameAttribute(): ?string
    {
        return $this->attributes['nombre'] ?? null;
    }

    /**
     * Mutator for virtual "name" attribute.
     * When the test sets "name", we store it in the "nombre" column.
     */
    public function setNameAttribute($value): void
    {
        $this->attributes['nombre'] = $value;
    }

    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'id_usuario_creador', 'id_usuario');
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'id_medico', 'id_usuario');
    }
}