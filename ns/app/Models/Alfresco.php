<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alfresco extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'alfrescos';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

}
