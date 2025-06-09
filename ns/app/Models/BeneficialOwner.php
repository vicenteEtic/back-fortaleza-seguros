<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BeneficialOwner extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'beneficial_owners';

    protected $guarded = ['id'];

    protected $hidden = [
        'deleted_at',

    ];

    protected $dates = ['deleted_at'];
}
