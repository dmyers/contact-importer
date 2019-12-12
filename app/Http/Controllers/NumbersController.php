<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client as TwilioClient;

class NumbersController extends Controller
{
    /**
     * Show a list of all the phone numbers
     * registered with Twilio.
     *
     * @param  \Twilio\Rest\Client  $twilio
     * @return \Illuminate\Http\Response
     */
    public function index(TwilioClient $twilio)
    {
        $numbers = [];

        $shortCodes = $twilio->shortCodes->read([], 100);
        foreach ($shortCodes as $shortCode) {
            $name = $shortCode->friendlyName;
            $number = $shortCode->shortCode;
            $numbers[] = ['text' => $name, 'value' => $number];
        }

        $phones = $twilio->incomingPhoneNumbers->read([], 100);
        foreach ($phones as $phone) {
            $name = $phone->friendlyName;
            $number = $phone->phoneNumber;
            $numbers[] = ['text' => $name, 'value' => $number];
        }

        return response()->json($numbers);
    }
}
