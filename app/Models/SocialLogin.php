<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use ReflectionClass;

class SocialLogin extends Model
{
    public const SOCIAL_SITE_SNAPCHAT = 'snapchat';

    use HasFactory;

    protected $table = 'social_login';
    protected $casts = [
        'id' => 'int',
        'user_id' => 'int',
        'external_id' => 'string',
        'social_site' => 'string',
    ];

    public static function getSocialSites(): array
    {
        $reflectionClass = new ReflectionClass(__CLASS__);

        $constants = [];
        foreach ($reflectionClass->getConstants() as $key => $constant) {
            if (Str::startsWith($key, 'SOCIAL_SITE')) {
                $constants[] = $constant;
            }
        }

        return $constants;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function getExternalId(): string
    {
        return $this->external_id;
    }

    public function setExternalId(string $external_id): self
    {
        $this->external_id = $external_id;
        return $this;
    }

    public function getSocialSite(): string
    {
        return $this->social_site;
    }

    public function setSocialSite(string $social_site): self
    {
        $this->social_site = $social_site;
        return $this;
    }
}
