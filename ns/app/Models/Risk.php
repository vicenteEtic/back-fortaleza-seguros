<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Risk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ricks';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'fk_role',
        'fk_type_deligencia'
    ];

    public function diligence()
    {
        return $this->belongsTo(Diligence::class, 'fk_type_deligencia');
    }
}
