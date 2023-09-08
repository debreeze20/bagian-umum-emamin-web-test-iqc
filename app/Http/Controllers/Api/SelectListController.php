<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccountCodeResource;
use App\Http\Resources\ProductTypeResource;
use App\Http\Resources\OrderMethodResource;
use App\Http\Resources\SubdistrictResource;
use App\Http\Resources\SelectUmkmResource;
use App\Models\AccountCode;
use App\Models\OrderMethod;
use App\Models\ProductType;
use App\Models\Subdistrict;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SelectListController extends Controller
{
    /**
     * @OA\Get(
     *   tags={"Api|SelectList"},
     *   path="/api/select-list/order-method",
     *   summary="SelectList order method",
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
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function orderMethod(Request $request)
    {
        $length = $request->filled('length') ? $request->length : 10;

        $order_method = OrderMethod::where('is_active', true);

        if ($request->filled('search')) {
            $order_method = $order_method->where(function ($query) use ($request) {
                $query->where(DB::raw('lower(name)'), 'like', '%' . Str::lower($request->search) . '%');
            });
        }

        $order_method = $order_method->limit($length)->get();

        return OrderMethodResource::collection($order_method)->additional([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data berhasil ditampilkan'
            ]
        ]);
    }

    /**
     * @OA\Get(
     *   tags={"Api|SelectList"},
     *   path="/api/select-list/product-type",
     *   summary="SelectList Product Type",
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
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function productType(Request $request)
    {
        $length = $request->filled('length') ? $request->length : 10;

        $product_type = ProductType::where('is_active', true);

        if ($request->filled('search')) {
            $product_type = $product_type->where(function ($query) use ($request) {
                $query->where(DB::raw('lower(name)'), 'like', '%' . Str::lower($request->search) . '%');
            });
        }

        $product_type = $product_type->limit($length)->get();

        return ProductTypeResource::collection($product_type)->additional([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data berhasil ditampilkan'
            ]
        ]);
    }

    /**
     * @OA\Get(
     *   tags={"Api|SelectList"},
     *   path="/api/select-list/account-code",
     *   summary="SelectList Account Code",
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
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function accountCode(Request $request)
    {
        $length = $request->filled('length') ? $request->length : 10;

        $account_code = AccountCode::where('is_active', true);

        if ($request->filled('search')) {
            $account_code = $account_code->where(function ($query) use ($request) {
                $query->where(DB::raw('lower(name)'), 'like', '%' . Str::lower($request->search) . '%');
            });
        }

        $account_code = $account_code->limit($length)->get();

        return AccountCodeResource::collection($account_code)->additional([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data berhasil ditampilkan'
            ]
        ]);
    }

    /**
     * @OA\Get(
     *   tags={"Api|SelectList"},
     *   path="/api/select-list/subdistrict",
     *   summary="SelectList Subdistrict",
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
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function subdistrict(Request $request)
    {
        $length = $request->filled('length') ? $request->length : 10;

        $subdistrict = Subdistrict::with(['umkm'])->where('is_active', true);

        if ($request->filled('search')) {
            $subdistrict = $subdistrict->where(function ($query) use ($request) {
                $query->where(DB::raw('lower(name)'), 'like', '%' . Str::lower($request->search) . '%');
            });
        }

        $subdistrict = $subdistrict->limit($length)->get();

        return SubdistrictResource::collection($subdistrict)->additional([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data berhasil ditampilkan'
            ]
        ]);
    }

    /**
     * @OA\Get(
     * tags={"Api|SelectList"},
     * path="/api/select-list/umkm",
     * summary="Get list of umkm",
     * @OA\Parameter(
     * name="search",
     * in="query",
     * @OA\Schema(type="string"),
     * ),
     * @OA\Parameter(
     *     name="length",
     *     in="query",
     *     @OA\Schema(type="integer")
     *   ),
     * @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function umkm(Request $request)
    {

        $umkm = Umkm::query();

        if ($request->filled('search')) {
            $umkm = $umkm->where(function ($query) use ($request) {
                $query->where(DB::raw('lower(name)'), 'like', '%' . Str::lower($request->search) . '%');
            });
        }

        return SelectUmkmResource::collection($umkm->get())->additional([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data berhasil ditampilkan'
            ]
        ]);
    }
}
