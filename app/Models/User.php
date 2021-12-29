<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use SoftDeletes;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    public const START_TIME = 86400;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'id' => 'int'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Find the user instance for the given username.
     *
     * @param string $username
     * @return \App\Models\User
     */
    public function findForPassport($username)
    {
        return $this->where('phone_number', $username)->first();
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'user_id', 'id');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getEmailVerifiedAt(): string
    {
        return $this->email_verified_at;
    }

    public function setEmailVerifiedAt(string $emailVerifiedAt): self
    {
        $this->email_verified_at = $emailVerifiedAt;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getTwoFactorSecret(): string
    {
        return $this->two_factor_secret;
    }

    public function setTwoFactorSecret(string $twoFactorSecret): self
    {
        $this->two_factor_secret = $twoFactorSecret;
        return $this;
    }

    public function getTwoFactorRecoveryCodes(): string
    {
        return $this->two_factor_recovery_codes;
    }

    public function setTwoFactorRecoveryCodes(string $twoFactorRecoveryCodes): self
    {
        $this->two_factor_recovery_codes = $twoFactorRecoveryCodes;
        return $this;
    }

    public function getCurrentTeamId(): int
    {
        return $this->current_team_id;
    }

    public function setCurrentTeamId(string $currentTeamId): self
    {
        $this->current_team_id = $currentTeamId;
        return $this;
    }

    public function getProfilePhotoPath(): ?string
    {
        return $this->profile_photo_path;
    }

    public function getProfilePhotoUrl(): ?string
    {
        if (str_contains($this->getProfilePhotoPath(), 'https://')) {
            return $this->getProfilePhotoPath();
        }

        if (null === $this->getProfilePhotoPath()) {
            return $this->getProfilePhotoPath();
        }

        return Storage::url($this->getProfilePhotoPath());
    }

    public function setProfilePhotoPath(?string $profilePhotoPath): self
    {
        $this->profile_photo_path = $profilePhotoPath;
        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function getPhoneNumber(): string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phone_number = $phoneNumber;
        return $this;
    }

    public function isSystemUser(): bool
    {
        if ($this->getUsername() === 'system') {
            return true;
        }

        return false;
    }
}
