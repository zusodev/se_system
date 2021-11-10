<?php

namespace App\Console\Commands;

use App\Repositories\EmailJobRepository;
use App\Repositories\TargetUserRepository;
use Illuminate\Console\Command;

class MailJobRedispatchCommand extends Command
{
    use BaseMailJobDispatchCommandTrait;

    protected $signature = 'mail:job:redispatch';

    protected $description = 'Dispatch Send Email With Running Status';
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
        $jobs = $this->repository->getRunningStatus();

        foreach ($jobs as $key => $job) {
            $self = $this;

            $this->targetUserRepository->chunkByDepartment($job, function ($targetUsers) use ($self, $job) {
                $self->sendMails($targetUsers, $job);
            });
        }
    }

}
