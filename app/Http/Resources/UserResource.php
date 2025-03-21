<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'profilePicture' => $this->profile_picture,
            'title' => $this->title,
            'biography' => $this->biography,
            'accountType' => $this->account_type,
            'emailVerifiedAt' => $this->email_verified_at,
        ];
    }
}
