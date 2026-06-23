<?php
namespace App\Services;
use App\Repositories\SupplierRepository;
use Illuminate\Support\Str;
class SupplierService
{
    protected SupplierRepository $supplierRepository;
    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }
    public function getAllPaginated(int $perPage = 15)
    {
        return $this->supplierRepository->paginate($perPage);
    }
    public function findById(int $id)
    {
        return $this->supplierRepository->findById($id);
    }
    public function create(array $data)
    {
        $data['supplier_code'] = $data['supplier_code'] ?? 'SUP-' . strtoupper(Str::random(6));
        return $this->supplierRepository->create($data);
    }
    public function update(int $id, array $data)
    {
        return $this->supplierRepository->update($id, $data);
    }
    public function delete(int $id)
    {
        return $this->supplierRepository->delete($id);
    }
    public function getActiveSuppliers()
    {
        return $this->supplierRepository->getActiveSuppliers();
    }
}
