<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use function now;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        $testEmail = $this
            ->subject("測試")
            ->markdown("email.markdown.testMail", [
                "time" => now()->format("Y-m-d h:i:s")
            ]);
        return $testEmail;
    }
}
