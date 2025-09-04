<?php

namespace App\Models\Alert\GrupoAlertEmails;

use App\Models\Alert\GrupoType\GrupoType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class GrupoAlertEmails extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'grupo_alert_emails';
    protected $primaryKey = 'id';
    protected $fillable = ['name','description'];
    public function grupoTypes()
    {
        return $this->hasMany(GrupoType::class, 'grup_alert_id');
    }
}

