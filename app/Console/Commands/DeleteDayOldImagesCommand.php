<?php

namespace App\Console\Commands;

use App\Traits\FileUploadTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class DeleteDayOldImagesCommand extends Command
{
    use FileUploadTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:delete-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes all user generated images from previous day';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $directoryPath = $this->getUploadDirectoryBasePath($yesterday);

        if (Storage::exists($directoryPath)) {
            Storage::deleteDirectory($directoryPath);
            $this->info('Directory deleted');
        }

        $this->info('Directory not deleted');
        return Command::SUCCESS;
    }
}
