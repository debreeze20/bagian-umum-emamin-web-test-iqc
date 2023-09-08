<?php

namespace App\Http\Controllers\ApiWeb;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\UmkmResource;
use App\Models\Subdistrict;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UmkmController extends Controller
{

    /**
     * @OA\Get(
     * tags={"ApiWeb|Master|Umkm"},
     * path="/api-web/master/umkm",
     * summary="Get list of umkm",
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
     *
     * @OA\Parameter(
     * name="status",
     * in="query",
     * @OA\Schema(type="string", enum={"mbr", "bukan_mbr", "semua"}),
     * ),
     * @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function index(Request $request)
    {
        $length = $request->filled('length') ? $request->length : 10;
        $orderCol = $request->filled('order_col') ? $request->order_col : 'created_at';
        $orderDir = $request->filled('order_dir') ? $request->order_dir : 'DESC';
        $status = $request->filled('status') ? $request->status : '';

        $umkm = Umkm::with(['subdistrict']);

        if ($request->filled('status')) {
            if ($status == 'mbr') {
                $umkm = $umkm->where('is_mbr', true);
            } else if ($status == 'bukan_mbr') {
                $umkm = $umkm->where('is_mbr', false);
            } else if ($status == 'semua') {
                $umkm = $umkm;
            }
        }

        if ($request->filled('search')) {
            $umkm = $umkm->where(function ($query) use ($request) {
                $query->where(DB::raw('lower(name)'), 'like', '%' . Str::lower($request->search) . '%')
                    ->orWhere(DB::raw('lower(owner_name)'), 'like', '%' . Str::lower($request->search) . '%');
            });
        }

        $umkm = $umkm->orderBy($orderCol, $orderDir)->paginate($length);

        return UmkmResource::collection($umkm);
    }

    /**
     * @OA\Post(
     * tags={"ApiWeb|Master|Umkm"},
     * path="/api-web/master/umkm",
     * summary="Create new umkm",
     * @OA\RequestBody(
     * required=true,
     * @OA\MediaType(
     * mediaType="multipart/form-data",
     * @OA\Schema(
     * required={"name", "ownerName", "whatsappNumber", "isMbr", "address", "subdistrictId", "nikNumber", "npwpNumber", "nibNumber"},
     * @OA\Property(property="name", type="string", example="UMKM 1"),
     * @OA\Property(property="ownerName", type="string", example="John Doe"),
     * @OA\Property(property="whatsappNumber", type="string", example="08123456789"),
     * @OA\Property(property="isMbr", type="integer", example="1/0"),
     * @OA\Property(property="address", type="string", example="Jl. Jalan"),
     * @OA\Property(property="subdistrictId", type="string", example="1"),
     * @OA\Property(property="nikNumber", type="string", example="1234567890123456"),
     * @OA\Property(property="npwpNumber", type="string", example="123456789012345"),
     * @OA\Property(property="nibNumber", type="string", example="123456789012345"),
     * @OA\Property(property="bankReferenceNumber", type="string", example="123456789012345"),
     * @OA\Property(property="fileKtp[]", type="array", @OA\Items(type="string", format="binary")),
     * @OA\Property(property="fileNpwp[]", type="array", @OA\Items(type="string", format="binary")),
     * @OA\Property(property="fileNib[]", type="array", @OA\Items(type="string", format="binary")),
     * @OA\Property(property="fileBankReference[]", type="array", @OA\Items(type="string", format="binary")),
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
            'owner_name' => 'required|string',
            'whatsapp_number' => 'required|string',
            'is_mbr' => 'required|boolean',
            'address' => 'required|string',
            'subdistrict_id' => 'required|uuid|exists:subdistricts,id_hash',
            'nik_number' => 'required|string',
            'npwp_number' => 'required|string',
            'nib_number' => 'required|string',
            'bank_reference_number' => 'nullable|string',

            // 'product_type_id' => 'required|array',
            // 'product_type_id.*' => 'required|uuid|exists:product_types,id_hash',

            'file_ktp' => 'nullable|array|min:1',
            'file_ktp.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'file_npwp' => 'nullable|array|min:1',
            'file_npwp.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'file_nib' => 'nullable|array|min:1',
            'file_nib.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'file_bank_reference' => 'nullable|array|min:1',
            'file_bank_reference.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        ];

        $messages = [];

        $attributes = [
            'name' => 'Nama UMKM',
            'owner_name' => 'Nama Pemilik',
            'whatsapp_number' => 'Nomor Whatsapp',
            'is_mbr' => 'Status MBR',
            'address' => 'Alamat',
            'subdistrict_id' => 'Kecamatan',
            'nik_number' => 'NIK',
            'npwp_number' => 'NPWP',
            'nib_number' => 'NIB',
            'bank_reference_number' => 'Nomor Referensi Bank',

            // 'product_type_id' => 'List Jenis Produk',
            // 'product_type_id.*' => 'Jenis Produk',

            'file_ktp' => 'List File KTP',
            'file_ktp.*' => 'File KTP',
            'file_npwp' => 'List File NPWP',
            'file_npwp.*' => 'File NPWP',
            'file_nib' => 'List File NIB / SIUP',
            'file_nib.*' => 'File NIB / SIUP',
            'file_bank_reference' => 'List File Referensi Bank',
            'file_bank_reference.*' => 'File Referensi Bank',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            DB::rollBack();
            return ResponseFormatter::error([
                'errors' => $validator->errors()
            ], 'Silahkan isi form dnegan benar', 422);
        }

        $subdistrict = Subdistrict::where('id_hash', $request->subdistrict_id)->first();

        if (empty($subdistrict)) {
            DB::rollBack();
            return ResponseFormatter::error(null, 'Kecamatan tidak ditemukan', 404);
        }

        $umkm = new Umkm();
        $umkm->name = $request->name;
        $umkm->owner_name = $request->owner_name;
        $umkm->whatsapp_number = $request->whatsapp_number;
        $umkm->is_mbr = $request->is_mbr;
        $umkm->address = $request->address;
        $umkm->subdistrict_id = $subdistrict->id;
        $umkm->nik_number = $request->nib_number;
        $umkm->npwp_number = $request->npwp_number;
        $umkm->nib_number = $request->nib_number;
        $umkm->bank_reference_number = $request->bank_reference_number;
        $umkm->save();


        // $umkm->product_types()->sync(
        //     ProductType::whereIn('id_hash', $request->product_type_id)->pluck('id')
        // );

        if ($request->hasFile('fileKtp') && count($request->fileKtp) > 0) {
            foreach ($request->file('fileKtp') as $key => $value) {
                $changedName = time() . random_int(100, 999) . '.' . $value->getClientOriginalExtension();
                $path = 'umkm_files/' . $umkm->id;
                $value->storeAs($path, $changedName);

                $umkm->umkm_ktp_files()->create([
                    'name' => $value->getClientOriginalName(),
                    'ext' => $value->getClientOriginalExtension(),
                    'size' => $value->getSize(),
                    'file_type' => 'nik',
                    'path' => $path . '/' . $changedName,
                ]);
            }
        }

        if ($request->hasFile('fileNpwp') && count($request->fileNpwp) > 0) {
            foreach ($request->file('fileNpwp') as $key => $value) {
                $changedName = time() . random_int(100, 999) . '.' . $value->getClientOriginalExtension();
                $path = 'umkm_files/' . $umkm->id;
                $value->storeAs($path, $changedName);

                $umkm->umkm_npwp_files()->create([
                    'name' => $value->getClientOriginalName(),
                    'ext' => $value->getClientOriginalExtension(),
                    'size' => $value->getSize(),
                    'file_type' => 'npwp',
                    'path' => $path . '/' . $changedName,
                ]);
            }
        }

        if ($request->hasFile('fileNib') && count($request->fileNib) > 0) {
            foreach ($request->file('fileNib') as $key => $value) {
                $changedName = time() . random_int(100, 999) . '.' . $value->getClientOriginalExtension();
                $path = 'umkm_files/' . $umkm->id;
                $value->storeAs($path, $changedName);

                $umkm->umkm_nib_files()->create([
                    'name' => $value->getClientOriginalName(),
                    'ext' => $value->getClientOriginalExtension(),
                    'size' => $value->getSize(),
                    'file_type' => 'nib',
                    'path' => $path . '/' . $changedName,
                ]);
            }
        }

        if ($request->hasFile('fileBankReference') && count($request->fileBankReference) > 0) {
            foreach ($request->file('fileBankReference') as $key => $value) {
                $changedName = time() . random_int(100, 999) . '.' . $value->getClientOriginalExtension();
                $path = 'umkm_files/' . $umkm->id;

                $value->storeAs($path, $changedName);

                $umkm->umkm_bank_files()->create([

                    'name' => $value->getClientOriginalName(),
                    'ext' => $value->getClientOriginalExtension(),
                    'size' => $value->getSize(),
                    'file_type' => 'bank_reference',
                    'path' => $path . '/' . $changedName,
                ]);
            }
        }
        DB::commit();
        return ResponseFormatter::success(null, 'Data berhasil disimpan');
    }

    /**
     * @OA\Post(
     * tags={"ApiWeb|Master|Umkm"},
     * path="/api-web/master/umkm/{id}",
     * summary="Update umkm by uuid",
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
     * encoding={"deleteFileId[]":{"style": "form", "explode": true}},
     * @OA\Schema(
     * @OA\Property(property="name", type="string", example="UMKM 1"),
     * @OA\Property(property="ownerName", type="string", example="John Doe"),
     * @OA\Property(property="whatsappNumber", type="string", example="08123456789"),
     * @OA\Property(property="isMbr", type="integer", example="1/0"),
     * @OA\Property(property="address", type="string", example="Jl. Jalan"),
     * @OA\Property(property="subdistrictId", type="string"),
     * @OA\Property(property="nikNumber", type="string", example="1234567890123456"),
     * @OA\Property(property="npwpNumber", type="string", example="123456789012345"),
     * @OA\Property(property="nibNumber", type="string", example="123456789012345"),
     * @OA\Property(property="bankReferenceNumber", type="string", example="123456789012345"),
     * @OA\Property(property="fileKtp[]", type="array", @OA\Items(type="string", format="binary")),
     * @OA\Property(property="fileNpwp[]", type="array", @OA\Items(type="string", format="binary")),
     * @OA\Property(property="fileNib[]", type="array", @OA\Items(type="string", format="binary")),
     * @OA\Property(property="fileBankReference[]", type="array", @OA\Items(type="string", format="binary")),
     * @OA\Property(property="deleteFileId[]", type="array", @OA\Items(type="integer", format="binary")),
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
            'name' => 'required|string',
            'owner_name' => 'required|string',
            'whatsapp_number' => 'required|string',
            'is_mbr' => 'required|boolean',
            'address' => 'required|string',
            'subdistrict_id' => 'required|uuid|exists:subdistricts,id_hash',
            'nik_number' => 'required|string',
            'npwp_number' => 'required|string',
            'nib_number' => 'required|string',
            'bank_reference_number' => 'nullable|string',

            // 'product_type_id' => 'required|array',
            // 'product_type_id.*' => 'required|uuid|exists:product_types,id_hash',

            'file_ktp' => 'nullable|array|min:0',
            'file_ktp.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'file_npwp' => 'nullable|array|min:0',
            'file_npwp.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'file_nib' => 'nullable|array|min:0',
            'file_nib.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'file_bank_reference' => 'nullable|array|min:0',
            'file_bank_reference.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',

            'delete_file_id' => 'nullable|array|min:0',
            'delete_file_id.*' => 'nullable|uuid',
        ];

        $messages = [];

        $attributes = [
            'id' => 'ID',
            'name' => 'Nama UMKM',
            'owner_name' => 'Nama Pemilik',
            'whatsapp_number' => 'Nomor Whatsapp',
            'is_mbr' => 'Status MBR',
            'address' => 'Alamat',
            'subdistrict_id' => 'Kecamatan',
            'nik_number' => 'NIK',
            'npwp_number' => 'NPWP',
            'nib_number' => 'NIB',
            'bank_reference_number' => 'Nomor Referensi Bank',

            // 'product_type_id' => 'List Jenis Produk',
            // 'product_type_id.*' => 'Jenis Produk',

            'file_ktp' => 'List File KTP',
            'file_ktp.*' => 'File KTP',
            'file_npwp' => 'List File NPWP',
            'file_npwp.*' => 'File NPWP',
            'file_nib' => 'List File NIB / SIUP',
            'file_nib.*' => 'File NIB / SIUP',
            'file_bank_reference' => 'List File Referensi Bank',
            'file_bank_reference.*' => 'File Referensi Bank',

            'delete_file_id' => 'List ID File',
            'delete_file_id.*' => 'ID File',
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

        $umkm = Umkm::where('id_hash', $id)->first();
        if (empty($umkm)) {
            DB::rollBack();
            return ResponseFormatter::error([
                'errors' => 'Data tidak ditemukan'
            ], 'Data tidak ditemukan', 404);
        }

        $subdistrict = Subdistrict::where('id_hash', $request->subdistrict_id)->first();

        if (empty($subdistrict)) {
            DB::rollBack();
            return ResponseFormatter::error(null, 'Kecamatan tidak ditemukan', 404);
        }

        $umkm->name = $request->name;
        $umkm->owner_name = $request->owner_name;
        $umkm->whatsapp_number = $request->whatsapp_number;
        $umkm->is_mbr = $request->is_mbr;
        $umkm->address = $request->address;
        $umkm->subdistrict_id = $subdistrict->id;
        $umkm->nik_number = $request->nik_number;
        $umkm->npwp_number = $request->npwp_number;
        $umkm->nib_number = $request->nib_number;
        $umkm->bank_reference_number = $request->bank_reference_number;
        $umkm->save();

        // $umkm->product_types()->sync(
        //     ProductType::whereIn('id_hash', $request->product_type_id)->pluck('id')
        // );

        if ($request->filled('delete_file_id') && count($request->delete_file_id) > 0) {
            $umkmFileDelete = $umkm->umkm_files()->whereIn('id_hash', $request->delete_file_id)->get();

            foreach ($umkmFileDelete as $key => $value) {
                if (!empty($value->path)) {
                    if (File::exists(storage_path('app/' . $value->path))) {
                        File::delete(storage_path('app/' . $value->path));
                    }
                }

                $value->forceDelete();
            }
        }

        if ($request->hasFile('fileKtp') && count($request->fileKtp) > 0) {
            foreach ($request->file('fileKtp') as $key => $value) {
                $changedName = time() . random_int(100, 999) . '.' . $value->getClientOriginalExtension();
                $path = 'umkm_files/' . $umkm->id;

                $value->storeAs($path, $changedName);

                $umkm->umkm_ktp_files()->create([

                    'name' => $value->getClientOriginalName(),
                    'ext' => $value->getClientOriginalExtension(),
                    'size' => $value->getSize(),
                    'file_type' => 'nik',
                    'path' => $path . '/' . $changedName,
                ]);
            }
        }

        if ($request->hasFile('fileNpwp') && count($request->fileNpwp) > 0) {
            foreach ($request->file('fileNpwp') as $key => $value) {
                $changedName = time() . random_int(100, 999) . '.' . $value->getClientOriginalExtension();
                $path = 'umkm_files/' . $umkm->id;

                $value->storeAs($path, $changedName);

                $umkm->umkm_npwp_files()->create([

                    'name' => $value->getClientOriginalName(),
                    'ext' => $value->getClientOriginalExtension(),
                    'size' => $value->getSize(),
                    'file_type' => 'npwp',
                    'path' => $path . '/' . $changedName,
                ]);
            }
        }

        if ($request->hasFile('fileNib') && count($request->fileNib) > 0) {
            foreach ($request->file('fileNib') as $key => $value) {
                $changedName = time() . random_int(100, 999) . '.' . $value->getClientOriginalExtension();
                $path = 'umkm_files/' . $umkm->id;

                $value->storeAs($path, $changedName);

                $umkm->umkm_nib_files()->create([

                    'name' => $value->getClientOriginalName(),
                    'ext' => $value->getClientOriginalExtension(),
                    'size' => $value->getSize(),
                    'file_type' => 'nib',
                    'path' => $path . '/' . $changedName,
                ]);
            }
        }

        if ($request->hasFile('fileBankReference') && count($request->fileBankReference) > 0) {
            foreach ($request->file('fileBankReference') as $key => $value) {
                $changedName = time() . random_int(100, 999) . '.' . $value->getClientOriginalExtension();
                $path = 'umkm_files/' . $umkm->id;

                $value->storeAs($path, $changedName);

                $umkm->umkm_bank_files()->create([

                    'name' => $value->getClientOriginalName(),
                    'ext' => $value->getClientOriginalExtension(),
                    'size' => $value->getSize(),
                    'file_type' => 'bank_reference',
                    'path' => $path . '/' . $changedName,
                ]);
            }
        }
        DB::commit();
        return ResponseFormatter::success(null, 'Data berhasil perbarui');
    }


    /**
     * @Oa\Get(
     *  tags={"ApiWeb|Master|Umkm"},
     * path="/api-web/master/umkm/{id}",
     * summary="Get Umkm by uuid",
     *
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

        $umkm = Umkm::with('umkm_ktp_files', 'umkm_npwp_files', 'umkm_nib_files', 'umkm_bank_files', 'subdistrict')->where('id_hash', $id)->first();
        if (empty($umkm)) {
            return ResponseFormatter::error([
                'errors' => 'Data tidak ditemukan'
            ], 'Data tidak ditemukan', 404);
        }

        return (new UmkmResource($umkm))->additional([
            'meta' => [
                'code' => 200,
                'message' => 'Data berhasil ditemukan'
            ]
        ]);
    }

    /**
     * @Oa\Delete(
     * tags={"ApiWeb|Master|Umkm"},
     * path="/api-web/master/umkm/{id}",
     * summary="Delete Umkm by uuid",
     *
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

        $umkm = Umkm::where('id_hash', $id)->first();
        if (empty($umkm)) {
            DB::rollBack();
            return ResponseFormatter::error([
                'errors' => 'Data tidak ditemukan'
            ], 'Data tidak ditemukan', 404);
        }

        $umkm->delete();
        DB::commit();
        return ResponseFormatter::success(null, 'Data berhasil dihapus');
    }
}
