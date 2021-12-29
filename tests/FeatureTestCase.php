<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;

class FeatureTestCase extends TestCase
{
    use RefreshDatabase {
        refreshTestDatabase as traitRefreshTestDatabase;
    }

    /**
     * This is set so RefreshDatabase can seed db right after migrations
     * @see \Illuminate\Foundation\Testing\RefreshDatabase::shouldSeed
     */
    protected $seed = true;

    protected function refreshTestDatabase()
    {
        global $argv;

        foreach ($argv as $key => $arg) {
            //disable migrating and seeding database when running tests
            //if you want to test only one test and not seed and migrat (you might have data seeded already)
            //e.g. php artisan test --filter=UserControllerTest --random-order-seed=999
            if ('--random-order-seed=999' === $arg) {
                RefreshDatabaseState::$migrated = true;
            }
        }

        $this->traitRefreshTestDatabase();
    }
}
