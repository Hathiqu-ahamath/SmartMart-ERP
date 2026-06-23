<?php
namespace App\Services;
use App\Repositories\CategoryRepository;
class CategoryService
{
    protected CategoryRepository $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function getAll()
    {
        return $this->categoryRepository->all(['*'], ['products']);
    }
    public function getActiveCategories()
    {
        return $this->categoryRepository->getActiveCategories();
    }
    public function findById(int $id)
    {
        return $this->categoryRepository->findById($id);
    }
    public function create(array $data)
    {
        $data['slug'] = str($data['name'])->slug();
        return $this->categoryRepository->create($data);
    }
    public function update(int $id, array $data)
    {
        if (isset($data['name'])) {
            $data['slug'] = str($data['name'])->slug();
        }
        return $this->categoryRepository->update($id, $data);
    }
    public function delete(int $id)
    {
        return $this->categoryRepository->delete($id);
    }
}
