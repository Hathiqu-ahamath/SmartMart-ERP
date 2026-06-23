<?php
namespace App\Repositories;
use App\Models\Category;
class CategoryRepository extends BaseRepository
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }
    public function getActiveCategories()
    {
        return $this->model->active()->get();
    }
}
