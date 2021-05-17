<?php

namespace Modules\Core\Controller;

use Modules\Core\Exception\NotImplementedException;
use Modules\Core\Services\Base\BaseServiceInterface;
use Modules\Core\Traits\CustomResponseStructure;
use Modules\Core\Traits\RestApiActionMethods;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

abstract class BaseApiController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;
    use CustomResponseStructure;
    use RestApiActionMethods;

    /**
     * @param BaseServiceInterface $service
     * @param string $dtoClass
     * @throws NotImplementedException
     */
    public function __construct(BaseServiceInterface $service, string $dtoClass)
    {
        if (!isset($service)) {
            throw new NotImplementedException('You should inject service interface into your controller.');
        }

        $this->service = $service;
        $this->dtoClass = $dtoClass;
    }
}
