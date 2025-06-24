<?php

namespace App\Models\Alert;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alert extends Model
{
    use HasFactory;
    protected $table = 'alert';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'level', 'origin_id', 'entity_id', 'score'];
}