<?php

namespace App\Http\Controllers\ApiWeb;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderByUmkmResource;
use App\Http\Resources\OrderHistoryResource;
use App\Models\Order;
use App\Models\OrderHasUmkmProductTypeDetail;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HistoryController extends Controller
{
    /**
     * @OA\Get(
     *   tags={"ApiWeb|Transact|History"},
     *   path="/api-web/transact/history/{umkmId}",
     *   summary="History Submission index",
     *   @OA\Parameter(
     *     name="umkmId",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     name="search",
     *     in="query",
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     name="length",
     *     in="query",
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(
     *     name="sortBy",
     *     in="query",
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(
     *     name="orderBy",
     *     in="query",
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function historyOrder(Request $request, $umkmId)
    {
        $isUuid = Str::isUuid($umkmId);

        if (!$isUuid) {
            return ResponseFormatter::error(null, 'Format tidak sesuai', 404);
        }

        $umkm = Umkm::where('id_hash', $umkmId)->first();

        if (empty($umkm)) {
            return ResponseFormatter::error([
                'errors' => 'Data tidak ditemukan'
            ], 'Data tidak ditemukan', 404);
        }

        $length = $request->filled('length') ? $request->length : 10;
        $sortBy = $request->filled('sort_by') ? $request->sort_by : 'created_at';
        $orderBy = $request->filled('order_by') ? $request->order_by : 'DESC';

        $orders = Order::with(['order_has_umkms' => function ($a) use ($umkmId) {
            $a->with('order_has_umkm_product_types.product_type');
            $a->with('order_has_umkm_product_types.order_has_umkm_product_type_details');
            $a->whereHas('umkm', function ($c) use ($umkmId) {
                $c->where('id_hash', $umkmId);
            });
        }])->whereHas('order_has_umkms', function ($a) use ($umkmId) { 
            $a->whereHas('umkm', function ($c) use ($umkmId) {
                $c->where('id_hash', $umkmId);
            });
        });

        if ($request->filled('search')) {
            $orders = $orders->where(function ($query) use ($request) {
                $query->where(DB::raw('lower(name)'), 'like', '%' . Str::lower($request->search) . '%');
            });
        }

        $orders = $orders->orderBy($sortBy, $orderBy)->paginate($length);

        return OrderByUmkmResource::collection($orders)->additional([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data berhasil ditampilkan'
            ]
        ]);
    }

    /**
     * @Oa\Get(
     *   tags={"ApiWeb|Transact|History"},
     *   path="/api-web/transact/history/{umkmId}/submission/{submissionId}",
     *   summary="History detail by umkm",
     *   @OA\Parameter(
     *     name="umkmId",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @Oa\Parameter(
     *     name="submissionId",
     *     in="path",
     *     required=true,
     *     @Oa\Schema(type="string"),
     *   ),
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function historyOrderDetail($umkmId, $submissionId)
    {
        $isUuid = Str::isUuid($umkmId);
        $isUuid2 = Str::isUuid($submissionId);

        if (!$isUuid || !$isUuid2) {
            return ResponseFormatter::error(null, 'Format tidak sesuai', 404);
        }

        $umkm = Umkm::where('id_hash', $umkmId)->first();

        if (empty($umkm)) {
            return ResponseFormatter::error([
                'errors' => 'Data UMKM tidak ditemukan'
            ], 'Data tidak ditemukan', 404);
        }

        $order = Order::where('id_hash', $submissionId)->first();

        if (empty($order)) {
            return ResponseFormatter::error([
                'errors' => 'Data Pengajuan tidak ditemukan'
            ], 'Data tidak ditemukan', 404);
        }

        $orderDetail = Order::with([
            'order_method', 
            'account_code', 
            'files', 
            'order_has_umkms' => function ($query) use ($umkm) {
                $query->with(['umkm' => function ($c) use ($umkm) {
                    $c->where('id', $umkm->id);
                }]);
                $query->whereHas('umkm', function ($c) use ($umkm) {
                    $c->where('id', $umkm->id);
                });
                $query->with('order_has_umkm_product_types.product_type');
                $query->with('order_has_umkm_product_types.order_has_umkm_product_type_details.subdistrict');
            }
            ])->whereHas('order_has_umkms', function ($a) use ($umkm) { 
                $a->whereHas('umkm', function ($c) use ($umkm) {
                    $c->where('id', $umkm->id);
                });
            })->where('id', $order->id)->first();

        if (empty($orderDetail)) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
        }
        
        $orderDetail['umkm'] = $umkm;

        return (new OrderHistoryResource($orderDetail))->additional([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data berhasil ditampilkan'
            ],
        ]);
    }


    /**
     * @OA\Get(
     *   tags={"ApiWeb|Transact|History"},
     *   path="/api-web/transact/history/count/{umkmId}",
     *   summary="Get Order Count per UMKM",
     *   @OA\Parameter(
     *     name="umkmId",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function historyOrderCount($umkmId)
    {
        $isUuid = Str::isUuid($umkmId);

        if (!$isUuid) {
            return ResponseFormatter::error(null, 'Format tidak sesuai', 404);
        }

        $umkm = Umkm::where('id_hash', $umkmId)->first();

        if (empty($umkm)) {
            return ResponseFormatter::error([
                'errors' => 'Data tidak ditemukan'
            ], 'Data tidak ditemukan', 404);
        }

        $totalOmsetCount =  OrderHasUmkmProductTypeDetail::whereHas('order_has_umkm_product_type', function ($query) use ($umkm){
            $query->whereHas('order_has_umkm', function ($query2) use ($umkm) {
                $query2->where('umkm_id', $umkm->id);
            });
        })->get();

        $totalOrderCount = Order::whereHas('order_has_umkms', function ($q) use ($umkm) {
            $q->where('umkm_id', $umkm->id);
        })->count();

        $result = [];
        $result['count_order'] = $totalOrderCount;
        $result['count_omset'] = $totalOmsetCount->sum('total_price');
        $result['umkm'] = $umkm->name;

        return ResponseFormatter::success($result, 'Data berhasil ditampilkan', 200);
    }
}
