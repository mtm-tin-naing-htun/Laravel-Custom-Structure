<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Constants\GeneralConst;

class AuthService
{
    /**
     * authApi
     *
     * @param  mixed $request
     * @return void
     */
    public function authApi(object $request)
    {
        DB::beginTransaction();
        try {
            $user = User::where('email', $request->email)->first();
            if (Hash::check($request->password, $user->password)) {
                $user->tokens()->delete();
                $expiration = config('sanctum.expiration');
                $expires_at = now()->addMinutes($expiration);
                $token_res = $user->createToken(
                    $request->email,
                    ['*'],
                    $expires_at
                );
                $token = $token_res->plainTextToken;
                DB::commit();
                return [
                    "success" => true,
                    "data" => [
                        "access_token" => $token,
                        "token_type" => "Bearer",
                        "expires_at" => $expires_at->toDateTimeString(),
                        "user_role" => GeneralConst::ROLES[$user->role],
                        "user_id" => $user->id,
                        "user_name" => $user->name,
                        "last_login_at" => $user->last_login_at
                    ]
                ];
            }
            return [
                "success" => false,
                "errors" => ["Password is incorrect."],
                "status" => JsonResponse::HTTP_BAD_REQUEST,
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                "success" => false,
                "errors" => ["Something wrong."],
                "status" => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            ];
        }
    }

    /**
     * logoutApi
     *
     * @param  mixed $request
     * @return void
     */
    public function logoutApi(object $request)
    {
        try {
            $user = $request->user();
            if ($user) {
                $user->currentAccessToken()->delete();
                return [
                    "success" => true,
                    "data" => ["Logout successfully."]
                ];
            }
            return [
                "success" => false,
                "errors" => ["Token not found."],
                "status" => JsonResponse::HTTP_BAD_REQUEST,
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                "success" => false,
                "errors" => ["Something wrong."],
                "status" => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            ];
        }
    }
}
