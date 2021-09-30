<?php
namespace App\Models;

use App\Base as Model;

class ParameterValue extends Model
{
    protected $table = 'parameter_values';

    protected $fillable = ['parameter_id'];

    public function translations()
    {
        return $this->hasMany(ParameterValueTranslation::class);
    }

    public function translation()
    {
        // $ret =  $this->hasOne(ParameterValueTranslation::class , 'parameter_value_id')->where('lang_id', self::$lang);
        // if (is_null($ret->first())) {
        //     $ret = $this->hasOne(ParameterValueTranslation::class , 'parameter_value_id');
        // }
        return $this->hasOne(ParameterValueTranslation::class , 'parameter_value_id');
    }

    public function transData()
    {
        return $this->hasOne(ParameterValueTranslation::class , 'parameter_value_id');
    }
}
