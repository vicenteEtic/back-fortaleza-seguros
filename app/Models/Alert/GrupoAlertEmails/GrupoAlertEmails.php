<?php

namespace App\Models\Alert\GrupoAlertEmails;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class GrupoAlertEmails extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'grupo_alert_emails';
    protected $primaryKey = 'id';
    protected $fillable = ['name','description'];
}

