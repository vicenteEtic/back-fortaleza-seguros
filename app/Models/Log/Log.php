<?php

namespace App\Models\Log;

use App\Models\User;
use Dom\Entity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;
    protected $table = 'log';
    protected $primaryKey = 'id';
    protected $fillable = ['level', 'REMOTE_ADDR', 'PATH_INFO', 'USER_NAME', 'USER_ID', 'HTTP_USER_AGENT', 'message', 'id_document'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function entity()
    {
        return $this->belongsTo(Entity::class, 'id_entity');
    }
}
