<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BulkSmsController extends Controller
{
    //BulkSMS function
    public function bulkSms(Request $request): RedirectResponse
    {
        global $response;
        $apiKey = env("MNOTIFY_SMS_API_KEY");
        $endPoint = env("MNOTIFY_SMS_API_ENDPOINT");
        $phoneNumbers = $request->input('phone_number');
        $message = $request->input('message');
        $sender = env("SENDER_ID");
        $country_code = $request->input('country_code');
        $names = $request->input('phone_number_selected');
        $app_name = env('APP_NAME');

        foreach ($names as $name ){
            try {
                $selectedObject = json_decode($name);
                $otherName = $selectedObject->first_name;
                $firstName = $selectedObject->first_name;
                $lastName = $selectedObject->last_name;
                $Name = "$firstName $lastName";
            } catch (\Exception $e) {

            }
            $formattedMessage = $this->formatMessage($message,$Name,$firstName,$lastName,$app_name);

            $queryParameters = array(
                    "key" => $apiKey,
                    "to" => $selectedObject->contact,
                    "msg" => $formattedMessage,
                    "sender_id" => $sender
                );

            $queryString = http_build_query($queryParameters);

            $url = "$endPoint?$queryString";
            $response = $this->sendSms($url);

        }

        if (array_key_exists('error',$response)){
            return  redirect()->route('sms')->with('error', 'Message not sent!');
        }
        elseif (array_key_exists('message',$response)){
            return redirect()->route('sms')->with('message', 'Message sent successfully!');
        }
        elseif (array_key_exists('errorCode',$response)){
            list($errorCode,$errorMessage)=$response;
            return redirect()->route('sms')->with('error',$errorCode.':'.$errorMessage);
        }
        else{
            return  redirect()->route('sms')->with('error','Unknown');
        }

    }

    //function to send sms
    public  function  sendSms (string $url): array
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

    //format message function
    //22-02-05
    private  function formatMessage(string $message, $Name, $firstName, $lastName, $app_name): string
    {
//        `foreach ($variables as $variable){
//            $formattedMessage = str_replace($variable,)
//        }`
        $formattedMessage = str_replace("{NAME}", $Name, $message);
        $formattedMessage = str_replace("{FIRST_NAME}", $firstName, $formattedMessage) ;
        $formattedMessage = str_replace("{LAST_NAME}", $lastName, $formattedMessage) ;
        return str_replace("{APP_NAME}", $app_name, $formattedMessage);
    }

}
