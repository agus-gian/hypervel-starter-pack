<?php

declare(strict_types=1);

namespace App\Models;

use App\Notifications\VerifyEmail;
use Hypervel\Database\Eloquent\Factories\HasFactory;
use Hypervel\Database\Eloquent\SoftDeletes;
use Hypervel\Foundation\Auth\User as Authenticatable;
use Hypervel\Notifications\Notifiable;
use Hypervel\Permission\Traits\HasRole;
use Hypervel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasRole, HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected array $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected array $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean',
    ];

    /**
     * Function
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmail);
    }

    public function hasEmailVerified(): bool
    {
        if (! is_null($this->email_verified_at)) return true;

        return false;
    }

    public function markEmailAsVerified(): bool
    {
        return $this->forceFill([
            'email_verified_at' => now(),
        ])->save();
    }

    public function profilePictureUrl(): string
    {
        if (!empty($this->profile_picture_url)) {
            return $this->profile_picture_url;
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=eef3ff&color=1761fd&bold=true&size=512';
    }
}
