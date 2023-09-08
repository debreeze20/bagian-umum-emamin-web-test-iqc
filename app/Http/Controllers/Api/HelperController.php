<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\AppVersionResource;
use App\Models\AppVersion;
use App\Models\UmkmFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class HelperController extends Controller
{
    /**
     * @OA\Get(
     *   tags={"Api|Helper"},
     *   path="/api/helper/show-file/{type}/{fileId}",
     *   summary="Helper show file",
     *   @OA\Parameter(
     *     name="type",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string", enum={"umkm-file"})
     *   ),
     *   @OA\Parameter(
     *     name="fileId",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     name="preview",
     *     in="query",
     *     @OA\Schema(type="boolean")
     *   ),
     *   @OA\Response(
     *     response="default",
     *     description="OK",
     *     @OA\MediaType(
     *       mediaType="application/pdf",
     *     ),
     *     @OA\MediaType(
     *       mediaType="image/png",
     *     ),
     *     @OA\MediaType(
     *       mediaType="image/jpeg",
     *     ),
     *     @OA\MediaType(
     *       mediaType="application/vnd.ms-excel",
     *     ),
     *     @OA\MediaType(
     *       mediaType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
     *     ),
     *     @OA\MediaType(
     *       mediaType="application/msword",
     *     ),
     *     @OA\MediaType(
     *       mediaType="application/vnd.openxmlformats-officedocument.wordprocessingml.document",
     *     ),
     *     @OA\MediaType(
     *       mediaType="application/vnd.ms-powerpoint",
     *     ),
     *     @OA\MediaType(
     *       mediaType="application/vnd.openxmlformats-officedocument.presentationml.presentation",
     *     ),
     *     @OA\JsonContent(ref="#/components/schemas/responseFormatter")
     *   )
     * )
     */
    public function showFile(Request $request, $type, $fileId)
    {
        $file = null;
        if ($type == 'umkm-file') {
            $file = UmkmFile::find($fileId);
        } else {
            return ResponseFormatter::error(null, 'Kategori file tidak diketahui', 404);
        }

        if (!empty($file)) {
            $path = storage_path('app/' . $file->path);

            if (File::exists($path)) {
                if (in_array($file->ext, ['pdf', 'png', 'jpg'])) {
                    if ($request->filled('preview')) {
                        if (filter_var($request->preview, FILTER_VALIDATE_BOOLEAN) == true) {
                            return response()->file($path);
                        } else {
                            return response()->download($path, $file->name);
                        }
                    } else {
                        return response()->download($path, $file->name);
                    }
                } else {
                    return response()->download($path, $file->name);
                }
            } else {
                return ResponseFormatter::error(null, 'File tidak ditemukan', 404);
            }
        } else {
            return ResponseFormatter::error(null, 'File tidak ditemukan', 404);
        }
    }

    /**
     * @OA\Get(
     *   tags={"Api|Helper"},
     *   path="/api/helper/latest-version/{type}",
     *   summary="Helper latest version",
     *   @OA\Parameter(
     *     name="type",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string", enum={"web", "android", "ios"})
     *   ),
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function latestVersion(Request $request)
    {
        $appVersion = AppVersion::where('app_type', $request->type)->orderBy('created_at', 'DESC')->first();

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
     * Load image by encrypted path (without authorization)
     * 
     * @param  string  $path
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function image($path)
    {
        try {
            if (Storage::exists($path = Crypt::decrypt($path, false))) {
                return response()->file(Storage::path($path));
            }
        } catch (\Throwable $th) {
            abort(404);
        }

        abort(404);
    }

}
