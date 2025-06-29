<?php
namespace App\Repositories\Reports;
use App\Models\Report;
use App\Repositories\Eloquent\EloquentRepository;
use App\Repositories\Reports\ReportRepositoryInterface;

class ReportEloquentRepository extends EloquentRepository implements ReportRepositoryInterface
{
    /**
     * Implement abstract method and base model
     *
     * @return mixed | model
     */
    public function getModel()
    {
        return Report::class;
    }

    // Deploy special methods.
}