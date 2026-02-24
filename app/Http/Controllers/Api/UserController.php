<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserListResource;
use App\Services\UserService;
use App\Traits\ApiResponseTrait;

class UserController extends Controller
{
    use ApiResponseTrait;
    /**
     * User service instance
     *
     * @var \App\Services\UserService
     */
    protected $user_service;
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->user_service = new UserService();
    }

    /**
     * Get User List
     *
     * @return \Illuminate\View\View
     */
    public function getUserList()
    {
        // Fetch user list using the user service
        $users = $this->user_service->getUserList();
        $response = UserListResource::collection($users);
        return $this->paginate($response);        
    }

}
