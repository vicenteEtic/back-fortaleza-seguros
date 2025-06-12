<?php

namespace App\Models\Log;

<<<<<<< HEAD
=======
use App\Models\User as ModelsUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> 88120df (feat: log de atividades)
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
<<<<<<< HEAD
    use HasFactory;
    protected $table = 'log';
    protected $primaryKey = 'id';
    protected $fillable = ['level', 'REMOTE_ADDR', 'PATH_INFO', 'USER_NAME', 'USER_ID', 'HTTP_USER_AGENT', 'message', 'id_document'];
=======
    use HasFactory, SoftDeletes;

    protected $table = 'user_logs';

    protected $guarded = ['id'];
     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo(ModelsUser::class, 'USER_ID', 'id');
    }

>>>>>>> 88120df (feat: log de atividades)
}
