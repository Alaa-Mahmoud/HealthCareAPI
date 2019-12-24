<?php


namespace App\Filters\MedicalService;


use App\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class TypeFilter implements FilterInterface
{

    public function filter(Builder $builder, $value)
    {
        // Another implementation if we want to filter by medical service type name instead of id
        //return $builder->whereHas('medicalServiceType' , function(Builder $builder) use ($value) {
         //  $builder->where('name', $value);
        //});
        return $builder->where('medical_service_type_id', $value);
    }
}
