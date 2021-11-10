<?php

namespace App\Jobs;

use App\Mailer\AppMailer;
use App\Models\EmailLog;
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

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $targetUserId;
    private $emailJobId;

    public function __construct(int $targetUserId, int $emailJobId)
    {
        $this->targetUserId = $targetUserId;
        $this->emailJobId = $emailJobId;
    }

    public function handle(EmailLogRepository $logRepository, EmailProjectRepository $projectRepository)
    {
        try {
            sleep(rand(2, 4));

            $emailLog = $this->firstOrCreateEmailLog($logRepository);
            $emailProject = $projectRepository->findOneByLogId($emailLog->id);

            if ($emailLog->is_send) {
                return;
            }
            AppMailer::trySendMail($emailLog, $emailProject);
        } catch (Exception $e) {
            Log::error($e);
        }
    }

    /**
     * @param EmailLogRepository $logRepository
     * @return EmailLog
     */
    protected function firstOrCreateEmailLog(EmailLogRepository $logRepository): EmailLog
    {
        $emailLog = $logRepository->firstOrCreate([
            "job_id" => $this->emailJobId,
            "target_user_id" => $this->targetUserId,
            "is_send" => false,
        ]);
        return $emailLog;
    }
}
