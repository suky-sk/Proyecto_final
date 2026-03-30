<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuario'; 
    
    protected $fillable = ['nombre', 'apellido', 'email', 'contrasena', 'telefono', 'direccion', 'es_admin', 'imagen_perfil_path'];

    protected $hidden = ['contrasena', 'remember_token'];

    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    public function coches()
    {
        return $this->belongsToMany(Coche::class, 'coche_usuario', 'usuario_id', 'coche_id')
                    ->withPivot('cantidad')
                    ->withTimestamps()
                    ->orderByPivot('created_at', 'desc'); 
    }
}