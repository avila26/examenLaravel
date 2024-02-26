<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;           //Importamos
use Illuminate\Notifications\Notifiable;    //Importamos

class categoria extends Model
{
    use HasApiTokens, HasFactory, Notifiable; //HasApiTokens, Notifiable son agregadas

    protected $table = 'categorias'; 
    public $timestamps= false;
    
    protected $fillable = [
        'lugar',
        'nombre',
    ];
    
    public function gastos()
    {
        return $this->hasMany(Gasto::class);
    }
}
