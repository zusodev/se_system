<?php

namespace App\Console\Commands;

use App\Models\EmailJob;
use App\Repositories\EmailJobRepository;
use App\Repositories\EmailLogRepository;
use Illuminate\Console\Command;

class UpdateJobsIsFinishCommand extends Command
{
    protected $signature = "mail:job:finish";

    protected $description = 'Update Email Job When Count is enough and is sended';

    public function handle(EmailJobRepository $jobRepository, EmailLogRepository $logRepository)
    {
        $jobs = $jobRepository->getRunningStatus();
        foreach ($jobs as $job) {
            $logCount = $logRepository->countIsSendedByJob($job->id);
            $status = EmailJob::RUNNING_STATUS;
            if ($logCount >= $job->expected_send_total && $job->expected_send_total != 0) {
                $status = EmailJob::FINISH_STATUS;
            } else if ($job->expected_send_total == 0) {
                $status = EmailJob::NO_USER;
            }
            $job->update([
                "status" => $status,
                "send_total" => $logCount
            ]);
        }
    }
}
