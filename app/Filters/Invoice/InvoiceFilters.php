<?php


namespace App\Filters\Invoice;


use App\Filters\FiltersAbstract;
use App\Filters\Invoice\PatientFilter;

class InvoiceFilters extends FiltersAbstract
{
    protected $filters = [
      'patient' => PatientFilter::class,
    ];
}
