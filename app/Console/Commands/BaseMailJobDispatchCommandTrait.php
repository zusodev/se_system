<?php


namespace App\Console\Commands;


use App\Jobs\SendMailJob;
use App\Models\EmailJob;
use App\Models\TargetUser;
use Exception;
use Illuminate\Database\Eloquent\Collection;

trait BaseMailJobDispatchCommandTrait
{
    /**
     * @param TargetUser[]|Collection $targetUsers
     * @throws Exception
     */
    protected function sendMails($targetUsers, EmailJob $job)
    {
        foreach ($targetUsers as $index => $targetUser) {
            SendMailJob::dispatch($targetUser->id, $job->id);
        }
    }
}
