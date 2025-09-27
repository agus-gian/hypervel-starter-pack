<?php

declare(strict_types=1);

namespace App\Http\Resources\User;

use Hypervel\Http\Resources\Json\JsonResource;

class UserDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'profile_url' => $this->profilePictureUrl()
        ];
    }
}
