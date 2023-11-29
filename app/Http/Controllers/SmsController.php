<?php

namespace App\Http\Controllers;

use App\Jobs\SendSms;
use App\Models\Contact;
use App\Models\MessageTemplates;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SmsController extends Controller
{
    //SMS Controller
    //Handles views and SMS sending

    public function sendSms(Request $request)
    {

            $apiKey = env("MNOTIFY_SMS_API_KEY");
            $endPoint = env("MNOTIFY_SMS_API_ENDPOINT");
            $phoneNumber = $request->input('phone_number');
            $message = $request->input('message');
            $sender = env("SENDER_ID");
            $country_code = $request->input('country_code');
            $name = $request->input('selectContact');
            $app_name = env('APP_NAME');
            try {
                $selectedObject = json_decode($name);
                $otherName = $selectedObject->first_name;
                $firstName = $selectedObject->first_name;
                $lastName = $selectedObject->last_name;
                $Name = "$firstName $lastName";
        } catch (Exception) {

            }
            $formattedMessage = str_replace("{NAME}", $Name, $message);
            $formattedMessage = str_replace("{FIRST_NAME}", $firstName, $formattedMessage) ;
            $formattedMessage = str_replace("{LAST_NAME}", $lastName, $formattedMessage) ;
            $formattedMessage = str_replace("{APP_NAME}", $app_name, $formattedMessage) ;
            $formattedPhoneNumber ='';
            if((str_starts_with($phoneNumber, '0')) && (strlen($country_code) !== 0))
            {
                $newNumber = preg_replace('/0/', '', $phoneNumber, 1);
                $formattedPhoneNumber = "$country_code$newNumber";
            }


        if (strlen($formattedPhoneNumber)!==0){
                $queryParameters = array(
                    "key" => $apiKey,
                    "to" => $formattedPhoneNumber,
                    "msg" => $formattedMessage,
                    "sender_id" => $sender
                );
            //              $url = "$endPoint?key=$apiKey&to=$formattedPhoneNumber&msg=$formattedMessage&sender_id=$sender";
            }
            else{
                $queryParameters = array(
                    "key" => $apiKey,
                    "to" => $phoneNumber,
                    "msg" => $formattedMessage,
                    "sender_id" => $sender
                );
                //               $url = "$endPoint?key=$apiKey&to=$phoneNumber&msg=$formattedMessage&sender_id=$sender";
            }
        $queryString = http_build_query($queryParameters);

        $url = "$endPoint?$queryString";

        SendSms::dispatch($url);
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
//                return response()->json(['status' => $errorCode, 'message' => 'cURL Error: ' . curl_error($curl)]);
                return  redirect()->route('sms')->with('error', 'Message not sent!');
            }

            // Check response status code
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            // Close cURL session
            curl_close($curl);

            //SMS Sent Successfully
            if ($statusCode == 200) {
                // Redirect with success message
                return redirect()->route('sms')->with('message', 'Message sent successfully!');
            } //Sending Failed
            else {
                // Redirect with error message
                return redirect()->route('sms')->with('error', 'Message not sent!');
            }

//        $contacts = Contact::where('user_id',Auth::id())->get();
//        $messageTemplates = MessageTemplates::where('user_id',Auth::id())->get();
//        return view('sms.sms-message')->with('contacts',$contacts)->with('messageTemplates',$messageTemplates)->with('success',$response);


    }

    //index of sms page
    //22-02-05
    public function index (): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $contacts = Contact::where('user_id',Auth::id())->get();
        $messageTemplates = MessageTemplates::where('user_id',Auth::id())->get();
        return view('sms.sms-message')->with('contacts',$contacts)->with('messageTemplates',$messageTemplates);
    }
}
