<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BeneficialOwnerError extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'beneficial_owner_errors';

    protected $guarded = ['id'];

    protected $hidden = [
        'deleted_at',

    ];

    protected $dates = ['deleted_at'];
}
