<?php
//ToDo: Implement user settings
//ToDo: Create helper functions to adhere to dry principles

use Illuminate\Foundation\Inspiring;


// Standalone functions

   /**
 * Get the inspiration.
 *
 * @return string The output of the Inspiring::quote() method.
 */
function getInspiration()
{
    return Inspiring::quote();
}

/**
 * Send an inspirational SMS using the Inspire command output.
 *
 * @param string $phoneNumber The recipient's phone number.
 * @return array Whether the SMS was sent successfully.
 */
function sendInspirationalSms($phoneNumber)
{
    // Get the output of the Inspire command
    $inspireOutput = getInspiration();

    // Define variables for the message template
    $variables = [
        'INSPIRATION' => $inspireOutput,
    ];

    // Replace variables in the message template
    $messageTemplate = 'Inspiration of the day: {INSPIRATION}';
    $message = replaceMessageVariables($messageTemplate, $variables);
    
    // Build the SMS url
    $url = buildURL($phoneNumber, $message);

    // Send the SMS
    $response = sendSms($url);
    return $response;
}

/**
 * Send an SMS using the MNotify API.
 *
 * @param string $url The sms endpint url.
 * @return array Whether the SMS was sent successfully.
 */
function  sendSms (string $url): array
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


/**
 * Build an SMS url using the MNotify API.
 *
 * @param string $phoneNumber The recipient's phone number.
 * @param string $message The message to send.
 * @return string $url The sms endpint url.
 */
function buildURL($phoneNumber, $message)
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



//function to format message
/**
 * Replace variables in a message template.
 *
 * @param string $messageTemplate The template containing variables to replace.
 * @param array $variables An associative array of variables and their values.
 * @return string The message with replaced variables.
 */
function replaceMessageVariables($messageTemplate, $variables)
{
    foreach ($variables as $key => $value) {
        // Replace variables in the message template
        $messageTemplate = str_replace('{' . strtoupper($key) . '}', $value, $messageTemplate);
    }

    return $messageTemplate;
}

