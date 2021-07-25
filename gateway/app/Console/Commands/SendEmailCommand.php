<?php

namespace App\Console\Commands;

use App\Services\MailService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class SendEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'async:send-email {--key=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email Async';

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
     *
     */
    public function handle()
    {
        $key = $this->option('key');
        $payload = Cache::get($key);
        if ($payload instanceof MailService) {
            $payload->send();
        }
    }
}
