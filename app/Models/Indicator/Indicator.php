<?php

namespace App\Models\Indicator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Indicator extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'indicator';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'description', 'created_at', 'updated_a2t'];
}
