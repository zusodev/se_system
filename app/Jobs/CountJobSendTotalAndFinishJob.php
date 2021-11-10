<?php

namespace App\Jobs;

use App\Models\EmailJob;
use App\Repositories\EmailJobRepository;
use App\Repositories\EmailLogRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CountJobSendTotalAndFinishJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
