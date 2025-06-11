<?php


namespace App\Models\Log;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;

class Log extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'logs';

    protected $guarded = ['id'];
     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo(User::class, 'USER_ID', 'id');
    }

}
