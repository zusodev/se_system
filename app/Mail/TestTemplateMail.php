<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use function str_replace;

class TestTemplateMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(EmailTemplate $template)
    {
        $this->subject($template->subject);

        $templateHtml = str_replace("@name@", Auth::user()->name, $template->template);
        $templateHtml = str_replace("@email@", Auth::user()->email, $templateHtml);
        $templateHtml = str_replace("@embedded_link@", env("APP_URL"), $templateHtml);

        $this->html($templateHtml);
        $this->from(Auth::user()->email, Auth::user()->name);
    }


    public function build()
    {
        // keep empty
    }
}
