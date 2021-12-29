<?php

namespace App\Console\Commands\Test;

use App\ApiSource\Version1\SystemCommunication\Base\Infra\Events\SystemCommunicationEvent;
use App\ApiSource\Version1\SystemCommunication\Socket\Infra\Value\SocketChatMessageSystemCommunicationValue;
use App\Models\Message;
use Illuminate\Console\Command;
use Tests\Traits\TestUserTrait;

class SendTestSocketNotificationCommand extends Command
{
    use TestUserTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'socket:send-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends test socket notification';

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
        $user = $this->getTestUser();

        $message = Message::where('sender_id', $user->getId())
            ->where('conversation_id', 1)
            ->first();

        SystemCommunicationEvent::dispatch(new SocketChatMessageSystemCommunicationValue($message->getId()));
        $this->info('Sent');

        return Command::SUCCESS;
    }
}
