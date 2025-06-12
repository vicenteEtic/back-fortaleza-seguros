<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserLog extends Model
{
    use HasFactory;
    protected $table = 'userlog';
    protected $primaryKey = 'id';
    protected $fillable = [''];
}