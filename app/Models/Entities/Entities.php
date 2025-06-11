<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entities extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'entities';
    protected $primaryKey = 'id';
    protected $fillable = ['social_denomination', 'policy_number', 'customer_number', 'entity_type', 'color', 'risk_level', 'diligence', 'last_evaluation', 'deleted_at', 'created_at', 'updated_at'];
}
