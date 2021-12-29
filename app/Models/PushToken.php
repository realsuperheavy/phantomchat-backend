<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushToken extends Model
{
    use HasFactory;

    public const TOKEN_TYPE_FIREBASE ='fcm';

    public const PLATFORM_IOS = 'ios';
    public const PLATFORM_ANDROID = 'android';

    protected $fillable = [
        'user_id', 'device_id', 'platform', 'token', 'token_type'
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class);
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $userId): self
    {
        $this->user_id = $userId;
        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    public function getPlatform(): string
    {
        return $this->platform;
    }

    public function setPlatform(string $platform): self
    {
        $this->platform = $platform;
        return $this;
    }

    public function getDeviceId(): string
    {
        return $this->device_id;
    }

    public function setDeviceId(string $deviceId): self
    {
        $this->device_id = $deviceId;
        return $this;
    }

    public function getTokenType(): string
    {
        return $this->token_type;
    }

    public function setTokenType(string $tokenType): self
    {
        $this->token_type = $tokenType;
        return $this;
    }
}
