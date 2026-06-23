<?php
namespace App\Repositories;
use App\Models\PurchaseOrder;
class PurchaseOrderRepository extends BaseRepository
{
    public function __construct(PurchaseOrder $model)
    {
        parent::__construct($model);
    }
    public function getPendingOrders()
    {
        return $this->model->pending()->with(['supplier', 'user'])->get();
    }
    public function getApprovedOrders()
    {
        return $this->model->approved()->with(['supplier', 'items.product'])->get();
    }
}
