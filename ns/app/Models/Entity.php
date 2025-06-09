<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'entities';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'deleted_at',
        'fk_entities_type',
    ];


}
