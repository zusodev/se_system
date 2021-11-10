<?php


namespace App\Mailer;


use App\Mail\TemplateMail;
use App\Models\EmailLog;
use App\Models\EmailProject;
use Illuminate\Support\Facades\Redis;
use Log;
use Mail;

class AppMailer
{
    public static function trySendMail(EmailLog $emailLog, EmailProject $emailProject)
    {
        $result = self::getLock($emailLog);
        if (!$result) {
            Log::warning("AppMailer getLock failed uuid:". $emailLog->uuid);
            return;
        }

        Mail::to($emailLog->targetUser)
            ->send(new TemplateMail($emailLog, $emailProject));

        $emailLog->update([
            "is_send" => $result,
        ]);
    }

    protected static function getLock(EmailLog $emailLog): bool
    {
        $redis = Redis::connection();
        $key = "app_mailer_" . $emailLog->job_id . "_" . $emailLog->uuid;
        return (bool)$redis->command("set", [$key, "1", "NX", "EX", "300"]);
    }
}
