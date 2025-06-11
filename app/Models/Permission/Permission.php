<?php

namespace App\Models\Permission;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permission';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'description', 'is_active'];
}