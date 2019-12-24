<?php


namespace App\Filters\MedicalService;


use App\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class DescriptionFilter implements FilterInterface
{

    public function filter(Builder $builder, $value)
    {
        return $builder->where('description', 'like', '%'.$value.'%');
    }
}
