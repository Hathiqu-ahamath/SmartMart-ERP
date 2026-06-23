<?php
namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
abstract class BaseRepository
{
    protected Model $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    public function all(array $columns = ['*'], array $relations = [])
    {
        return $this->model->with($relations)->get($columns);
    }
    public function paginate(int $perPage = 15, array $columns = ['*'], array $relations = [])
    {
        return $this->model->with($relations)->paginate($perPage, $columns);
    }
    public function findById(int $id, array $columns = ['*'], array $relations = [])
    {
        return $this->model->with($relations)->findOrFail($id, $columns);
    }
    public function create(array $data)
    {
        return $this->model->create($data);
    }
    public function update(int $id, array $data)
    {
        $record = $this->findById($id);
        $record->update($data);
        return $record;
    }
    public function delete(int $id)
    {
        return $this->findById($id)->delete();
    }
}
