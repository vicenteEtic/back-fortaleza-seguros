<?php

namespace App\Models\Alerta;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alerta extends Model
{
    use HasFactory;
    protected $table = 'alerta';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'level',
        'origin_id',
        'entity_id',
        'score'
    ];
}
