<?php

namespace Modules\Core\Repositories\Base;

use Modules\Core\Exception\NotFoundException;
use Modules\Core\Exception\NotImplementedException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseEloquentRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**Authenticated current user id
     * @var int
     */
    protected int $auth_user_id;

    /**
     * BaseRepository constructor.
     * @param $model
     * @throws NotImplementedException
     */
    public function __construct($model)
    {
        if (empty($model)) {
            throw new NotImplementedException('You should specify Model class into your Repository class.');
        }
        $this->model = $model;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $attributes): Model
    {
        return $this->model::create($attributes);
    }

    /**
     * {@inheritdoc}
     */
    public function createWithFilters(array $filters, array $data): Model
    {
        throw new NotImplementedException('You should implement createWithFilters method in your Repository class.');
    }

    /**
     * {@inheritdoc}
     */
    public function update(int $id, array $data): bool
    {
        $model = $this->findOrFail($id);
        return $this->checkAndUpdate($data, $model);
    }

    /**
     * {@inheritdoc}
     */
    public function updateWith(array $data): bool
    {
        return $this->model::update($data);
    }

    /**
     * {@inheritdoc}
     */
    public function updateWithFilters(array $filters, array $data): bool
    {
        $model = $this->findWithFilter($filters);
        return $this->checkAndUpdate($data, $model);
    }

    /**
     * {@inheritdoc}
     */
    public function updateWhere(string $column, string $columnValue, array $data): bool
    {
        $model = $this->model::where($column, $columnValue);
        return $this->checkAndUpdate($data, $model);
    }

    /**
     * {@inheritdoc}
     */
    public function all($columns = ['*'], string $orderBy = 'id', string $sortBy = 'asc'): Collection
    {
        return $this->model::orderBy($orderBy, $sortBy)->get($columns);
    }

    /**
     * {@inheritdoc}
     */
    public function allWithFilter($columns, string $orderBy, string $sortBy, array $filters): Collection
    {
        throw new NotImplementedException('You should implement allWithFilter method in your Repository class.');
    }

    /**
     * {@inheritdoc}
     */
    public function where(string $column, string $columnValue): Collection
    {
        return $this->model::where($column, $columnValue)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function whereQuery($column, $operator = null, $value = null): Builder
    {
        return $this->model::where($column, $operator, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function find($id): ?Model
    {
        $result = $this->model::find($id);
        if (empty($result)) {
            throw new NotFoundException('model');
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function findWithFilter(array $filters)
    {
        throw new NotImplementedException('You should implement findWithFilter method in your Repository class.');
    }

    /**
     * {@inheritdoc}
     */
    public function findOrFail($id): Model
    {
        return $this->model::findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findBy(array $data): ?Collection
    {
        return $this->model::where($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function findById(int $id): ?Model
    {
        return $this->model::where('id', '=', $id)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function first(array $data): ?Model
    {
        return $this->model::where($data)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function firstOrFail(array $data): Model
    {
        return $this->model::where($data)->firstOrFail();
    }

    /**
     * {@inheritdoc}
     */
    public function delete(int $id): bool
    {
        $model = $this->findOrFail($id);

        return $model->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function deleteWithFilter(array $filters): bool
    {
        $model = $this->findWithFilter($filters);
        if (empty($model)) {
            throw new NotFoundException('model');
        }
        return $model->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function deleteWhere(string $column, string $columnValue): bool
    {
        return $this->model::where($column, '=', $columnValue)->delete();
    }

    /**
     * @inheritDoc
     */
    public function setAuthUserId(int $user_id)
    {
        $this->auth_user_id = $user_id;
    }

    /**
     * @param array $data
     * @param $model
     * @return mixed
     * @throws NotFoundException
     */
    protected function checkAndUpdate(array $data, $model)
    {
        if (isset($model)) {
            return $model->update($data);
        }
        throw new NotFoundException('model');
    }
}
