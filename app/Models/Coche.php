<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Coche extends Model
{
    use SoftDeletes; 

    protected $table = 'coche';
    
    protected $fillable = [
        'marca_id', 
        'modelo', 
        'informacion', 
        'potencia', 
        'precio', 
        'stock', 
        'fecha_fabricacion', 
        'imagen_path'
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'coche_usuario')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }
}