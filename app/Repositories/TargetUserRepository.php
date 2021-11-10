<?php


namespace App\Repositories;


use App\Models\EmailJob;
use App\Models\EmailLog;
use App\Models\TargetDepartment;
use App\Models\TargetUser;
use DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorInterface;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class TargetUserRepository extends BaseRepository
{
    public static function checkUserEmailIsValidExcept(string $email, int $departmentId, int $userId)
    {
        $finalCompanyId = TargetDepartment::find($departmentId)->company_id;
        $sql = "
            SELECT target_user.id FROM target_user
            WHERE  target_user.id != ? AND
                  target_user.email = ? AND
                department_id IN (SELECT target_department.id FROM target_department WHERE company_id = ?)
        ";

        return !DB::selectOne($sql, [
            $userId,
            $email,
            $finalCompanyId,
        ]);
    }

    public static function checkUserEmailIsValid(string $email, int $departmentId = null, ?int $companyId = null)
    {
        $finalCompanyId = $companyId ? $companyId : TargetDepartment::find($departmentId)->company_id;

        $sql = "
            SELECT target_user.id FROM target_user
            WHERE target_user.email = ? AND
                department_id IN (SELECT target_department.id FROM target_department WHERE company_id = ?)
        ";

        return !DB::selectOne($sql, [
            $email,
            $finalCompanyId,
        ]);
    }

    /**
     * @param array $fields
     * @return TargetUser|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $fields)
    {
        return TargetUser::create($fields);
    }

    /**
     * @param array $where
     * @param array $column
     * @param bool $isModel
     * @return LengthAwarePaginator | LengthAwarePaginatorInterface | TargetUser[]
     */
    public function paginateJoinDepartment(array $where): LengthAwarePaginator
    {
        return $this->start(true)
            ->joinDepartment()
            ->joinEmailLog()
            ->builder
            ->where($where)
            ->groupBy(TargetUser::ID)
            ->orderBy(TargetUser::ID, "desc")
            ->paginate($this->perPage, [
                TargetUser::TABLE . ".*",
                TargetDepartment::TABLE . ".name as department_name",
                DB::raw("SUM(CASE WHEN email_log.id IS NOT NULL THEN 1 ELSE 0 END) AS 'email_log_count'"),
            ]);
    }


    public function chunkByDepartment(EmailJob $job, callable $callback)
    {
        $this->start(false)
            ->joinEmailLogWithNull($job->id)
            ->builder
            ->where(TargetUser::DEPARTMENT_ID, $job->department_id)
            ->groupBy(TargetUser::ID)
            ->orderBy(TargetUser::ID)
            ->select([TargetUser::TABLE . ".*"])
            ->chunk(100, $callback);
    }

    public function countByDepartmentId(int $id)
    {
        return $this->start()
            ->builder
            ->where(TargetUser::DEPARTMENT_ID, $id)
            ->count();
    }

    protected function start(bool $isModal = false): self
    {
        $this->builder = $isModal ? TargetUser::query() : DB::table(TargetUser::TABLE);
        return $this;
    }

    protected function joinEmailLogWithNull(int $jobId)
    {
        $this->builder->leftJoin(EmailLog::TABLE, function (JoinClause $join) use ($jobId) {
            $join->on(TargetUser::ID, "=", EmailLog::TARGET_USER_ID)
                ->where(EmailLog::JOB_ID, $jobId);
        })->where([
            [EmailLog::TARGET_USER_ID, "=", null]
        ]);
        return $this;
    }

    protected function joinDepartment()
    {
        $this->builder->join(TargetDepartment::TABLE, TargetUser::DEPARTMENT_ID, TargetDepartment::ID);
        return $this;
    }

    protected function joinEmailLog()
    {
        $this->builder->leftJoin(
            EmailLog::TABLE,
            TargetUser::ID,
            "=",
            EmailLog::TARGET_USER_ID
        );
        return $this;
    }
}
