<?php

namespace App\Models\Indicator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\SoftDeletes;

class Indicator extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'indicator';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'description', 'created_at', 'updated_at'];
}
=======

class Indicator extends Model
{
    use HasFactory;
    protected $table = 'indicator';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'description', 'created_at', 'updated_a2t'];
}
>>>>>>> da8c11683518d74384983f1f447719c1ab78d23b
