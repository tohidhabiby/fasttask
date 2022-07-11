<?php

namespace App\Http\Controllers;

use Habibi\Interfaces\FiltersInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    const EXCEPTION_MESSAGE = 'message';
    const DEFAULT_PAGE_SIZE = 10;
    const PER_PAGE = 'per_page';
    const STATUS = 'status';
    const MODEL = 'model';
    const MESSAGE = 'message';


    /**
     * @param FiltersInterface $filters FiltersInterface.
     * @param Model            $model   Model.
     *
     * @return array[]
     */
    protected function getAdditionals(FiltersInterface $filters, Model $model): array
    {
        return [
            'meta' => [
                'exportColumns' => $model->exportColumns(),
                'filters' => $filters->attributes,
                'orderByColumns' => $filters->orderByColumns,
            ]
        ];
    }

    /**
     * @param Request $request BaseRequest.
     *
     * @return mixed
     */
    protected function getPageSize(Request $request): mixed
    {
        $pageSize = self::DEFAULT_PAGE_SIZE;
        if ($request->has(self::PER_PAGE) && !empty($request->get(self::PER_PAGE))) {
            $pageSize = (int)$request->get(self::PER_PAGE);
        }
        return $pageSize;
    }

    /**
     * @param array|null $content    Content.
     * @param integer    $statusCode Status Code.
     * @param array|null $heathers   Headers.
     *
     * @return JsonResponse
     */
    protected function getResponse(
        ?array $content = null,
        int $statusCode = Response::HTTP_OK,
        ?array $heathers = []
    ): JsonResponse {
        if (
            isset($content[self::EXCEPTION_MESSAGE]) &&
            !in_array(env('APP_ENV'), ['local', 'development', 'testing'])
        ) {
            unset($content[self::EXCEPTION_MESSAGE]);
        }

        return response()->json(['data' => $content], $statusCode, $heathers);
    }

    /**
     * @param array $response Response.
     *
     * @return JsonResponse
     */
    public function sendResponse(array $response): JsonResponse
    {
        $status = $response[self::STATUS];
        unset($response[self::STATUS]);

        return $this->getResponse($response, $status);
    }

    /**
     * @param array  $response Response.
     * @param string $index    Index.
     *
     * @return JsonResponse
     */
    protected function fixResponse(array $response, string $index): JsonResponse
    {
        if (isset($response['IsSuccessful']) && $response['IsSuccessful']) {
            return $this->getResponse($response[$index]);
        }

        return $this->getResponse(
            [self::MESSAGE => $response['ErrorDescription']],
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @param mixed        $response     Response.
     * @param string|null  $resourceName Resource Name.
     * @param boolean|null $isCollection Is Collection.
     *
     * @return JsonResponse|JsonResource
     */
    protected function processResponse(
        mixed $response,
        ?string $resourceName = null,
        ?bool $isCollection = false
    ): JsonResponse|JsonResource {
        if (isset($response[self::STATUS])) {
            return $this->sendResponse($response);
        }
        if ($resourceName) {
            if ($isCollection) {
                return $resourceName::collection($response);
            }

            return new $resourceName($response);
        }

        return $this->getResponse($response);
    }
}
