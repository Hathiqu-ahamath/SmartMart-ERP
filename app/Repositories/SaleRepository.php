<?php
namespace App\Repositories;
use App\Models\Sale;
class SaleRepository extends BaseRepository
{
    public function __construct(Sale $model)
    {
        parent::__construct($model);
    }
    public function getTodaySales()
    {
        return $this->model->today()->with('items')->get();
    }
    public function getMonthlySales()
    {
        return $this->model->thisMonth()->with('items')->get();
    }
    public function getSalesReport($startDate, $endDate)
    {
        return $this->model->whereBetween('created_at', [$startDate, $endDate])
            ->with('items')
            ->get();
    }
}
