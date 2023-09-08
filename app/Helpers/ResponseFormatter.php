<?php

namespace App\Helpers;

 /**
 * @OA\Schema(
 *   schema="responseFormatter",
 *   type="object",
 *   @OA\Property(
 *     property="meta",
 *     type="object",
 *     @OA\Property(property="code", type="integer"),
 *     @OA\Property(property="status", type="string"),
 *     @OA\Property(property="message", type="string")
 *   ),
 *   @OA\Property(property="data", type="object", default=null)
 * ),
 * @OA\Schema(
 *   schema="datatableResponseFormatter",
 *   type="object",
 *   @OA\Property(property="draw", type="integer"),
 *   @OA\Property(property="recordsTotal", type="integer"),
 *   @OA\Property(property="recordsFiltered", type="integer"),
 *   @OA\Property(
 *     property="data",
 *     type="array",
 *     default={},
 *     @OA\Items(type="object")
 *   ),
 *   @OA\Property(
 *     property="queries",
 *     type="array",
 *     default={},
 *     @OA\Items(type="object")
 *   ),
 *   @OA\Property(
 *     property="input",
 *     type="array",
 *     default={},
 *     @OA\Items(type="object")
 *   )
 * ),
 * @OA\Response(
 *   response="globalResponse",
 *   description="OK",
 *   @OA\JsonContent(ref="#/components/schemas/responseFormatter")
 * ),
 * @OA\Response(
 *   response="datatableGlobalResponse",
 *   description="OK",
 *   @OA\JsonContent(ref="#/components/schemas/datatableResponseFormatter")
 * )
 */
class ResponseFormatter
{
    protected static $response = [
        'meta' => [
            'code' => 200,
            'status' => 'success',
            'message' => null,
        ],
        'data' => null,
    ];

    public static function success($data = null, $message = null)
    {
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);
    }

    public static function error($data = null, $message = null, $code = 400)
    {
        self::$response['meta']['status'] = 'error';
        self::$response['meta']['code'] = $code;
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);
    }
}
