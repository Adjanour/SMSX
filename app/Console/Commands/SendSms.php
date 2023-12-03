<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SendSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:sms-send';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send scheduled SMS messages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $this->info('SMS sent successfully');
    }
}
