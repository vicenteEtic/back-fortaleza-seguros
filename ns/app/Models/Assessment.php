<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assessment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'type_assessments';

    protected $guarded = ['id'];

    protected $hidden = [
        'deleted_at',

    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'pep' => 'boolean', // Define o cast para o atributo isAnonymous
    ];

    public function entity()
    {
        return $this->belongsTo(Entity::class, 'fk_entities');
    }
    public function product_risks()
    {
        return $this->hasMany(ProductRisk::class, 'fk_type_assessment');
    }

    public function beneficialOwners()
    {
        return $this->hasMany(BeneficialOwner::class, 'fk_type_assessment');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'fk_user');
    }
}
