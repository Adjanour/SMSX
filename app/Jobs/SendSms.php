<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $url;
    /**
     * Create a new job instance.
     */
    public function __construct($url)
    {
        //
        $this->url = $url;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        // Initialize cURL session
        $curl = curl_init($this->url);

        // Set cURL options
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL request and get the response
        curl_exec($curl);

        // Check for cURL errors
        //22-02-05
        if (curl_errno($curl)) {
            $errorCode = curl_errno($curl);
            $errorMessage = curl_error($curl);

            Log::info($errorCode.':'.$errorMessage);
        }

        // Check response status code
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Close cURL session
        curl_close($curl);

        //SMS Sent Successfully
        if ($statusCode == 200) {
            // Redirect with success message
            Log::info('sms sent successfully');
        } //Sending Failed
        else {
            // Redirect with error message
            Log::info('error', 'Message not sent!');
        }

    }
}
