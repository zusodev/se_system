<?php


namespace App\Repositories;


use App\Models\EmailJob;
use App\Models\EmailProject;
use App\Models\EmailTemplate;
use App\Models\TargetCompany;
use App\Models\TargetDepartment;
use DB;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Pagination\LengthAwarePaginator;
use function now;

class EmailJobRepository extends BaseRepository
{
    /**
     * @param array $fields
     * @return EmailJob|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $fields)
    {
        return EmailJob::create($fields);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection|EmailJob[]
     */
    public function getStartWithWaitStatus()
    {
        return $this->start(true)
            ->joinProject()
            ->builder
            ->where([
                [EmailJob::STATUS, EmailJob::WAIT_STATUS],
                [EmailProject::START_AT, "<=", now()],
            ])
            ->orderBy(EmailProject::START_AT, "DESC")
            ->get([
                EmailJob::TABLE . ".*",
            ]);
    }

    protected function joinProject()
    {
        $this->builder->join(
            EmailProject::TABLE,
            EmailJob::PROJECT_ID,
            "=",
            EmailProject::ID
        );
        return $this;
    }

    /**
     * @param array $where
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|LengthAwarePaginator|EmailJob[]
     */
    public function paginateJoinDepartment(array $where)
    {
        return $this->start(true)
            ->joinTargetDepartment()
            ->joinProject()
            ->builder
            ->where($where)
            ->orderBy(EmailJob::TABLE . ".id", "desc")
            ->paginate($this->perPage, [
                EmailJob::TABLE . ".*",
                TargetDepartment::TABLE . ".name AS department_name",
                EmailProject::START_AT . " AS project_start_at"
            ]);
    }

    public function findOneJoinTemplateAndDepartment(int $id)
    {
        return $this->start(true)
            ->joinProject()
            ->joinCompany()
            ->joinTargetDepartment()
            ->joinTemplate()
            ->builder
            ->select([
                EmailJob::TABLE . ".*",
                EmailProject::NAME . " AS project_name",
                EmailProject::DESCRIPTION . " AS project_description",
                EmailProject::SENDER_NAME . " AS project_sender_name",
                EmailProject::SENDER_EMAIL . " AS project_sender_email",
                EmailProject::START_AT . " AS project_start_at",



                EmailTemplate::TABLE . ".name AS template_name",
                TargetDepartment::NAME . " AS department_name",
                TargetCompany::NAME . " AS company_name",
            ])
            ->find($id);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection|EmailJob[]
     */
    public function getRunningStatus()
    {
        return $this->start(true)
            ->builder
            ->where([
                [EmailJob::STATUS, EmailJob::RUNNING_STATUS],
            ])
            ->get();
    }

    public function updateWaitJobs(array $where, array $attributes): bool
    {
        return $this->start(false)
            ->builder
            ->where($where)
            ->update($attributes);
    }

    protected function joinTemplate()
    {
        $this->builder->join(EmailTemplate::TABLE, EmailProject::EMAIL_TEMPLATE_ID, EmailTemplate::ID);
        return $this;
    }

    protected function start(bool $isModal = true): self
    {
        $this->builder = $isModal ? EmailJob::query() : DB::table(EmailJob::TABLE);
        return $this;
    }

    protected function joinCompany()
    {
        $this->builder->join(TargetCompany::TABLE, EmailProject::COMPANY_ID, "=", TargetCompany::ID);
        return $this;
    }

    protected function joinTargetDepartment()
    {
        $this->builder->join(TargetDepartment::TABLE, function (JoinClause $join) {
            $join->on(EmailJob::DEPARTMENT_ID, "=", TargetDepartment::ID);
        });
        return $this;
    }
}
