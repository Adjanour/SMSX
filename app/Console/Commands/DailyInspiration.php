<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Contact;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Log;


class DailyInspiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily-inspiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $contacts = Contact::where('id',1)->get();
        foreach ($contacts as $contact) {
            $this->sendInspirationalSms($contact->phone_number);
        }
        Log::info('Daily Inspiration SMS sent successfully');
        // $this->sendInspirationalSms($contact->phone_number);
        
    }
    public function getInspiration()
    {
        return Inspiring::quote();
    }
    public function sendInspirationalSms($phoneNumber)
    {
        // Get the output of the Inspire command
        $inspireOutput = $this->getInspiration();
    
        // Define variables for the message template
        $variables = [
            'INSPIRATION' => $inspireOutput,
        ];
    
        // Replace variables in the message template
        $messageTemplate = 'Inspiration of the day: {INSPIRATION}';
        $message = $this->replaceMessageVariables($messageTemplate, $variables);
        
        // Build the SMS url
        $url = $this->buildURL($phoneNumber, $message);
    
        // Send the SMS
        $response = $this->sendSms($url);
        return $response;
    }
    public function  sendSms (string $url): array
    {
        // Initialize cURL session
        $curl = curl_init($url);
    
        // Set cURL options
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
        // Execute cURL request and get the response
        curl_exec($curl);
    
        // Check for cURL errors
        //22-02-05
        if (curl_errno($curl)) {
            $errorCode = curl_errno($curl);
            $errorMessage = curl_error($curl);
            return ['errorCode'=>$errorCode,'errorMessage'=>$errorMessage];
        }
    
        // Check response status code
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
        // Close cURL session
        curl_close($curl);
    
        //SMS Sent Successfully
        if ($statusCode == 200) {
            return ['message'=>'Message sent successfully'];
        } //Sending Failed
        else {
           return ['error'=>'Message not sent!'];
        }
    }
    public function buildURL($phoneNumber, $message)
    {
        
            //retrieve env variables
            $apiKey = env("MNOTIFY_SMS_API_KEY");
            $endPoint = env("MNOTIFY_SMS_API_ENDPOINT");
            $sender = env("SENDER_ID");
    
            $queryParameters = array(
                "key" => $apiKey,
                "to" => $phoneNumber,
                "msg" => $message,
                "sender_id" => $sender
            );
    
            //Build Query and construct url
            //22-02-05
            $queryString = http_build_query($queryParameters);
    
            $url = "$endPoint?$queryString";
    
            return $url;
    
    }
    public function replaceMessageVariables($messageTemplate, $variables)
    {
        foreach ($variables as $key => $value) {
            // Replace variables in the message template
            $messageTemplate = str_replace('{' . strtoupper($key) . '}', $value, $messageTemplate);
        }
    
        return $messageTemplate;
    }
}
