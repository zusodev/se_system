<?php


namespace App\Repositories;


use App\Models\EmailJob;
use App\Models\EmailLog;
use App\Models\EmailProject;
use App\Models\TargetDepartment;
use App\Models\TargetUser;
use DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorInterface;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Str;

class EmailLogRepository extends BaseRepository
{
    /**
     * @param array $where
     * @param array $column
     * @param bool $isModel
     * @return LengthAwarePaginator | LengthAwarePaginatorInterface | EmailLog[]
     */
    public function paginate(array $where = [], array $column = ["*"], bool $isModel = true): LengthAwarePaginator
    {
        return $this->start($isModel)
            ->joinEmailJob()
            ->joinEamilProject()
            ->joinTargetUser()
            ->joinTargetDepartment()
            ->builder
            ->where($where)
            ->orderBy(EmailLog::TABLE . ".created_at", "desc")
            ->paginate(50, [
                EmailLog::TABLE . ".*",
                TargetUser::TABLE . ".name AS user_name",
                TargetUser::TABLE . ".email AS email",
                TargetDepartment::TABLE . '.name AS department_name'
            ]);
    }

    /**
     * @param array $fields
     * @return EmailLog|\Illuminate\Database\Eloquent\Model
     */
    public function firstOrCreate(array $fields)
    {
        $fields["uuid"] = Str::random(30);
        return EmailLog::firstOrCreate($fields);
    }

    public function countIsSendedByJob(int $jobId): int
    {
        return $this->start()
            ->builder
            ->where([
                [EmailLog::JOB_ID, $jobId],
                [EmailLog::IS_SEND, true],
            ])
            ->count();
    }

    /**
     * @param string $uuid
     * @return int
     */
    public function update(string $uuid, array $attributes)
    {
        return $this->start()
            ->builder
            ->where(EmailLog::UUID, $uuid)
            ->update($attributes);
    }


    /**
     * @param string $uuid
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null|EmailLog
     */
    public function findOne(string $uuid)
    {
        return $this->start(true)
            ->builder
            ->where(EmailLog::UUID, $uuid)
            ->first();
    }


    /**
     * @return Collection|EmailLog[]
     */
    public function findNotSend()
    {
        return $this
            ->start(true)
            ->builder
            ->where([[EmailLog::IS_SEND, false]])
            ->get();
    }

    public function allJoinUserJobDepartment(): Collection
    {
        return $this->start(false)
            ->joinTargetUser()
            ->joinEmailJob()
            ->joinTargetDepartment()
            ->builder
            ->get([
                TargetDepartment::NAME . " AS group_name",
                TargetUser::NAME . " AS user_name",
                TargetUser::EMAIL . " AS user_email",
                EmailLog::IS_OPEN,
                EmailLog::IS_OPEN_LINK,
            ]);
    }

    protected function start(bool $isModal = false): self
    {
        $this->builder = $isModal ? EmailLog::query() : DB::table(EmailLog::TABLE);
        return $this;
    }

    private function joinTargetUser(): self
    {
        $this->builder
            ->join(TargetUser::TABLE, function (JoinClause $join) {
                $join->on(EmailLog::TARGET_USER_ID, TargetUser::ID);
            });
        return $this;
    }

    private function joinEmailJob(): self
    {
        $this->builder->join(EmailJob::TABLE, EmailLog::JOB_ID, EmailJob::ID);
        return $this;
    }

    private function joinTargetDepartment(): self
    {
        $this->builder
            ->join(TargetDepartment::TABLE, function (JoinClause $join) {
                $join->on(EmailJob::DEPARTMENT_ID, TargetDepartment::ID);
            });
        return $this;
    }

    /**
     * @param array $uuids
     * @return Collection|EmailLog[]
     */
    public function getNotSendByUUIDs(array $uuids)
    {
        return $this->start(true)
            ->builder
            ->whereIn(EmailLog::UUID, $uuids)
            ->where(EmailLog::IS_SEND, "!=", true)
            ->get();
    }

    public function getCounts(int $jobId)
    {
        $getBuilder = function (array $where, string $countName) use ($jobId) {

            return DB::table(EmailLog::TABLE)
                ->where([
                    [EmailLog::JOB_ID, $jobId],
                    $where
                ])
                ->selectRaw("COUNT(*) AS count")
                ->selectRaw("'${countName}' AS count_name");
        };

        $isOpenBuilder = $getBuilder([EmailLog::IS_OPEN, true], "is_open");

        $wheres = [
            "is_open_link" => [EmailLog::IS_OPEN_LINK, true],
            "is_open_attachment" => [EmailLog::IS_OPEN_ATTACHMENT, true],
            "is_post_from_website" => [EmailLog::IS_POST_FROM_WEBSITE, true]
        ];


        foreach ($wheres as $key => $where) {
            $isOpenBuilder = $isOpenBuilder->union($getBuilder(
                $where,
                $key
            ), true);
        }

        return $isOpenBuilder->get();
    }

    protected function joinEamilProject()
    {
        $this->builder->join(
            EmailProject::TABLE,
            EmailJob::PROJECT_ID,
            EmailProject::ID
        );

        return $this;
    }
}
