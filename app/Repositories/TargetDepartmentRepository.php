<?php


namespace App\Repositories;


use App\Models\EmailJob;
use App\Models\TargetDepartment;
use App\Models\TargetUser;
use DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorInterface;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Pagination\LengthAwarePaginator;


class TargetDepartmentRepository extends BaseRepository
{
    /**
     * @param array $where
     * @return LengthAwarePaginator|LengthAwarePaginatorInterface|TargetDepartment[]
     */
    public function paginateJoinUserJob(array $where)
    {
        return $this->start()
             ->joinSubQueryCountTargetUser()
            ->builder
            ->where($where)
            ->groupBy(TargetDepartment::ID)
            ->orderByDesc(TargetDepartment::ID)
            ->paginate($this->perPage, [
                TargetDepartment::TABLE . '.*',
                TargetUser::TABLE . ".*",
            ]);

    }

    public function getJoinTargetUserCount(array $columns)
    {
        return $this->start(false)
            ->joinTargetUser()
            ->builder
            ->groupBy(TargetDepartment::ID)
            ->get($columns);
    }

    public function getLeftJoinTargetUserCount()
    {
        return $this->start(false)
            ->joinTargetUser(false)
            ->builder
            ->groupBy(TargetDepartment::ID)
            ->get([
                TargetDepartment::TABLE . ".*",
                DB::raw("COUNT(target_user.id) AS user_count")
            ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection|TargetDepartment[]
     */
    public function get(array $columns = ["*"], array $where = [])
    {
        return $this->start()
            ->builder
            ->where($where)
            ->get($columns);
    }

    /**
     * @param array $attributes
     * @return TargetDepartment|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes)
    {
        return $this->getBuilderWithStart(true)
            ->create($attributes);
    }

    /**
     * @param array $where
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|TargetDepartment
     */
    public function firstOrCreate(array $attributes)
    {
        return $this->start()
            ->builder
            ->firstOrCreate($attributes, $attributes);
    }

    protected function start(bool $isModal = true): self
    {
        $this->builder = $isModal ? TargetDepartment::query() : DB::table(TargetDepartment::TABLE);
        return $this;
    }

    /**
     * @param int $id
     * @return TargetDepartment
     */
    public function find(int $id)
    {
        return $this->getBuilderWithStart(true)
            ->find($id);
    }

    private function joinSubQueryCountEmailJob()
    {

        $this->builder->join(DB::raw("
        (SELECT target_department.id as `department_id`,
            COUNT(ej.id)    as `email_job_count`
        FROM target_department
            LEFT JOIN email_job ej on target_department.id = ej.department_id
        GROUP BY target_department.id) AS `email_job`
        "), function (JoinClause $join) {
            $join->on(TargetDepartment::ID, "=", EmailJob::DEPARTMENT_ID);
        });
        return $this;
    }

    private function joinSubQueryCountTargetUser()
    {

        $builder = DB::table(TargetDepartment::TABLE)
            ->leftJoin(TargetUser::TABLE, TargetDepartment::ID, "=", TargetUser::DEPARTMENT_ID)
            ->select(["target_department.id as department_id"])
            ->selectRaw("COUNT(target_user.id)  as target_user_count")
            ->groupBy(TargetDepartment::ID);

        $this->builder->leftJoin(
            DB::raw("( {$builder->toSql()} ) as `target_user`"),
            TargetDepartment::ID,
            "=",
            TargetUser::DEPARTMENT_ID
        );

        return $this;
    }


    private function joinTargetUser($isJoin = true)
    {
        $closure = function (JoinClause $join) {
            $join->on(TargetDepartment::ID, "=", TargetUser::DEPARTMENT_ID);
        };
        if ($isJoin) {
            $this->builder->join(TargetUser::TABLE, $closure);
        } else {
            $this->builder->leftJoin(TargetUser::TABLE, $closure);
        }
        return $this;
    }

    private function joinEmailJob()
    {
        $this->builder->leftJoin(EmailJob::TABLE, function (JoinClause $join) {
            $join->on(TargetDepartment::ID, "=", EmailJob::DEPARTMENT_ID);
        });
        return $this;
    }
}
