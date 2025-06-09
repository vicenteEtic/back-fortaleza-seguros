<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRisk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_risks';

    protected $guarded = ['id'];

    protected $hidden = [
        'deleted_at',

 ];

}
