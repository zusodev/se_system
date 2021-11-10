<?php

namespace App\Jobs;

use App\Mailer\AppMailer;
use App\Repositories\EmailLogRepository;
use App\Repositories\EmailProjectRepository;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use function rand;
use function sleep;

// TODO not used
class ResendMailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(EmailLogRepository $logRepository, EmailProjectRepository $projectRepository)
    {
        $emailLogs = $logRepository->findNotSend();


        foreach ($emailLogs as $key => $emailLog) {

            $emailProject = $projectRepository->findOneByLogId($emailLog->id);
            try {
                sleep(rand(2, 4));
                Log::error("ResendMailsJob TrySendEmail:" . $emailLog->targetUser->email);
                AppMailer::trySendMail($emailLog, $emailProject);
            } catch (Exception $e) {
                Log::error("ResendMailsJob Failed email:" . $emailLog->targetUser->email);
                Log::error($e);
            }
        }
    }
}
