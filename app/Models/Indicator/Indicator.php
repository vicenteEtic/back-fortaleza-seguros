<?php

namespace App\Models\Indicator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Indicator extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'indicator';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'description', 'created_at', 'updated_at'];

    public function indicatorType()
    {
        return $this->hasMany(IndicatorType::class, 'indicator_id');
    }
}
