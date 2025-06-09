<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class productEror extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_erors';

    protected $guarded = ['id'];

    protected $hidden = [
        'deleted_at',

 ];


 public function entity()
 {
     return $this->belongsTo(Entity::class, 'fk_entities');
 }
 public function product_risks()
 {
     return $this->hasMany(  productEror::class, 'fk_type_assessment');
 }

 public function beneficialOwners()
 {
     return $this->hasMany(  BeneficialOwnerError::class, 'fk_type_assessment');
 }

public function user()
{
  return $this->belongsTo(User::class, 'fk_user');
}
}
