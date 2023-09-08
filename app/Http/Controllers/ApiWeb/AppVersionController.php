<?php

namespace App\Http\Controllers\ApiWeb;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\AppVersionResource;
use App\Models\AppVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AppVersionController extends Controller
{
    /**
     * @OA\Get(
     *   tags={"ApiWeb|Master|AppVersion"},
     *   path="/api-web/master/app-version",
     *   summary="AppVersion index",
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function index()
    {
        $appVersion = AppVersion::select([
            'app_versions.*',
            DB::raw("(CASE WHEN app_versions.app_type = 'web' THEN 'Web'
            WHEN app_versions.app_type = 'android' THEN 'Android'
            WHEN app_versions.app_type = 'ios' THEN 'IOS'
            ELSE null END) app_type_name")
        ])->get();

        return AppVersionResource::collection($appVersion)->additional([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data berhasil ditampilkan'
            ]
        ]);
    }

    /**
     * @OA\Get(
     *   tags={"ApiWeb|Master|AppVersion"},
     *   path="/api-web/master/app-version/{appVersionId}",
     *   summary="AppVersion show",
     *   @OA\Parameter(
     *     name="appVersionId",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function show($appVersionId)
    {
        $isUuid = Str::isUuid($appVersionId);

        if (!$isUuid) {
            return ResponseFormatter::error(null, 'Format tidak sesuai', 404);
        }

        $appVersion = AppVersion::where('id_hash', $appVersionId)->first();

        if (empty($appVersion)) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
        }

        return (new AppVersionResource($appVersion))->additional([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data berhasil ditampilkan'
            ],
        ]);
    }

    /**
     * @OA\Post(
     *   tags={"ApiWeb|Master|AppVersion"},
     *   path="/api-web/master/app-version",
     *   summary="AppVersion store",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       type="object",
     *       required={"code", "appType"},
     *       @OA\Property(property="code", type="string"),
     *       @OA\Property(property="isForceUpdate", type="boolean"),
     *       @OA\Property(property="description", type="string"),
     *       @OA\Property(property="appType", type="string", enum={"web", "android", "ios"})
     *     )
     *   ),
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        $rules = [
            'code' => 'required',
            'is_force_update' => 'nullable|boolean',
            'description' => 'nullable',
            'app_type' => 'required|in:web,android,ios'
        ];

        $messages = [];

        $attributes = [
            'code' => 'Kode versi',
            'is_force_update' => 'Wajib update',
            'description' => 'Deskripsi',
            'app_type' => 'Jenis aplikasi'
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            DB::rollBack();
            return ResponseFormatter::error([
                'errors' => $validator->errors()
            ], 'Silahkan isi form dengan benar terlebih dahulu', 422);
        }

        $appVersionExists = AppVersion::where(['code' => $request->code, 'app_type' => $request->app_type])->exists();

        if ($appVersionExists == true) {
            DB::rollBack();
            return ResponseFormatter::error(null, 'Kode versi sudah pernah ditambahkan untuk jenis aplikasi ini', 400);
        }

        $appVersion = new AppVersion();
        $appVersion->code = $request->code;
        $appVersion->is_force_update = $request->is_force_update;
        $appVersion->description = $request->description;
        $appVersion->app_type = $request->app_type;
        $appVersion->save();

        DB::commit();
        return ResponseFormatter::success(null, 'Data berhasil disimpan');
    }

    /**
     * @OA\Put(
     *   tags={"ApiWeb|Master|AppVersion"},
     *   path="/api-web/master/app-version/{appVersionId}",
     *   summary="AppVersion update",
     *   @OA\Parameter(
     *     name="appVersionId",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       type="object",
     *       required={"code", "appType"},
     *       @OA\Property(property="code", type="string"),
     *       @OA\Property(property="isForceUpdate", type="boolean"),
     *       @OA\Property(property="description", type="string"),
     *       @OA\Property(property="appType", type="string", enum={"web", "android", "ios"})
     *     )
     *   ),
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function update(Request $request, $appVersionId)
    {
        DB::beginTransaction();

        $rules = [
            'code' => 'required',
            'is_force_update' => 'nullable|boolean',
            'description' => 'nullable',
            'app_type' => 'required|in:web,android,ios'
        ];

        $messages = [];

        $attributes = [
            'code' => 'Kode versi',
            'is_force_update' => 'Wajib update',
            'description' => 'Deskripsi',
            'app_type' => 'Jenis aplikasi'
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            DB::rollBack();
            return ResponseFormatter::error([
                'errors' => $validator->errors()
            ], 'Silahkan isi form dengan benar terlebih dahulu', 422);
        }

        $isUuid = Str::isUuid($appVersionId);

        if (!$isUuid) {
            DB::rollBack();
            return ResponseFormatter::error(null, 'Format tidak sesuai', 404);
        }

        $appVersion = AppVersion::where('id_hash', $appVersionId)->first();

        if (!empty($appVersion)) {
            $appVersionExists = AppVersion::where(['code' => $request->code, 'app_type' => $request->app_type])
                ->where('id_hash', '!=', $appVersionId)->exists();

            if ($appVersionExists == true) {
                DB::rollBack();
                return ResponseFormatter::error(null, 'Kode versi sudah pernah ditambahkan untuk jenis aplikasi ini', 400);
            }

            $appVersion->code = $request->code;
            $appVersion->is_force_update = $request->is_force_update;
            $appVersion->description = $request->description;
            $appVersion->app_type = $request->app_type;
            $appVersion->save();

            DB::commit();
            return ResponseFormatter::success(null, 'Data berhasil diedit');
        } else {
            DB::rollBack();
            return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
        }
    }

    /**
     * @OA\Delete(
     *   tags={"ApiWeb|Master|AppVersion"},
     *   path="/api-web/master/app-version/{appVersionId}",
     *   summary="AppVersion destroy",
     *   @OA\Parameter(
     *     name="appVersionId",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function destroy($appVersionId)
    {
        DB::beginTransaction();

        $isUuid = Str::isUuid($appVersionId);

        if (!$isUuid) {
            DB::rollBack();
            return ResponseFormatter::error(null, 'Format tidak sesuai', 404);
        }

        $appVersion = AppVersion::where('id_hash', $appVersionId)->first();

        if (empty($appVersion)) {
            DB::rollBack();
            return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
        }

        $appVersion->delete();

        DB::commit();
        return ResponseFormatter::success(null, 'Data berhasil dihapus');
    }
}
