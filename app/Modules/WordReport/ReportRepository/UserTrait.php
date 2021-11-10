<?php


namespace App\Modules\WordReport\ReportRepository;


use App\Models\EmailDetailLog;
use App\Models\EmailJob;
use App\Models\EmailLog;
use App\Models\TargetDepartment;
use App\Models\TargetUser;
use DB;
use Illuminate\Database\Query\Builder;
use function array_merge;

trait UserTrait
{
    abstract protected function baseProjectWithoutTestDepartment($isJoinUser = false, $isJoinDetailLog = false): Builder;

    /**
     * @return Builder
     */
    protected function firstBuilder(array $columns = [])
    {
        $oldColumns = [
            EmailDetailLog::ID,
            EmailDetailLog::LOG_ID,
            EmailDetailLog::REQUEST_BODY,
            TargetUser::NAME,
            TargetUser::EMAIL,
            EmailJob::DEPARTMENT_ID,
            TargetDepartment::NAME . " AS department_name",
            DB::raw("
                    CASE WHEN email_detail_logs.action = 'is_open'
                    THEN email_detail_logs.created_at
                    ELSE NULL END      AS `open_mail_created_at`
                "),
            DB::raw("
                    CASE WHEN email_detail_logs.action != 'is_open'
                    THEN email_detail_logs.created_at
                    ELSE NULL END      AS 'other_action_created_at'
                "),
        ];
        return $this->baseProjectWithoutTestDepartment(true, true)
            ->groupBy([EmailDetailLog::LOG_ID, EmailDetailLog::ACTION])
            ->orderByDesc(EmailJob::DEPARTMENT_ID)
            ->select(array_merge($oldColumns, $columns));
    }

    protected function secondBuilder(Builder $builder, array $columns = [])
    {
        $oldColumns = [
            'log_id',
            'email',
            'name',
            'department_name',
            'department_id',
            DB::raw("MAX(open_mail_created_at)    AS `open_mail_created_at`"),
            DB::raw("MAX(other_action_created_at) AS `other_action_created_at`"),
        ];
        return DB::table(DB::raw("({$builder->toSql()}) AS `users_with_two_actions`"))
            ->mergeBindings($builder)
            ->select(array_merge($oldColumns, $columns))
            ->groupBy("log_id");
    }

    protected function thirdBuilder(Builder $builder, array $columns = [])
    {
        $oldColumns = [
            'department_id',
            'department_name',
            'name',
            'email',
            DB::raw("TIMESTAMPDIFF(SECOND, open_mail_created_at, other_action_created_at) AS `diff_sec`"),
        ];
        return DB::table(DB::raw("({$builder->toSql()}) AS `users_with_two_actions`"))
            ->mergeBindings($builder)
            ->select(array_merge($oldColumns, $columns))
            ->orderByDesc("department_id");
    }
}
