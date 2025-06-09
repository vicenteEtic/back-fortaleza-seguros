<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    // public function getCreatedAtAttribute()
    // {
    //     $data = Carbon::parse($this->attributes['created_at'])->setTimezone("America/Sao_Paulo");

    //     return $data->toDateTimeString();
    // }

    // public function getUpdatedAtAttribute()
    // {
    //     $data = Carbon::parse($this->attributes['updated_at'])->setTimezone("America/Sao_Paulo");

    //     return $data->toDateTimeString();
    // }

    // public function getDeletedAtAttribute()
    // {
    //     if (isset($this->attributes['deleted_at'])) {
    //         $data = Carbon::parse($this->attributes['deleted_at'])->setTimezone("America/Sao_Paulo");

    //         return $data->toDateTimeString();
    //     }
    //     return $this->attributes['deleted_at'] ?? null;
    // }

    // public function setAttribute($key, $value)
    // {
    //     $forbiddenKeys = config()->get('constants.forbidden_keys');
    //     if (is_string($value) && !in_array($key, $forbiddenKeys)) {
    //         $value = mb_strtoupper($value, 'UTF-8');
    //     }

    //     return parent::setAttribute($key, $value);
    // }
    public function toArrayData()
    {
        $attributes = $this->toArray();
        return $attributes;
    }
}
