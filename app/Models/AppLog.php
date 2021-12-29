<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppLog extends Model
{
    use HasFactory;

    public function getInfo(): string
    {
        return $this->info;
    }

    public function setInfo(string $info): self
    {
        $this->info = $info;
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

}
