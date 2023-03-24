<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Twilio\Rest\Client;
 
class SmsController extends Controller
{
    public function index()
    {
        return view('send-sms');
    }
 
    public function sendMessage(Request $request)
    {
        $this->validate($request, [
            'receiver' => 'required|max:15',
            'message' => 'required|min:5|max:155',
        ]);
 
        try {
            $accountSid = env('TWILIO_SID');
            $authToken = env('TWILIO_AUTH_TOKEN');
            $twilioNumber = env('TWILIO_NUMBER');

          //  dd($authToken);
 
            $client = new Client($accountSid, $authToken);

            $receiver = $request->receiver;
 
            $client->messages->create($receiver, [
                'from' => $twilioNumber,
                'body' => $request->message
            ]);
 
            return back()
            ->with('success','Sms has been successfully sent.');
 
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()
            ->with('error', $e->getMessage());
        }
    }

    public function sendBulk()
    {

    }
}