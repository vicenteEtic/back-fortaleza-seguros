<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRisk extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'product_risk';
    protected $primaryKey = 'id';
    protected $fillable = [
        'product_id',
        'risk_assessment_id',
        'score'
    ];
}
