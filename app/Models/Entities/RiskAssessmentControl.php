<?php

namespace App\Models\Entities;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiskAssessmentControl extends Model
{
    use HasFactory;
    protected $table = 'risk_assessment_control';
    protected $primaryKey = 'id';
    protected $fillable = [
        'total_sucess',
        'user_id',
        'total_error',
        'total'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
