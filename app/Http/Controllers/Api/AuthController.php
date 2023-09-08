<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    /**
     * @OA\Post(
     *   tags={"Api|Auth"},
     *   path="/api/auth/login",
     *   summary="Auth login",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       type="object",
     *       required={"username", "password"},
     *       @OA\Property(property="username", type="string"),
     *       @OA\Property(property="password", type="string", format="password")
     *     )
     *   ),
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function login(Request $request)
    {

        $rules = [
            'username' => 'required',
            'password' => 'required',
            'g_recaptcha_response' => 'required',
        ];

        $messages = [];

        $attributes = [
            'username' => 'Username',
            'password' => 'Password',
            'g_recaptcha_response' => 'reCaptcha'
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            return ResponseFormatter::error([
                'errors' => $validator->errors()
            ], 'Silahkan isi form dengan benar terlebih dahulu', 422);
        }

        if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
            $credentials = ['email' => $request->username, 'password' => $request->password];
        } else {
            $credentials = $request->only('username', 'password');
        }

        if (!auth()->attempt($credentials)) {
            return ResponseFormatter::error(null, 'Username dan password tidak cocok.', 401);
        }

        $userAuth = User::with(['role'])->find(auth()->user()->id);

        if (empty($userAuth)) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan', 401);
        }

        return (new UserResource($userAuth))->additional([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'User berhasil login'
            ],
            'token' =>  $this->respondWithToken(auth()->user()->createToken($userAuth->name)->plainTextToken)
        ]);
    }

    /**
     * @OA\Post(
     *   tags={"Api|Auth"},
     *   path="/api/auth/logout",
     *   summary="Auth logout",
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return ResponseFormatter::success(null, 'User berhasil logout');
    }

    /**
     * @OA\Get(
     *   tags={"Api|Auth"},
     *   path="/api/auth/me",
     *   summary="Auth me",
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function me()
    {
        $userAuth = User::with(['role'])->find(auth()->user()->id);

        if (empty($userAuth)) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
        }

        return (new UserResource($userAuth))->additional([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data berhasil ditampilkan'
            ]
        ]);
    }

    /**
     * @OA\Post(
     *   tags={"Api|Auth"},
     *   path="/api/auth/change-password",
     *   summary="Auth change password",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       type="object",
     *       required={"currentPassword", "newPassword", "newPasswordConfirmation"},
     *       @OA\Property(property="currentPassword", type="string", format="password"),
     *       @OA\Property(property="newPassword", type="string", format="password"),
     *       @OA\Property(property="newPasswordConfirmation", type="string", format="password")
     *     )
     *   ),
     *   @OA\Response(response="default", ref="#/components/responses/globalResponse")
     * )
     */
    public function changePassword(Request $request)
    {
        DB::beginTransaction();

        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|different:current_password|confirmed',
            'new_password_confirmation' => 'required',
        ];

        $messages = [];

        $attributes = [
            'current_password' => 'Sandi Lama',
            'new_password' => 'Sandi Baru',
            'new_password_confirmation' => 'Konfirmasi Sandi Baru',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            DB::rollBack();
            return ResponseFormatter::error([
                'errors' => $validator->errors()
            ], 'Silahkan isi form dengan benar terlebih dahulu', 422);
        }

        $userAuth = User::find(auth()->user()->id);

        if (empty($userAuth)) {
            DB::rollBack();
            return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
        }

        if (!Hash::check($request->current_password, $userAuth->password)) {
            DB::rollBack();
            return ResponseFormatter::error(null, 'Password lama tidak sama dengan password yang sekarang', 400);
        }

        $userAuth->password = Hash::make($request->new_password);
        $userAuth->save();

        DB::commit();
        return ResponseFormatter::success(null, 'Password berhasil diedit');
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => (int) config('sanctum.expiration')
        ];
    }
}
