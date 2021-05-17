<?php

namespace Modules\Core\Traits;

use Modules\Core\DTO\Base\BaseDTO;
use Illuminate\Http\JsonResponse;

/**
 * Trait CustomResponseStructure.
 */
trait CustomResponseStructure
{
    /**
     * @param $data
     * @param int $statusCode
     * @param string|null $message
     * @param bool $isSuccess
     * @return JsonResponse
     */
    private function responseModel($data, int $statusCode, string $message = null, bool $isSuccess = true)
    {
        return response()->json([
            'is_success' => $isSuccess,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**It returns http response to the client with status code (200) and data
     * @param $data
     * @return JsonResponse
     */
    protected function ok($data)
    {
        return $this->responseModel($data, 200);
    }

    /**It returns http response to the client with status code (given) and error message
     * @param $data
     * @param int $statusCode
     * @param string|null $message
     * @return JsonResponse
     */
    protected function notOk($data, int $statusCode, string $message = null)
    {
        return $this->responseModel($data, $statusCode, $message);
    }

    /**It returns http response to the client with status code (201) and data
     * @param $data
     * @return JsonResponse
     */
    protected function created($data)
    {
        return $this->responseModel($data, 201, 'Created successfully');
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    protected function updated($data)
    {
        return $this->responseModel($data, 200, 'Updated successfully');
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    protected function deleted($data)
    {
        return $this->responseModel($data, 200, 'Deleted successfully');
    }

    /**It returns http response to the client with status code (412) and validation message
     * @param $data
     * @return JsonResponse
     */
    protected function notValidated($data)
    {
        return $this->responseModel($data, 412, 'Validation Error', false);
    }

    /**It returns http response to the client with status code (404) and not found message
     * @param $data
     * @return JsonResponse
     */
    protected function notFound($data)
    {
        return $this->responseModel($data, 404, 'Not found', false);
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    protected function badRequest($data)
    {
        return $this->responseModel($data, 400, 'Bad request', false);
    }

    /**if the model is valid
     * It returns http response to the client with status code (200) and data
     * else
     * It returns http response to the client with status code (412) and validation message
     * @param $data
     * @param BaseDTO $dtoForValidation
     * @return JsonResponse
     * @throws \Modules\Core\Exception\NotImplementedException
     */
    protected function okOrNotValidated($data, BaseDTO $dtoForValidation)
    {
        $validationResult = $dtoForValidation->validate($dtoForValidation->toModel(), false);
        if (!empty($validationResult) && count($validationResult) > 0) {
            return $this->notValidated($validationResult);
        }
        return $this->ok($data);
    }
}
