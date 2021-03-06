<?php

namespace Modules\Todo\DTO\Todo;

use Modules\Core\DTO\Base\BaseDTO;

/**
 * Class TodoDTO
 */
class TodoDTO extends BaseDTO
{
    /**
     * TodoDTO constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        parent::__construct($parameters, self::class);
    }

    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $title;

    /**
     * @var string|null
     */
    public ?string $description;

    /**
     * @var bool
     */
    public bool $is_active;

    /**
     * @param $dto
     * @param array $originalData
     * @return TodoDTO
     */
    public function mapToDTO($dto, array $originalData): self
    {
        //you can make a change for each field on
        return $dto;
    }

    /**
     * @param array $parameters
     * @param bool $updateMode
     * @return array
     */
    public function validate(array $parameters, bool $updateMode)
    {
        return $this->validator($parameters, [
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);
    }
}
