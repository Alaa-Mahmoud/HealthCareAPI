<?php


namespace App\Filters\Invoice;


use App\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class PatientFilter implements FilterInterface
{

    public function filter(Builder $builder, $value)
    {
        $builder->where('user_id', $value);
    }
}
