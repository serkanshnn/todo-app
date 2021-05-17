<?php

namespace Modules\Core\Services\Base;

use Modules\Core\DTO\Base\BaseDTO;
use Modules\Core\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Support\Collection;

class BaseService implements BaseServiceInterface
{
    /**
     * @var BaseRepositoryInterface
     */
    private BaseRepositoryInterface $baseRepository;

    private $dtoType;

    public $auth_user_id;

    /**
     * BaseService constructor.
     * @param BaseRepositoryInterface $baseRepository
     */
    public function __construct(BaseRepositoryInterface $baseRepository, $dtoType)
    {
        $this->dtoType = $dtoType;
        $this->baseRepository = $baseRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function create(BaseDTO $dto): BaseDTO
    {
        $result = $this->baseRepository->create($dto->toModel());

        return new $this->dtoType($result->toArray());
    }

    /**
     * {@inheritdoc}
     */
    public function createWithFilters(array $filters, BaseDTO $dto): BaseDTO
    {
        $result = $this->baseRepository->createWithFilters($filters, $dto->toModel());

        return new $this->dtoType($result->toArray());
    }

    /**
     * {@inheritdoc}
     */
    public function update(int $id, BaseDTO $dto): bool
    {
        return $this->baseRepository->update($id, $dto->toModel());
    }

    /**
     * {@inheritdoc}
     */
    public function updateWithFilter(array $filters, BaseDTO $dto): bool
    {
        return $this->baseRepository->updateWithFilters($filters, $dto->toModel());
    }

    /**
     * {@inheritdoc}
     */
    public function all($columns = ['*'], string $orderBy = 'id', string $sortBy = 'asc'): array
    {
        return $this->baseRepository->all($columns, $orderBy, $sortBy)->toListDTO($this->dtoType);
    }

    /**
     * {@inheritdoc}
     */
    public function allWithFilter($columns, string $orderBy, string $sortBy, array $filters): array
    {
        return $this->baseRepository->allWithFilter($columns, $orderBy, $sortBy, $filters)->toListDTO($this->dtoType);
    }

    /**
     * {@inheritdoc}
     */
    public function find($id): ?BaseDTO
    {
        $result = $this->baseRepository->find($id);

        return new $this->dtoType($result->toArray());
    }

    /**
     * {@inheritdoc}
     */
    public function findWithFilter(array $filters): BaseDTO
    {
        $result = $this->baseRepository->findWithFilter($filters);
        if (isset($result)) {
            return new $this->dtoType($result->toArray());
        }else {
            return new BaseDTO();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete(int $id): bool
    {
        return $this->baseRepository->delete($id);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteWithFilter(array $filters): bool
    {
        return $this->baseRepository->deleteWithFilter($filters);
    }

    /**
     * @inheritDoc
     */
    public function setAuthUserId(int $user_id)
    {
        $this->auth_user_id = $user_id;
        $this->baseRepository->setAuthUserId($user_id);
    }

    /**
     * @inheritDoc
     */
    public function findOrFail($id): BaseDTO
    {
        $result = $this->baseRepository->findOrFail($id);

        return new $this->dtoType($result->toArray());
    }

    /**
     * @inheritDoc
     */
    public function findBy(array $data) : array
    {
        $result = $this->baseRepository->findBy($data);

        return $result->toListDTO($this->dtoType);
    }

    /**
     * @inheritDoc
     */
    public function first(array $data): ?BaseDTO
    {
        $result = $this->baseRepository->first($data);

        return new $this->dtoType($result->toArray());
    }

    /**
     * @inheritDoc
     */
    public function firstOrFail(array $data): BaseDTO
    {
        $result = $this->baseRepository->firstOrFail($data);

        return new $this->dtoType($result->toArray());
    }
}
