<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "profile" => $this->profile_path,
            "role" => $this->role->label(),
            "phone" => $this->phone,
            "address" => $this->address,
            "dob" => Carbon::parse($this->dob)->format('d-m-Y'),
            "lock_flg" => $this->lock_flg?->label(),
            "created_at" => Carbon::parse($this->created_at)->format('d-m-Y H:i:s'),
            "updated_at" => Carbon::parse($this->updated_at)->format('d-m-Y H:i:s'),
            "deleted_at" => Carbon::parse($this->deleted_at)->format('d-m-Y H:i:s'),
            "created_user" => $this->createdUser->name ?? null,
            "updated_user" => $this->updatedUser->name ?? null,
            "deleted_user" => $this->deletedUser->name ?? null
        ];
    }
}
