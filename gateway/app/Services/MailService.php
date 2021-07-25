<?php

namespace App\Services;

use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 * Class MailService
 * @package App\Services
 */
class MailService
{
    private $to;
    private $mailable;

    public function __construct($to, Mailable $mailable)
    {
        $this->to       = $to;
        $this->mailable = $mailable;
    }

    public function sendMailAsync()
    {
        $key = Str::random(6);
        Cache::put($key, $this, 1000);
        $basePath = str_replace(" ", "\ ", base_path());
        $command  = 'cd ' . $basePath . ' && php artisan async:send-email --key=' . $key . ' > /dev/null &';
        $handler  = popen($command, "r");
        pclose($handler);
    }

    public function send(): void
    {
        Mail::to($this->to)->send($this->mailable);
    }
}
