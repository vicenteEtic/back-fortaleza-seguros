<?php

namespace App\Models\Entities;

use App\Enum\FormEstablishment;
use App\Enum\StatusResidence;
use App\Models\Indicator\IndicatorType;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiskAssessment extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'risk_assessment';
    protected $primaryKey = 'id';
    protected $fillable = [
        'identification_capacity',
        'form_establishment',
        'category',
        'status_residence',
        'profession',
        'pep',
        'country_residence',
        'nationality',
        'entity_id',
        'channel',
        'score',
        'user_id'
    ];


    public $casts = [
        'form_establishment' => FormEstablishment::class,
        'status_residence' =>  StatusResidence::class
    ];
    public function entity()
    {
        return $this->belongsTo(Entities::class, 'entity_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function  profession()
    {
        return $this->belongsTo(IndicatorType::class, 'profession');
    }

    public function indetificationCapacity()
    {
        return $this->belongsTo(IndicatorType::class, 'identification_capacity');
    }

    public function channel()
    {
        return $this->belongsTo(IndicatorType::class, 'channel');
    }

    public function countryResidence()
    {
        return $this->belongsTo(IndicatorType::class, 'country_residence');
    }

    public function category()
    {
        return $this->belongsTo(IndicatorType::class, 'category');
    }

    public function nationlity()
    {
        return $this->belongsTo(IndicatorType::class, 'nationality');
    }

    public function productRisk()
    {
        return $this->belongsToMany(productRisk::class, 'product_risk', 'risk_assessment_id');
    }
}
