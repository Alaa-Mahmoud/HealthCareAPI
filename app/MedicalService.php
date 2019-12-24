<?php

namespace App;

use App\Filters\MedicalService\MedicalServiceFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MedicalService extends Model
{
    protected $guarded = [];

    public function medicalServiceType()
    {
        return $this->belongsTo(MedicalServiceType::class);
    }

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class);
    }

    public function scopeFilter(Builder $builder , $request)
    {
        return (new MedicalServiceFilters($request))->filter($builder);
    }
}
