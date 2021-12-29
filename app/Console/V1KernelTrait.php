<?php
declare(strict_types=1);

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;

trait V1KernelTrait
{
    private function registerV1Commands()
    {
        //$this->load(__DIR__.'/../Code/V1/Conversation/UI/Commands');
    }

    private function scheduleV1Commands(Schedule $schedule)
    {
        //$schedule->command(Command::class)->hourly();
    }
}
