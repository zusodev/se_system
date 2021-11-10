<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailRequest;
use App\Mail\TestEmail;
use Mail;

class EmailController extends Controller
{
    public function sendPage()
    {
        /*$targetUser = TargetUser::find(1);

        $mail = new TemplateMail(EmailTemplate::find(1));
        $when = now()->addSeconds(1);
        dd(Mail::to($targetUser)
            ->later($when, $mail));
        Notification::send($targetUser, new TestEmailNotification());*/

    }

    public function send(EmailRequest $request)
    {

//        Mail::to($receiverEmail)
//            ->send(new TestEmail());
    }
}
