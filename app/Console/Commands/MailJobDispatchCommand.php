<?php

namespace App\Console\Commands;

use App\Models\EmailJob;
use App\Repositories\EmailJobRepository;
use App\Repositories\TargetUserRepository;
use DB;
use Illuminate\Console\Command;
use Log;

class MailJobDispatchCommand extends Command
{
    use BaseMailJobDispatchCommandTrait;
    protected $signature = "mail:job:dispatch";

    protected $description = "Dispatch Send Email With Wait Status";

    private $repository;
    private $targetUserRepository;

    public function __construct(EmailJobRepository $repository, TargetUserRepository $targetUserRepository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->targetUserRepository = $targetUserRepository;
    }

    public function handle()
    {
        $jobs = $this->repository->getStartWithWaitStatus();

        foreach ($jobs as $key => $job) {

            DB::beginTransaction();
            $self = $this;
            /**  setJobRunningAndExpectedSendTotal 主要用於避免 Race Condition */
            $isContinue = $this->setJobRunningAndExpectedSendTotal($job);
            if (!$isContinue) {
                continue;
            }
            $this->targetUserRepository->chunkByDepartment($job, function ($targetUsers) use ($self, $job) {
                $self->sendMails($targetUsers, $job);
            });
            DB::commit();
        }
    }

    /**
     * @param EmailJob $job
     */
    private function setJobRunningAndExpectedSendTotal(EmailJob $job): bool
    {
        $count = $this->targetUserRepository->countByDepartmentId($job->department_id);

        $where = [
            "id" => $job->id,
            "status" => EmailJob::WAIT_STATUS
        ];

        $attributes = !$count ? [
            "status" => EmailJob::FINISH_STATUS
        ] : [
            "status" => EmailJob::RUNNING_STATUS,
            "expected_send_total" => $count
        ];
        return $this->repository->updateWaitJobs($where, $attributes);
    }
}
