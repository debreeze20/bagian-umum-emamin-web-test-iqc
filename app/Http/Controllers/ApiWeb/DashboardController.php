<?php

namespace App\Http\Controllers\ApiWeb;

use App\Helpers\ResponseFormatter;
use App\Helpers\Utility;
use App\Http\Controllers\Controller;
use App\Models\ProductType;
use Illuminate\Support\Facades\DB;
use App\Models\Umkm;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * @OA\Get(
     *   tags={"ApiWeb|Dashboard"},
     *   path="/api-web/dashboard/status-umkm",
     *   summary="Status UMKM",
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function getStatusUmkm()
    {
        $mbr = Umkm::where('is_mbr', true)->count();
        $nonMbr = Umkm::where('is_mbr', false)->count();
        // $totalStatus = ($mbr + $nonMbr) ?? 0;

        // $persentageMbr = round(($mbr / $totalStatus) * 100, 2);
        // $persentageNonMbr = round(($nonMbr / $totalStatus) * 100, 2);

        $data = [
            'mbr' => $mbr,
            'nonMbr' => $nonMbr,
            // 'percentageMbr' => $persentageMbr,
            // 'percentageNonMbr' => $persentageNonMbr,
        ];

        return ResponseFormatter::success($data, 'Data berhasil ditampilkan');
    }

    /**
     * @OA\Get(
     *   tags={"ApiWeb|Dashboard"},
     *   path="/api-web/dashboard/transaction",
     *   summary="Transaction",
     *   @OA\Parameter(
     *     name="year",
     *     in="query",
     *     @OA\Schema(type="string",example="2023")
     *   ),
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function getTransaction(Request $request)
    {
        $data['transaction'] =
            DB::table('orders')
            ->join('order_has_umkms', 'orders.id', '=', 'order_has_umkms.order_id')
            ->join('order_has_umkm_product_types', 'order_has_umkms.id', '=', 'order_has_umkm_product_types.order_has_umkm_id')
            ->join('order_has_umkm_product_type_details', 'order_has_umkm_product_types.id', '=', 'order_has_umkm_product_type_details.order_has_umkm_product_type_id')
            ->groupBy(DB::raw("EXTRACT(MONTH FROM orders.event_date)"))
            ->select(DB::raw('count(*)'), DB::raw('SUM(order_has_umkm_product_type_details.total_price) as total_price'), DB::raw("EXTRACT(MONTH FROM orders.event_date) as month"))
            ->when($request->filled('year'), function ($query) use ($request) {
                $query->whereYear('orders.event_date', $request->year);
            })
            ->orderBy('month', 'desc')
            ->get();

        $data['jumlah_kumulatif'] = [];

        $cumulatif = 0;

        foreach ($data['transaction'] as $value) {
            $total_tax = ($value->total_price * config('env.tax')) / 100;
            $total_payment = $value->total_price + $total_tax;

            $value->total_tax = $total_tax;
            $value->total_payment = $total_payment;

            $cumulatif += $value->total_payment;
            array_push($data['jumlah_kumulatif'], [
                'kumulatif' => $cumulatif,
                'month' => $value->month,
            ]);
        }

        return ResponseFormatter::success($data, 'Data berhasil ditampilkan');
    }

    /**
     * @OA\Get(
     *   tags={"ApiWeb|Dashboard"},
     *   path="/api-web/dashboard/transaction-product",
     *   summary="Transaction Product",
     *   @OA\Parameter(
     *     name="year",
     *     in="query",
     *     @OA\Schema(type="string",example="2023")
     *   ),
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function getTransactionPerProduct(Request $request)
    {
        $productTypes =  ProductType::all();

        $transaction = [];
        foreach ($productTypes as $productType) {
            $data = DB::table('orders')
                ->join('order_has_umkms', 'orders.id', '=', 'order_has_umkms.order_id')
                ->join('order_has_umkm_product_types', 'order_has_umkms.id', '=', 'order_has_umkm_product_types.order_has_umkm_id')
                ->join('order_has_umkm_product_type_details', 'order_has_umkm_product_types.id', '=', 'order_has_umkm_product_type_details.order_has_umkm_product_type_id')
                ->where('order_has_umkm_product_types.product_type_id', $productType->id)
                ->groupBy(DB::raw("EXTRACT(MONTH FROM orders.event_date)"))
                ->select(DB::raw('SUM(order_has_umkm_product_type_details.qty) as total'), DB::raw("EXTRACT(MONTH FROM orders.event_date) as month"))
                ->when($request->filled('year'), function ($query) use ($request) {
                    $query->whereYear('orders.event_date', $request->year);
                })
                ->orderBy('month', 'desc')
                ->get();

            $result = [];
            foreach ($data as $row) {
                $result[] = [
                    'productTypeName' => $productType->name,
                    'total' => $row->total,
                    'month' => $row->month,
                ];
            }

            $transaction = array_merge($transaction, $result);
        }

        return ResponseFormatter::success($transaction, 'Data berhasil ditampilkan');
    }

    /**
     * @OA\Get(
     *   tags={"ApiWeb|Dashboard"},
     *   path="/api-web/dashboard/transaction-order",
     *   summary="Transaction Order",
     *   @OA\Parameter(
     *     name="year",
     *     in="query",
     *     @OA\Schema(type="string",example="2023")
     *   ),
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function getTransactionOrder(Request $request)
    {
        $data['order'] =
            DB::table('orders')
            ->join('order_has_umkms', 'orders.id', '=', 'order_has_umkms.order_id')
            ->join('order_has_umkm_product_types', 'order_has_umkms.id', '=', 'order_has_umkm_product_types.order_has_umkm_id')
            ->join('order_has_umkm_product_type_details', 'order_has_umkm_product_types.id', '=', 'order_has_umkm_product_type_details.order_has_umkm_product_type_id')
            ->groupBy(DB::raw("EXTRACT(MONTH FROM orders.event_date)"))
            ->select(DB::raw('count(*)'), DB::raw('SUM(order_has_umkm_product_type_details.qty) as total_qty'), DB::raw("EXTRACT(MONTH FROM orders.event_date) as month"))
            ->when($request->filled('year'), function ($query) use ($request) {
                $query->whereYear('orders.event_date', $request->year);
            })
            ->orderBy('month', 'desc')
            ->get();

        $data['jumlah_kumulatif'] = [];

        $cumulatif = 0;

        foreach ($data['order'] as $value) {
            $cumulatif += $value->total_qty;
            array_push($data['jumlah_kumulatif'], [
                'kumulatif' => $cumulatif,
                'month' => $value->month
            ]);
        }

        return ResponseFormatter::success($data, 'Data berhasil ditampilkan');
    }
}
