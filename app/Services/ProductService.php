<?php
namespace App\Services;
use App\Repositories\ProductRepository;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
class ProductService
{
    protected ProductRepository $productRepository;
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function getAllPaginated(int $perPage = 15)
    {
        return $this->productRepository->paginate($perPage, ['*'], ['category']);
    }
    public function findById(int $id)
    {
        return $this->productRepository->findById($id, ['*'], ['category']);
    }
    public function create(array $data)
    {
        return $this->productRepository->create($data);
    }
    public function update(int $id, array $data)
    {
        return $this->productRepository->update($id, $data);
    }
    public function delete(int $id)
    {
        return $this->productRepository->delete($id);
    }
    public function search(string $query, int $perPage = 15)
    {
        return $this->productRepository->search($query, $perPage);
    }
    public function getLowStock()
    {
        return $this->productRepository->getLowStock();
    }
    public function getExpiringSoon(int $days = 30)
    {
        return $this->productRepository->getExpiringSoon($days);
    }
    public function adjustStock(int $productId, int $quantity, string $reason, int $userId)
    {
        return DB::transaction(function () use ($productId, $quantity, $reason, $userId) {
            $product = $this->productRepository->updateStock($productId, $quantity);
            StockMovement::create([
                'product_id' => $productId,
                'user_id' => $userId,
                'type' => 'adjustment',
                'quantity' => $quantity,
                'reference_type' => 'Adjustment',
                'notes' => $reason,
            ]);
            return $product;
        });
    }
}
