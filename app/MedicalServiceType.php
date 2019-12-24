<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalServiceType extends Model
{
    public function medicalServices()
    {
        return $this->hasMany(MedicalService::class);
    }
}
