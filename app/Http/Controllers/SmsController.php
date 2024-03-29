<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use App\Imports\PhoneImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Sms;
use App\Models\PhoneNumber;

 
class SmsController extends Controller
{
    public function index()
    {
        return view('send-sms');

    }
     public function bulkView()
    {
        return view('sms-bulk');
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

            if (substr($request->receiver, 0, 1) != '+')
            {
                $phone ='+'. $request->receiver;

            }else{
                $phone = $request->receiver;
            }

            

            $sms = new Sms;
            $sms->phone = $phone;
            $sms->message = $request->message;
            $sms->status = 1;
            $sms->save();
 
            return back()
            ->with('success','Sms has been successfully sent.');
 
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()
            ->with('error', $e->getMessage());
        }
    }

    public function sendBulk(Request $request)
    {
    	$this->validate($request, [
            'file' => 'required',
            'message' => 'required|min:5|max:155',
        ]);

    	Excel::import(new PhoneImport,request()->file('file'));
    	$phone_numbers = PhoneNumber::all();
    	 $count = 0;

    	 //dd($phone_numbers);

    	foreach ($phone_numbers as $p) {
    		$count++;
    		
    		if (substr($p->phone, 0, 1) != '+')
            {
                $phone ='+'. $p->phone;

            }else{
                $phone = $p->phone;
            }


            

    		try {
	            $accountSid = env('TWILIO_SID');
	            $authToken = env('TWILIO_AUTH_TOKEN');
	            $twilioNumber = env('TWILIO_NUMBER');

	            $client = new Client($accountSid, $authToken);

	            $receiver = $phone;
	 
	            $client->messages->create($receiver, [
	                'from' => $twilioNumber,
	                'body' => $request->message
	            ]);
	            $res=PhoneNumber::where('phone',$phone)->delete();
	            $sms = new Sms;
	            $sms->phone = $phone;
	            $sms->message = $request->message;
	            $sms->status = 1;
	            $sms->save();
	 
	            
	 
	         } catch (\Exception $e) {
	             dd($e->getMessage());
	            return back()
	            ->with('error', $e->getMessage());
	        }


    		# code...
    	}

        return back()
                ->with('success','Sms has been successfully sent.');

    }


    public function sendSingle(Request $request)
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
 
           // $client = new Client($accountSid, $authToken);

            $receiver = $request->receiver;




            $twilio = new Client($accountSid, $authToken);

            $message = $twilio->messages
              ->create("whatsapp:$receiver", // to
                array(
                  "from" => "whatsapp:+14155238886",
                  "body" => $request->message
                )
              );
 
           



        

            if (substr($request->receiver, 0, 1) != '+')
            {
                $phone ='+'. $request->receiver;

            }else{
                $phone = $request->receiver;
            }

            

            $sms = new Sms;
            $sms->phone = $phone;
            $sms->message = $request->message;
            $sms->status = 1;
            $sms->save();
 
            return back()
            ->with('success','Sms has been successfully sent.');
 
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()
            ->with('error', $e->getMessage());
        }
    }



    function test(){
          $sid     = env('TWILIO_SID');
    $token  = env('TWILIO_AUTH_TOKEN');
    $twilio = new Client($sid, $token);

    $message = $twilio->messages
      ->create("whatsapp:+254721941386", // to
        array(
          "from" => "whatsapp:+14155238886",
          "body" => 'Your appointment is coming up on July 21 at 3PM'
        )
      );

print($message->sid);
    }



    public function sendMany(Request $request)
    {
        $this->validate($request, [
            'file' => 'required',
            'message' => 'required|min:5|max:155',
        ]);

        Excel::import(new PhoneImport,request()->file('file'));
        $phone_numbers = PhoneNumber::all();
         $count = 0;

         //dd($phone_numbers);

        foreach ($phone_numbers as $p) {
            $count++;
            
            if (substr($p->phone, 0, 1) != '+')
            {
                $phone ='+'. $p->phone;

            }else{
                $phone = $p->phone;
            }


            

            try {
                $accountSid = env('TWILIO_SID');
                $authToken = env('TWILIO_AUTH_TOKEN');
                $twilioNumber = env('TWILIO_NUMBER');

                $client = new Client($accountSid, $authToken);

                $receiver = $phone;
     
              

                 $twilio = new Client($accountSid, $authToken);

                    $message = $twilio->messages
                      ->create("whatsapp:$receiver", // to
                        array(
                          "from" => "whatsapp:+14155238886",
                          "body" => $request->message
                        )
                      );


                $res=PhoneNumber::where('phone',$phone)->delete();
                $sms = new Sms;
                $sms->phone = $phone;
                $sms->message = $request->message;
                $sms->status = 1;
                $sms->save();
     
                
     
             } catch (\Exception $e) {
                 dd($e->getMessage());
                return back()
                ->with('error', $e->getMessage());
            }


            # code...
        }

        return back()
                ->with('success','Sms has been successfully sent.');

    }




}