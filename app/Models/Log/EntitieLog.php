<?php


namespace App\Models\Log;

use App\Models\Entities\Entities;
use Dom\Entity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;

class EntitieLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'entitie_log';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'updated_at',
        'deleted_at',
        "fk_entities",
		"fk_user",
 ];

 public function entitie()
 {
     return $this->belongsTo(Entities::class, 'fk_entities');
 }

 public function user()
 {
     return $this->belongsTo(User::class, 'fk_user');
 }
}
