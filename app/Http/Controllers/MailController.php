<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MailController extends Controller
{
    public function sendMail(Request $request)
    {
        $data = $request->only(['mail_body', 'emails']);

        // Decode the JSON array into a PHP array
        $recipients = json_decode($data['emails'], true);

        // Validate that emails is an array
        if (!is_array($recipients)) {
            return response()->json(['success' => false, 'message' => 'Invalid email array format']);
        }

        try {
            Mail::html($data['mail_body'], function ($message) use ($recipients) {
                $message->to($recipients)  // Send to all recipients
                        ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                        ->subject('Contact Form Message');
            });

            return response()->json(['success' => true, 'message' => 'Messages sent']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Message not sent']);
        }
    }



}
?>
