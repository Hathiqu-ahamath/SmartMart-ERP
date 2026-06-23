<?php
namespace App\Repositories;
use App\Models\Product;
class ProductRepository extends BaseRepository
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }
    public function search(string $query, int $perPage = 15)
    {
        return $this->model->where('product_name', 'like', "%{$query}%")
            ->orWhere('product_code', 'like', "%{$query}%")
            ->orWhere('barcode', 'like', "%{$query}%")
            ->paginate($perPage);
    }
    public function getLowStock()
    {
        return $this->model->lowStock()->get();
    }
    public function getExpiringSoon(int $days = 30)
    {
        return $this->model->expiringSoon($days)->get();
    }
    public function updateStock(int $id, int $quantity)
    {
        $product = $this->findById($id);
        $product->increment('quantity', $quantity);
        return $product->fresh();
    }
}
