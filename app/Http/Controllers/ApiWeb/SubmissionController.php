<?php

namespace App\Http\Controllers\ApiWeb;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderListResource;
use App\Http\Resources\OrderResource;
use App\Models\AccountCode;
use App\Models\Order;
use App\Models\OrderHasUmkm;
use App\Models\OrderMethod;
use App\Models\ProductType;
use App\Models\Subdistrict;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SubmissionController extends Controller
{

    /**
     * @OA\Get(
     *   tags={"ApiWeb|Transact|Submission"},
     *   path="/api-web/transact/submission",
     *   summary="Submission index",
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
    public function index(Request $request)
    {
        $length = $request->filled('length') ? $request->length : 10;
        $sortBy = $request->filled('sort_by') ? $request->sort_by : 'created_at';
        $orderBy = $request->filled('order_by') ? $request->order_by : 'DESC';

        $orders = Order::with('order_has_umkms.order_has_umkm_product_types.product_type');

        if ($request->filled('search')) {
            $orders = $orders->where(function ($query) use ($request) {
                $query->where(DB::raw('lower(name)'), 'like', '%' . Str::lower($request->search) . '%');
            });
        }

        $orders = $orders->orderBy($sortBy, $orderBy)->paginate($length);

        return OrderListResource::collection($orders)->additional([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data berhasil ditampilkan'
            ]
        ]);
    }

    /**
     * @OA\Get(
     *   tags={"ApiWeb|Transact|Submission"},
     *   path="/api-web/transact/submission/{submissionId}",
     *   summary="Submission show",
     *   @OA\Parameter(
     *     name="submissionId",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function show($submissionId)
    {
        $isUuid = Str::isUuid($submissionId);

        if (!$isUuid) {
            return ResponseFormatter::error(null, 'Format tidak sesuai', 404);
        }

        $order = Order::with('order_method', 'account_code', 'files', 'order_has_umkms.order_has_umkm_product_types.order_has_umkm_product_type_details.subdistrict', 'order_has_umkms.order_has_umkm_product_types.product_type', 'order_has_umkms.umkm')->where('id_hash', $submissionId)->first();

        if (empty($order)) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
        }

        return (new OrderResource($order))->additional([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data berhasil ditampilkan'
            ],
        ]);
    }

    /**
     * @OA\Post(
     *   tags={"ApiWeb|Transact|Submission"},
     *   path="/api-web/transact/submission",
     *   summary="Submission store",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       type="object",
     *       required={"name", "eventDate", "deliveryDate", "referenceNumber", "accountCodeId", "orderMethodId"},
     *       @OA\Property(property="name", type="string"),
     *       @OA\Property(property="eventDate", type="date"),
     *       @OA\Property(property="deliveryDate", type="date"),
     *       @OA\Property(property="referenceNumber", type="string"),
     *       @OA\Property(property="accountCodeId", type="string"),
     *       @OA\Property(property="orderMethodId", type="string"),
     *       @OA\Property(property="orders", type="array",
     *          @OA\Items(
     *              @OA\Property(property="umkmId", type="string"),
     *              @OA\Property(property="productTypes", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="productTypeId", type="string"),
     *                      @OA\Property(property="details", type="array",
     *                          @OA\Items(
     *                              @OA\Property(property="subdistrictId", type="string"),
     *                              @OA\Property(property="qty", type="number"),
     *                              @OA\Property(property="destinationAddress", type="string"),
     *                          ),
     *                      ),
     *                  ),
     *              ),
     *          ),
     *      )
     *     )
     *   ),
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        $rules = [
            'name' => 'required|string',
            'event_date' => 'required|date_format:Y-m-d',
            'delivery_date' => 'required|date_format:Y-m-d',
            'reference_number' => 'required|string',
            'account_code_id' => 'required|uuid|exists:account_codes,id_hash',
            'order_method_id' => 'required|uuid|exists:order_methods,id_hash',
            'files' => 'nullable|array',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,pdf,png',
            'orders' => 'required|array|min:1',
            'orders.*.umkm_id' => 'required|uuid|exists:umkms,id_hash',
            'orders.*.product_types' => 'required|array|min:1',
            'orders.*.product_types.*.product_type_id' => 'required|uuid|exists:product_types,id_hash',
            'orders.*.product_types.*.details.*.qty' => 'required|numeric',
            'orders.*.product_types.*.details.*.subdistrict_id' => 'required|uuid|exists:subdistricts,id_hash',
            'orders.*.product_types.*.details.*.destination_address' => 'required|string',
        ];

        $messages = [];

        $attributes = [
            'name' => 'Nama Acara',
            'event_date' => 'Tanggal Acara',
            'delivery_date' => 'Tanggal Pengiriman',
            'reference_number' => 'Nomer Surat Pendukung',
            'account_code_id' => 'Kode Rekening',
            'order_method_id' => 'Metode Pemesanan',
            'files' => 'List Surat Pendukung',
            'files.*' => 'File Surat Pendukung',
            'orders' => 'List Order',
            'orders.*.umkm_id' => 'UMKM',
            'orders.*.product_types' => 'List Tipe Produk',
            'orders.*.product_types.*.product_type_id' => 'Tipe Produk',
            'orders.*.product_types.*.details.*.qty' => 'Jumlah Pesanan',
            'orders.*.product_types.*.details.*.subdistrict_id' => 'Kecamatan',
            'orders.*.product_types.*.details.*.destination_address' => 'Alamat Pengiriman',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            DB::rollBack();
            return ResponseFormatter::error([
                'errors' => $validator->errors()
            ], 'Silahkan isi form dengan benar terlebih dahulu', 422);
        }

        $orderMethod = OrderMethod::where('id_hash', $request->order_method_id)->first();

        if (empty($orderMethod)) {
            DB::rollBack();
            return ResponseFormatter::error(null, 'Data Metode Pemesanan tidak ditemukan', 404);
        }

        $accountCode = AccountCode::where('id_hash', $request->account_code_id)->first();

        if (empty($accountCode)) {
            DB::rollBack();
            return ResponseFormatter::error(null, 'Data Kode Rekening tidak ditemukan', 404);
        }

        $order = new Order();
        $order->name = $request->name;
        $order->event_date = $request->event_date;
        $order->delivery_date = $request->delivery_date;
        $order->reference_number = $request->reference_number;
        $order->account_code_id = $accountCode->id;
        $order->order_method_id = $orderMethod->id;
        $order->save();

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $key => $value) {
                $changedName = time() . random_int(100, 999) . '.' . $value->getClientOriginalExtension();
                $path = 'order_files/' . $order->id;
                $value->storeAs($path, $changedName);

                $order->files()->create([
                    'name' => $value->getClientOriginalName(),
                    'ext' => $value->getClientOriginalExtension(),
                    'size' => $value->getSize(),
                    'file_type' => 'surat_pendukung',
                    'path' => $path . '/' . $changedName,
                ]);
            }
        }

        if ($request->filled('orders')) {
            foreach ($request->orders as $umkm) {
                $order_umkm = $order->order_has_umkms()->create([
                    'umkm_id' => Umkm::where('id_hash', $umkm['umkm_id'])->first()->id,
                ]);
                foreach ($umkm['product_types'] as $product_type) {
                    $productType = ProductType::where('id_hash', $product_type['product_type_id'])->first();
                    $order_umkm_product_type = $order_umkm->order_has_umkm_product_types()->create([
                        'product_type_id' => $productType->id,
                    ]);
                    foreach ($product_type['details'] as $detail) {
                        $order_umkm_product_type_detail = $order_umkm_product_type->order_has_umkm_product_type_details()->create([
                            'subdistrict_id' => Subdistrict::where('id_hash', $detail['subdistrict_id'])->first()->id,
                            'qty' => $detail['qty'],
                            'destination_address' => $detail['destination_address'],
                            'total_price' => $productType->price * $detail['qty']
                        ]);
                    }
                }
            }
        }

        DB::commit();
        return ResponseFormatter::success($order->id_hash, 'Data berhasil disimpan');
    }

    /**
     * @OA\Post(
     *   tags={"ApiWeb|Transact|Submission"},
     *   path="/api-web/transact/submission/{submissionId}",
     *   summary="Submission update",
     *   @OA\Parameter(
     *     name="submissionId",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="name", type="string"),
     *       @OA\Property(property="eventDate", type="date"),
     *       @OA\Property(property="deliveryDate", type="date"),
     *       @OA\Property(property="referenceNumber", type="string"),
     *       @OA\Property(property="accountCodeId", type="string"),
     *       @OA\Property(property="orderMethodId", type="string"),
     *       @OA\Property(property="orders", type="array",
     *          @OA\Items(
     *              @OA\Property(property="umkmId", type="string"),
     *              @OA\Property(property="productTypes", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="productTypeId", type="string"),
     *                      @OA\Property(property="details", type="array",
     *                          @OA\Items(
     *                              @OA\Property(property="subdistrictId", type="string"),
     *                              @OA\Property(property="qty", type="number"),
     *                              @OA\Property(property="destinationAddress", type="string"),
     *                          ),
     *                      ),
     *                  ),
     *              ),
     *          ),
     *      )
     *     )
     *   ),
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function update(Request $request, $submissionId)
    {
        DB::beginTransaction();

        $rules = [
            'name' => 'nullable|string',
            'event_date' => 'nullable|date_format:Y-m-d',
            'delivery_date' => 'nullable|date_format:Y-m-d',
            'reference_number' => 'nullable|string',
            'account_code_id' => 'nullable|uuid|exists:account_codes,id_hash',
            'order_method_id' => 'nullable|uuid|exists:order_methods,id_hash',
            'files' => 'nullable|array',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,pdf,png',
            'delete_files' => 'nullable|array',
            'delete_files.*' => 'nullable|string',
            'orders' => 'nullable|array|min:1',
            'orders.*.umkm_id' => 'nullable|uuid|exists:umkms,id_hash',
            'orders.*.product_types' => 'nullable|array|min:1',
            'orders.*.product_types.*.product_type_id' => 'nullable|uuid|exists:product_types,id_hash',
            'orders.*.product_types.*.details.*.qty' => 'nullable|numeric',
            'orders.*.product_types.*.details.*.subdistrict_id' => 'nullable|uuid|exists:subdistricts,id_hash',
            'orders.*.product_types.*.details.*.destination_address' => 'nullable|string',
        ];

        $messages = [];

        $attributes = [
            'name' => 'Nama Acara',
            'event_date' => 'Tanggal Acara',
            'delivery_date' => 'Tanggal Pengiriman',
            'reference_number' => 'Nomer Surat Pendukung',
            'account_code_id' => 'Kode Rekening',
            'order_method_id' => 'Metode Pemesanan',
            'files' => 'List Surat Pendukung',
            'files.*' => 'File Surat Pendukung',
            'delete_files' => 'List Surat Pendukung',
            'delete_files.*' => 'File Surat Pendukung',
            'orders' => 'List Order',
            'orders.*.umkm_id' => 'UMKM',
            'orders.*.product_types' => 'List Tipe Produk',
            'orders.*.product_types.*.product_type_id' => 'Tipe Produk',
            'orders.*.product_types.*.details.*.qty' => 'Jumlah Pesanan',
            'orders.*.product_types.*.details.*.subdistrict_id' => 'Kecamatan',
            'orders.*.product_types.*.details.*.destination_address' => 'Alamat Pengiriman',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            DB::rollBack();
            return ResponseFormatter::error([
                'errors' => $validator->errors()
            ], 'Silahkan isi form dengan benar terlebih dahulu', 422);
        }

        $isUuid = Str::isUuid($submissionId);

        if (!$isUuid) {
            DB::rollBack();
            return ResponseFormatter::error(null, 'Format tidak sesuai', 404);
        }

        $orderMethod = OrderMethod::where('id_hash', $request->order_method_id)->first();

        if (empty($orderMethod)) {
            DB::rollBack();
            return ResponseFormatter::error(null, 'Data Metode Pemesanan tidak ditemukan', 404);
        }

        $accountCode = AccountCode::where('id_hash', $request->account_code_id)->first();

        if (empty($accountCode)) {
            DB::rollBack();
            return ResponseFormatter::error(null, 'Data Kode Rekening tidak ditemukan', 404);
        }

        $order = Order::where('id_hash', $submissionId)->first();

        if (empty($order)) {
            DB::rollBack();
            return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
        }

        $order->name = $request->name;
        $order->event_date = $request->event_date;
        $order->delivery_date = $request->delivery_date;
        $order->reference_number = $request->reference_number;
        $order->account_code_id = $accountCode->id;
        $order->order_method_id = $orderMethod->id;
        $order->save();

        if ($request->filled('delete_files') && count($request->delete_files) > 0) {
            $orderFileDelete = $order->files()->whereIn('id_hash', $request->delete_files)->get();

            foreach ($orderFileDelete as $key => $value) {
                if (!empty($value->path)) {
                    if (File::exists(storage_path('app/' . $value->path))) {
                        File::delete(storage_path('app/' . $value->path));
                    }
                }

                $value->forceDelete();
            }
        }

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $key => $value) {
                $changedName = time() . random_int(100, 999) . '.' . $value->getClientOriginalExtension();
                $path = 'order_files/' . $order->id;
                $value->storeAs($path, $changedName);

                $order->files()->create([
                    'name' => $value->getClientOriginalName(),
                    'ext' => $value->getClientOriginalExtension(),
                    'size' => $value->getSize(),
                    'file_type' => 'surat_pendukung',
                    'path' => $path . '/' . $changedName,
                ]);
            }
        }

        if ($request->filled('orders')) {

            $deleteOrderUmkm = OrderHasUmkm::where('order_id', $order->id)->get();

            if (!empty($deleteOrderUmkm)) {
                foreach ($deleteOrderUmkm as $key => $value) {
                    $value->forceDelete();
                }
            }

            foreach ($request->orders as $umkm) {
                $order_umkm = $order->order_has_umkms()->create([
                    'umkm_id' => Umkm::where('id_hash', $umkm['umkm_id'])->first()->id,
                ]);
                foreach ($umkm['product_types'] as $product_type) {
                    $productType = ProductType::where('id_hash', $product_type['product_type_id'])->first();
                    $order_umkm_product_type = $order_umkm->order_has_umkm_product_types()->create([
                        'product_type_id' => $productType->id,
                    ]);
                    foreach ($product_type['details'] as $detail) {
                        $order_umkm_product_type_detail = $order_umkm_product_type->order_has_umkm_product_type_details()->create([
                            'subdistrict_id' => Subdistrict::where('id_hash', $detail['subdistrict_id'])->first()->id,
                            'qty' => $detail['qty'],
                            'destination_address' => $detail['destination_address'],
                            'total_price' => $productType->price * $detail['qty']
                        ]);
                    }
                }
            }
        }

        DB::commit();
        return ResponseFormatter::success($order->id_hash, 'Data berhasil disimpan');
    }
}
