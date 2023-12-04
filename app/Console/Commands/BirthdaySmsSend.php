<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Birthday;

class BirthdaySmsSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:birthday-sms-send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Birthday Messages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get birthdays on the current date
        // $currentDate = now()->format('Y-m-d');
        // $birthdays = Birthday::where('birth_date', $currentDate)->get();
        $currentMonthDay = now()->format('m-d');
        $birthdays = Birthday::whereRaw("DATE_FORMAT(birth_date, '%m-%d') = ?", [$currentMonthDay])->get();

        // Loop through each birthday and send messages
        foreach ($birthdays as $birthday) {
            $this->sendBirthdayMessage($birthday);
        }
    }


    public function sendBirthdayMessage(Birthday $birthday)
    {
        // Get the message template
        $messageTemplate = $birthday->message_template;

        // Replace variables in the message template
        $message = str_replace('{FIRST_NAME}', $birthday->contact->first_name, $messageTemplate);
        $message = str_replace('{LAST_NAME}', $birthday->contact->last_name, $message);
        $message = str_replace('{NAME}', $birthday->contact->first_name.' '.$birthday->contact->last_name, $message);

        //send sms
        $this->sendSms($birthday->contact->phone_number, $message);
    }

// Method to send sms message
//22-02-05
    public function sendSms($phoneNumber, $message)
    {
        // SMS Logic
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

        //Build Query
        $queryString = http_build_query($queryParameters);
        $url = "$endPoint?$queryString";

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
            $this->info($errorCode.':'.$errorMessage);
        }

        // Check response status code
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Close cURL session
        curl_close($curl);

        //SMS Sent Successfully
        if ($statusCode == 200) {

            $this->info('message sent successfully');
        } //Sending Failed
        else {
            $this->info('message not sent');
        }

    }




}
