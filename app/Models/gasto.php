<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;



class gasto extends Model
{
    use HasApiTokens, HasFactory, Notifiable; //HasApiTokens, Notifiable son agregadas

    protected $table = 'gastos'; 
    public $timestamps= false;
    
    protected $fillable = [
        'numeroHabitacion',
        'numeroAsientos',
        'pelicula',
        'cine_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function categorias()
    {
        return $this->belongsTo(categoria::class, 'cine_id');
    }
}
