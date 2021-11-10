<?php

namespace App\Mail;


use App\Mail\TemplateMail\TemplateExeAttachementGenerator;
use App\Models\EmailLog;
use App\Models\EmailProject;
use App\Models\EmailTemplate;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Log;
use function base64_encode;
use function env;
use function explode;
use function route;
use function str_replace;

class TemplateMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var EmailProject */
    protected $emailProject;
    /** @var EmailLog */
    protected $emailLog;
    /** @var string */
    protected $base64LogUUID = "";


    public function __construct(EmailLog $emailLog, EmailProject $emailProject)
    {
        $this->emailProject = $emailProject;
        $this->emailLog = $emailLog;
        $this->base64LogUUID = base64_encode($emailLog->uuid);
        $emailTemplate = $emailProject->emailTemplate;


        $this->subject($emailTemplate->subject);
        $this->setEmailTemplateToHtml();

        if ($emailTemplate->attachment_name && $emailTemplate->attachment) {
            $this->attachData($this->getAttachmentAfterReplace(), $emailTemplate->attachment_name);
        }

        $senderEmail = $emailProject->sender_email ? $emailProject->sender_email : env("MAIL_USERNAME");
        $sendName = $emailProject->sender_name ? $emailProject->sender_name : "none";
        $this->from($senderEmail, $sendName);
    }

    public function build()
    {
        // keep empty
    }

    /**
     * @param EmailLog $emailLog
     * @param EmailTemplate $emailTemplate
     */
    protected function setEmailTemplateToHtml(): void
    {
        $openUrl = route("emailLog.open", ["uuid" => $this->base64LogUUID]);
        $embeddedLink = route("emailLog.open.link", ["uuid" => $this->base64LogUUID]);


        $template = $this->emailProject->emailTemplate->template;

        $template = str_replace("@name@", $this->emailLog->targetUser->name, $template);
        $template = str_replace("@email@", $this->emailLog->targetUser->email, $template);
        $template = $this->replaceEmailDomain($template);

        $template = str_replace("@password@", Str::random(10), $template);
        while (Str::contains($template, "@embedded_link@")) {
            $template = str_replace("@embedded_link@", $embeddedLink, $template);
        }
        $template .= "<img src='{$openUrl}' style='display: none'>";
        $this->html($template);
    }

    protected function getAttachmentAfterReplace()
    {
        $attachmentLink = route("emailLog.open.attachment", ["uuid" => $this->base64LogUUID]);

        if ($this->emailProject->emailTemplate->attachment_is_exe) {
            return TemplateExeAttachementGenerator::getAttachment(
                $this->emailProject,
                $this->emailLog,
                $attachmentLink
            );
        }



        $attachment = $this->emailProject->emailTemplate->attachment;
        while (Str::contains($attachment, "http://target_url")) {
            $attachment = str_replace("http://target_url", $attachmentLink, $attachment);
        }

        $attachmentLinkWithoutBaseDomain = str_replace("http://", "", $attachmentLink);
        $attachmentLinkWithoutBaseDomain = str_replace("https://", "", $attachmentLinkWithoutBaseDomain);
        while (Str::contains($attachment, "target_url")) {
            $attachment = str_replace("target_url", $attachmentLinkWithoutBaseDomain, $attachment);
        }


        return $attachment;
    }

    /**
     * @param $template
     * @return string|string[]
     */
    protected function replaceEmailDomain($template)
    {
        try {
            $email = $this->emailLog->targetUser->email;
            $email = explode('@', $email);
            $template = str_replace(
                "@email_domain@",
                $email[0] ?: $this->emailLog->targetUser->email,
                $template);
        } catch (Exception $e){
            Log::error($e);
            $template = str_replace("@email_domain@", $email, $template);
        }
        return $template;
    }
}
