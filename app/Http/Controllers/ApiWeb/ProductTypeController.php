<?php

namespace App\Http\Controllers\ApiWeb;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductTypeResource;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductTypeController extends Controller
{
    /**
     * @OA\Get(
     * tags={"ApiWeb|Master|ProductType"},
     * path="/api-web/master/product-type",
     * summary="Get list of Product Type",
     * @OA\Parameter(
     * name="search",
     * in="query",
     * @OA\Schema(type="string"),
     * ),
     * 
     * @OA\Parameter(
     * name="length",
     * in="query",
     * @OA\Schema(type="integer"),
     * ),
     * 
     * @OA\Parameter(
     * name="orderCol",
     * in="query",
     * @OA\Schema(type="string"),
     * ),
     * 
     * @OA\Parameter(
     * name="orderDir",
     * in="query",
     * @OA\Schema(type="string"),
     * ),
     * 
     * @OA\Parameter(
     * name="page",
     * in="query",
     * @OA\Schema(type="integer"),
     * ),
     * @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function index(Request $request)
    {
        $length = $request->filled('length') ? $request->length : 10;
        $orderCol = $request->filled('order_col') ? $request->order_col : 'created_at';
        $orderDir = $request->filled('order_dir') ? $request->order_dir : 'DESC';

        $productType = ProductType::query();

        if ($request->filled('search')) {
            $productType = $productType->where(function ($query) use ($request) {
                $query->where(DB::raw('lower(name)'), 'like', '%' . Str::lower($request->search) . '%');
            });
        }

        $productType = $productType->orderBy($orderCol, $orderDir)->paginate($length);

        return ProductTypeResource::collection($productType);
    }

    /**
     * @OA\Post(
     * tags={"ApiWeb|Master|ProductType"},
     * path="/api-web/master/product-type",
     * summary="Create new Product Type",
     * @OA\RequestBody(
     * required=true,
     * @OA\MediaType(
     * mediaType="multipart/form-data",
     * @OA\Schema(
     * required={"name", "price"},
     * @OA\Property(property="name", type="string", example="UMKM 1"),
     * @OA\Property(property="price", type="number", example="2000"),
     * )
     * )
     * ),
     * @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * ),
     */

    public function store(Request $request)
    {
        DB::beginTransaction();
        $rules = [
            'name' => 'required|string',
            'price' => 'required|integer',
        ];

        $messages = [];

        $attributes = [
            'name' => 'Nama Tipe Produk',
            'price' => 'Harga',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            DB::rollBack();
            return ResponseFormatter::error([
                'errors' => $validator->errors()
            ], 'Silahkan isi form dnegan benar', 422);
        }

            $productType = new ProductType();
            $productType->name = $request->name;
            $productType->price = $request->price;
            $productType->save();

            DB::commit();
        return ResponseFormatter::success(null, 'Data berhasil disimpan');
    }

        /**
     * @OA\Post(
     * tags={"ApiWeb|Master|ProductType"},
     * path="/api-web/master/product-type/{id}",
     * summary="Update product type by uuid",
     * 
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\MediaType(
     * mediaType="multipart/form-data",
     * @OA\Schema(
     * @OA\Property(property="name", type="string", example="UMKM 1"),
     * @OA\Property(property="price", type="number", example="2000"),
     * )
     * )
     * ),
     * @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * ),
     */

    public function update(Request $request, $id)
    {

        DB::beginTransaction();
        $rules = [  
            'name' => 'nullable|string',
            'price' => 'nullable|string',
        ];

        $messages = [];

        $attributes = [
            'name' => 'Nama Tipe Produk',
            'price' => 'Harga',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            DB::rollBack();
            return ResponseFormatter::error([
                'errors' => $validator->errors()
            ], 'Silahkan isi form dnegan benar', 422);
        }

        $isUuid = Str::isUuid($id);

        if (!$isUuid) {
            DB::rollBack();
            return ResponseFormatter::error(null, 'Format tidak sesuai', 404);
        }

        $productType = ProductType::where('id_hash', $id)->first();

        if(empty($productType)) {
            DB::rollBack();
            return ResponseFormatter::error([
                'errors' => 'Data tidak ditemukan'
            ], 'Data tidak ditemukan', 404);
        }

        $productType->name = $request->name;
        $productType->price = $request->price;
        $productType->save();

        DB::commit();
        return ResponseFormatter::success(null, 'Data berhasil perbarui');
    }


    /**
     * @Oa\Get(
     *  tags={"ApiWeb|Master|ProductType"},
     * path="/api-web/master/product-type/{id}",
     * summary="Get Product Type by uuid",
     * @Oa\Parameter(
     *     name="id",
     *    in="path",
     * required=true,
     * ),
     * @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */

    public function show($id)
    {
        $isUuid = Str::isUuid($id);

        if (!$isUuid) {
            return ResponseFormatter::error(null, 'Format tidak sesuai', 404);
        }

        $productType = ProductType::where('id_hash', $id)->first();
        
        if(empty($productType)) {
            return ResponseFormatter::error([
                'errors' => 'Data tidak ditemukan'
            ], 'Data tidak ditemukan', 404);
        }

        return (new ProductTypeResource($productType))->additional([
            'meta' => [
                'code' => 200,
                'message' => 'Data berhasil ditemukan'
            ]
        ]);
    }

    /**
     * @Oa\Delete(
     * tags={"ApiWeb|Master|ProductType"},
     * path="/api-web/master/product-type/{id}",
     * summary="Delete Product Type by uuid",
     * @Oa\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * ),
     * @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */

    public function destroy($id)
    {
        DB::beginTransaction();

        $isUuid = Str::isUuid($id);

        if (!$isUuid) {
            DB::rollBack();
            return ResponseFormatter::error(null, 'Format tidak sesuai', 404);
        }

        $productType = ProductType::where('id_hash',$id)->first();
        if(empty($productType)) {
            DB::rollBack();
            return ResponseFormatter::error([
                'errors' => 'Data tidak ditemukan'
            ], 'Data tidak ditemukan', 404);
        }

        $productType->delete();
        DB::commit();
        return ResponseFormatter::success(null, 'Data berhasil dihapus');
    }

    /**
     * @OA\Put(
     *   tags={"ApiWeb|Master|ProductType"},
     *   path="/api-web/master/product-type/{id}/change-status",
     *   summary="Product Type change status",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function changeStatus($id)
    {
        DB::transaction(function () use ($id) {
            $productType = ProductType::where('id_hash', $id)->first();
            $productType->is_active = !$productType->is_active;
            $productType->save();
        });

        return ResponseFormatter::success(null, 'Data status berhasil diedit');
    }
}
