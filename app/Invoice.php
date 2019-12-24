<?php

namespace App;

use App\Filters\Invoice\InvoiceFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medicalServices()
    {
        return $this->belongsToMany(MedicalService::class);
    }

    public function scopeFilter(Builder $builder , $request)
    {
        return (new InvoiceFilters($request))->filter($builder);
    }
}
