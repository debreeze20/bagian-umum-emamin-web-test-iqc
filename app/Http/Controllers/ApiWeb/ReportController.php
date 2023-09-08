<?php

namespace App\Http\Controllers\ApiWeb;

use App\Exports\SubmissionExport;
use App\Exports\UmkmExport;
use App\Helpers\ResponseFormatter;
use App\Helpers\Utility;
use App\Http\Controllers\Controller;
use App\Interfaces\SubmissionInterface;
use App\Interfaces\UmkmInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    private $submissionInterface;
    private $umkmInterface;
    public function __construct(SubmissionInterface $submissionInterface, UmkmInterface $umkmInterface)
    {
        $this->submissionInterface = $submissionInterface;
        $this->umkmInterface = $umkmInterface;
    }

    /**
     * @OA\Get(
     *     tags={"ApiWeb|Report|Submission"},
     *     path="/api-web/report/submission",
     *     summary="Report Submission",
     *      @OA\Parameter(
     *          name="eventStartDate",
     *          in="query",
     *          @OA\Schema(type="string", format="date")
     *      ),
     *      @OA\Parameter(
     *          name="eventEndDate",
     *          in="query",
     *          @OA\Schema(type="string", format="date")
     *      ),
     *      @OA\Parameter(
     *          name="deliveryStartDate",
     *          in="query",
     *          @OA\Schema(type="string", format="date")
     *      ),
     *      @OA\Parameter(
     *          name="deliveryEndDate",
     *          in="query",
     *          @OA\Schema(type="string", format="date")
     *      ),
     *      @OA\Parameter(
     *          name="orderMethodId[]",
     *          in="query",
     *          @OA\Schema(type="array", @OA\Items(type="string", example="123"))
     *      ),
     *      @OA\Parameter(
     *          name="umkmId[]",
     *          in="query",
     *          @OA\Schema(type="array", @OA\Items(type="string", example="123"))
     *      ),
     *     @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function submission(Request $request)
    {
        $rules = [
            'event_start_date' => 'nullable|date',
            'event_end_date' => 'nullable|date',
            'delivery_start_date' => 'nullable|date',
            'delivery_end_date' => 'nullable|date',
            'umkm_id' => 'nullable|array|min:0|exists:umkms,id_hash',
            'umkm_id.*' => 'nullable|string',
            'order_method_id' => 'nullable|array|min:0|exists:order_methods,id_hash',
            'order_method_id.*' => 'nullable|string',
        ];

        $messages = [];

        $attributes = [
            'event_start_date' => 'Awal Tanggal Acara',
            'event_end_date' => 'Akhir Tanggal Acara',
            'delivery_start_date' => 'Awal Tanggal Pengiriman',
            'delivery_end_date' => 'Akhir Tanggal Pengiriman',
            'umkm_id' => 'UMKM',
            'order_method_id' => 'Metode Pembayaran',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            return ResponseFormatter::error([
                'errors' => $validator->errors()
            ], 'Silahkan isi form dengan benar terlebih dahulu', 422);
        }

        $orders = $this->submissionInterface->getAll(
            select: ['*'],
            withRelations: ['order_has_umkms.umkm'],
            where: function (Builder $query) use ($request) {
                if ($request->filled('order_method_id')) {
                    $query->whereHas('order_method', function ($query) use ($request) {
                        $query->whereIn('id_hash', $request->order_method_id);
                    });
                }
                if ($request->filled('umkm_id')) {
                    $query->whereHas('order_has_umkms', function ($query) use ($request) {
                        $query->whereHas('umkm', function ($query) use ($request) {
                            $query->whereIn('id_hash', $request->umkm_id);
                        });
                    });
                }
                if ($request->filled('event_start_date') && $request->filled('event_end_date')) {
                    $query->whereBetween('event_date', [$request->event_start_date, $request->event_end_date]);
                }
                if ($request->filled('delivery_start_date') && $request->filled('delivery_end_date')) {
                    $query->whereBetween('delivery_date', [$request->delivery_start_date, $request->delivery_end_date]);
                }
            }
        );

        $orders->transform(function ($order) {

            $orderHasUmkmProductTypedetails = $order->order_has_umkms
                ->flatMap(function ($orderHasUmkm) {
                    return $orderHasUmkm->order_has_umkm_product_types
                        ->flatMap(function ($orderHasProductType) {
                            return $orderHasProductType->order_has_umkm_product_type_details;
                        });
                });

            $total_price = $orderHasUmkmProductTypedetails
                ->sum('total_price');

            $total_qty = $orderHasUmkmProductTypedetails
                ->sum('qty');

            $umkm = $order->order_has_umkms
                ->map(function ($orderHasUmkm) {
                    return $orderHasUmkm->umkm;
                })
                ->pluck('name')
                ->toArray();


            $subdistrict = $orderHasUmkmProductTypedetails
                ->map(function ($orderHasUmkmProductTypeDetail) {
                    return $orderHasUmkmProductTypeDetail->subdistrict;
                })
                ->pluck('name')
                ->toArray();

            $destinationAddress = $orderHasUmkmProductTypedetails
                ->pluck('destination_address')
                ->toArray();

            $qty = $orderHasUmkmProductTypedetails
                ->pluck('qty')
                ->toArray();

            $total_tax = ($total_price * config('env.tax')) / 100;
            $total_final_price = $total_price + $total_tax;

            $order->total_price = Utility::rupiahFormatNotDecimal($total_price);
            $order->total_tax = Utility::rupiahFormatNotDecimal($total_tax);
            $order->total_payment = Utility::rupiahFormatNotDecimal($total_final_price);
            $order->umkm = implode(', ', $umkm);
            $order->subdistrict = implode(', ', $subdistrict);
            $order->destinationAddress = implode(', ', $destinationAddress);
            $order->qty = implode(', ', $qty);
            $order->total_qty = $total_qty;
            return $order;
        });

        return Excel::download(new SubmissionExport($orders), 'Laporan Pengajuan.xlsx');
    }

    /**
     * @OA\Get(
     *     tags={"ApiWeb|Report|Umkm"},
     *     path="/api-web/report/umkm",
     *     summary="Report Umkm",
     *      @OA\Parameter(
     *          name="subdistrictId[]",
     *          in="query",
     *          @OA\Schema(type="array", @OA\Items(type="string", example="123"))
     *      ),
     *     @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function umkm(Request $request)
    {

        $rules = [
            'subdistrict_id' => 'nullable|array|min:0|exists:subdistricts,id_hash',
            'subdistrict_id.*' => 'nullable|string',
        ];

        $messages = [];

        $attributes = [
            'subdistrict_id' => 'Kecamatan',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            return ResponseFormatter::error([
                'errors' => $validator->errors()
            ], 'Silahkan isi form dengan benar terlebih dahulu', 422);
        }

        $umkms = $this->umkmInterface->getAll(
            select: ['*'],
            withRelations: ['subdistrict', 'umkm_has_orders.order_has_umkm_product_types.product_type'],
            where: function (Builder $query) use ($request) {
                if ($request->filled('subdistrict_id')) {
                    $query->whereHas('subdistrict', function ($query) use ($request) {
                        $query->whereIn('id_hash', $request->subdistrict_id);
                    });
                }
            }
        );

        return Excel::download(new UmkmExport($umkms), 'Laporan UMKM.xlsx');
    }
}
