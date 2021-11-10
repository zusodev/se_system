<?php


namespace App\Repositories;


use App\Models\EmailJob;
use App\Models\EmailLog;
use App\Models\EmailProject;
use App\Models\TargetCompany;
use DB;

class EmailProjectRepository extends BaseRepository
{
    public function paginateJoin()
    {
        return $this->start(true)
            ->joinCount()
            ->builder
            ->groupBy(EmailProject::ID)
            ->select([
                EmailProject::ID,
                EmailProject::NAME,
                EmailProject::START_AT,
                EmailProject::TABLE . "." . EmailProject::CREATED_AT,
                DB::raw("COUNT(email_job.id) as job_count"),
                TargetCompany::TABLE . ".name AS company_name",
            ])
            ->orderByDesc(EmailProject::ID)
            ->paginate();
    }

    protected function joinCount()
    {
        $this->builder->leftJoin(
            EmailJob::TABLE,
            EmailProject::ID,
            "=",
            EmailJob::PROJECT_ID
        );

        /**$this->builder->leftJoin(
         * EmailLog::TABLE,
         * EmailJob::ID,
         * "=",
         * EmailLog::JOB_ID
         * );*/

        $this->builder->leftJoin(
            TargetCompany::TABLE,
            EmailProject::COMPANY_ID,
            "=",
            TargetCompany::ID
        );
        return $this;
    }

    /**
     * @param int $logId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null|EmailProject
     */
    public function findOneByLogId(int $logId)
    {
        return $this->getBuilderWithStart(true)
            ->join(EmailJob::TABLE, EmailProject::ID, "=", EmailJob::PROJECT_ID)
            ->join(EmailLog::TABLE, EmailJob::ID, "=", EmailLog::JOB_ID)
            ->where([
                [EmailLog::ID, $logId]
            ])
            ->first();
    }

    protected function start(bool $isModal)
    {
        $this->builder = $isModal ? EmailProject::query() : DB::table(EmailProject::TABLE);
        return $this;
    }

    public function findOne(int $id)
    {
        return $this->getBuilderWithStart(true)
            ->find($id);
    }

    /**
     * @param int|null $id
     * @return EmailProject|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|\Illuminate\Database\Query\Builder[]|mixed|object|null
     */
    public function mustfindOne(int $id = null)
    {

        $builder = $this->getBuilderWithStart(true)
            ->latest();
        if (!$id) {
            return $builder->first();
        }

        $project = $this->findOne($id);

        return $project ?: $builder->first();
    }

    public function getWithNameId(): array
    {
        return $this->getBuilderWithStart(false)
            ->select([
                EmailProject::ID,
                EmailProject::NAME,
            ])
            ->orderByDesc(EmailProject::ID)
            ->get()
            ->toArray();
    }
}
