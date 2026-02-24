<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginApiRequest;
use App\Services\AuthService;
use App\Traits\ApiResponseTrait;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends Controller
{
    use ApiResponseTrait;
    /**
     * User service instance
     *
     * @var \App\Services\AuthService
     */
    protected $auth_service;
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->auth_service = new AuthService();
    }

    /**
     * login
     *
     * @param  mixed $request
     * @return void
     */
    public function login(LoginApiRequest $request)
    {
        $response = $this->auth_service->authApi($request);
        if ($response['success']) {
            return $this->success($response['data']);
        }
        return $this->error($response["errors"], $response["status"]);
    }

    /**
     * logout
     *
     * @param  mixed $request
     * @return void
     */
    public function logout(Request $request)
    {
        $response = $this->auth_service->logoutApi($request);
        if ($response['success']) {
            return $this->success($response['data']);
        }
        return $this->error($response["errors"], $response["status"]);
    }
}
