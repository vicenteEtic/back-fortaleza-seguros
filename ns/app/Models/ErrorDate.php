<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ErrorDate extends Model
{

    use HasFactory, SoftDeletes;

    protected $table = 'error_dates';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];
    public $timestamps = true;
    protected $hidden = [
        'updated_at',
        'deleted_at',
        'description',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'fk_user');
    }

}
