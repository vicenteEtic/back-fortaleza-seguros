<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndicatorType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'indicator_types';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'fk_indicator'

    ];
    public function indicator_type()
    {
        return $this->belongsTo(TypeEntity::class, 'fk_entities_type');
    }
}
