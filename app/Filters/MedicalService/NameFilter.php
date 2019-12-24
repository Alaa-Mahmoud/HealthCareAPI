<?php


namespace App\Filters\MedicalService;



use App\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class NameFilter implements FilterInterface
{

    public function filter(Builder $builder , $value)
    {
        $builder->where('name', 'like' , '%'.$value.'%');
    }

}
