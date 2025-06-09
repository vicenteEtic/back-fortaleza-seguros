<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CraftHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'craft_histories';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];


    protected $hidden = [

        'updated_at',
        'deleted_at',
        'email_verified_at'

    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
