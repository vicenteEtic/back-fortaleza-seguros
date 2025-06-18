<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pep extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'pep';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name'
    ];
}
