<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 2019/1/29
 * Time: 4:31 PM
 */

namespace App\Responses;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection as ModelCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use function is_array;

trait ResponseTrait
{
    /**
     * @param array|Arrayable $data
     * @return JsonResponse
     */
    protected function jsonResponse($data)
    {
        $data = is_array($data) ? $data : $data->toArray();
        return response()->json($data);
    }

    /**
     * @param bool $result
     * @param array|ModelCollection|string $dataOrMessages
     * @return JsonResponse
     */
    protected function queryJsonResponse(bool $result, $dataOrMessages): JsonResponse
    {
        if ($dataOrMessages instanceof ModelCollection || $dataOrMessages instanceof Collection) {
            $dataOrMessages = $dataOrMessages->toArray();
        }

        /** data 或 messages 一定會是 array|string */
        $columnName = $result ? "data" : "messages";

        return response()->json([
            "result" => $result,
            $columnName => $dataOrMessages
        ]);
    }

    /**
     * @param LengthAwarePaginator $paginator
     * @return \Illuminate\Http\JsonResponse
     */
    protected function paginateResponse($paginator)
    {
        return $this->jsonResponse([
            "list" => $paginator->items(),
            "total" => $paginator->total(),
            "page" => $paginator->currentPage(),
            "lastPage" => $paginator->lastPage()
        ]);
    }
}
