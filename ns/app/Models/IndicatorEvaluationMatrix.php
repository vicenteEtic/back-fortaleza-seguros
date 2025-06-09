<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndicatorEvaluationMatrix extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'indicator_evaluation_matrices';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'description',
    ];

}
