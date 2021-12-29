<?php
declare(strict_types=1);

namespace App\Services;

class PaginationService
{
    public static function perPage(): int
    {
        return (int) config('pagination.per_page');
    }
}
