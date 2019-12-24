<?php

namespace App\Filters\MedicalService;

use App\Filters\FiltersAbstract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MedicalServiceFilters extends FiltersAbstract
{
    protected $filters = [
        'name' => NameFilter::class,
        'description' => DescriptionFilter::class,
        'type' => TypeFilter::class,
    ];

}
