<?php

namespace App\Models\Indicator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\SoftDeletes;

class IndicatorType extends Model
{
    use HasFactory, SoftDeletes;
=======

class IndicatorType extends Model
{
    use HasFactory;
>>>>>>> da8c11683518d74384983f1f447719c1ab78d23b
    protected $table = 'indicator_type';
    protected $primaryKey = 'id';
    protected $fillable = [
        'description',
<<<<<<< HEAD
        'score',
=======
        'comment',
>>>>>>> da8c11683518d74384983f1f447719c1ab78d23b
        'risk',
        'indicator_id',
    ];

    public function indicator()
    {
        return $this->belongsTo(Indicator::class, 'indicator_id');
    }
}
