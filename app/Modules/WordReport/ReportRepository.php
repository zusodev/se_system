<?php


namespace App\Modules\WordReport;


use App\Models\EmailDetailLog;
use App\Models\EmailJob;
use App\Models\EmailLog;
use App\Models\EmailProject;
use App\Models\TargetCompany;
use App\Models\TargetDepartment;
use App\Models\TargetUser;
use App\Modules\WordReport\ReportRepository\UserTrait;
use DB;
use Illuminate\Database\Query\JoinClause;
use function array_unshift;
use function fopen;
use function fputcsv;
use function json_decode;
use function rewind;
use function stream_get_contents;

class ReportRepository
{
    use UserTrait;

    const REAL_ALL_ACTION_COUNT_COLUMNS = [
        "open_count",
        "open_link_count",
        "open_attachment_count",
        "post_count",
        "none_count"
    ];

    const DEPARTMENT_ACTION_COUNT_COLUMNS = [
        EmailLog::IS_OPEN => 'open_count',
        EmailLog::IS_OPEN_LINK => 'open_link_count',
        EmailLog::IS_OPEN_ATTACHMENT => 'open_attachment_count',
        EmailLog::IS_POST_FROM_WEBSITE => 'post_count',
    ];

    /**
     * Project name
     * 開啟信件人數
     * 開啟連結人數
     * 開啟附件人數
     * 提交表單人數
     * 無異常人數
     * 參與演練總人數
     */
    public function allActionLogCountByEmailProject(array $ids = [])
    {
        $builder = $this->allActionLogCountByEmailProjectBuilder();
        if (!empty($ids)) {
            $builder->whereIn(EmailProject::ID, $ids);
        }
        return $builder
            ->get();
    }

    public function actionCountGroupByDepartment(array $where, array $projectIds)
    {
        $builder = $this->baseProjectWithoutTestDepartment()
            ->groupBy(EmailJob::ID)
            ->where($where)
            ->whereIn(EmailProject::ID, $projectIds)
            ->select([
                TargetDepartment::NAME . " AS department_name",
                DB::raw("COUNT(*) AS action_count")
            ]);

        return DB::table(DB::raw("({$builder->toSql()}) AS sub"))
            ->mergeBindings($builder)
            ->orderByDesc("sub.action_count")
            ->limit(10)
            ->get();

    }

    protected function baseProjectWithoutTestDepartment($isJoinUser = false, $isJoinDetailLog = false)
    {
        $builder = DB::table(EmailProject::TABLE)
            ->join(EmailJob::TABLE, EmailProject::ID, EmailJob::PROJECT_ID)
            ->join(EmailLog::TABLE, EmailJob::ID, EmailLog::JOB_ID)
            ->join(TargetCompany::TABLE, EmailProject::COMPANY_ID, TargetCompany::ID)
            ->join(TargetDepartment::TABLE, function (JoinClause $join) {
                return $join->on(EmailJob::DEPARTMENT_ID, TargetDepartment::ID)
                    ->where(TargetDepartment::IS_TEST, '=', 0);
            });

        if ($isJoinUser) {
            $builder->join(TargetUser::TABLE, EmailLog::TARGET_USER_ID, TargetUser::ID);
        }

        if ($isJoinDetailLog) {
            $builder->join(EmailDetailLog::TABLE, EmailLog::ID, EmailDetailLog::LOG_ID);
        }

        return $builder;
    }


    public function allActionCountGroupByDepartment(array $projectIds)
    {
        $selectedColumn = [TargetDepartment::NAME];
        $columns = self::DEPARTMENT_ACTION_COUNT_COLUMNS;
        unset($columns[0]);
        foreach ($columns as $key => $columnName) {
            $selectedColumn[] = DB::raw("
                SUM(CASE {$key}
                        WHEN true THEN 1
                        ELSE 0 END) AS `{$columnName}`
            ");
        }

        $builder = $this->baseProjectWithoutTestDepartment()
            ->whereIn(EmailProject::ID, $projectIds)
            ->groupBy(EmailJob::ID)
            ->select($selectedColumn);
        foreach ($columns as $key => $columnName) {
            $builder->orderByDesc($columnName);
        }

        return $builder->get();
    }

    public function openMailActionUsers(array $where)
    {
        $builder = $this->firstBuilder([
            EmailLog::IS_OPEN,
            EmailLog::IS_OPEN_LINK,
            EmailLog::IS_OPEN_ATTACHMENT,
            EmailLog::IS_POST_FROM_WEBSITE,
        ])
            ->whereIn(EmailProject::ID, $where);
        $columns = [
            'is_open',
            'is_open_link',
            'is_open_attachment',
            'is_post_from_website',
        ];
        $builder = $this->secondBuilder($builder, array_merge($columns, [
            DB::raw("GROUP_CONCAT( CASE WHEN request_body != '{}' THEN request_body ELSE NULL END ) `request_body`")
        ]));

        $columns[] = 'request_body';
        $builder1 = $this->thirdBuilder($builder, $columns)
            ->whereNotNull("other_action_created_at");


        return $builder1->get();
    }

    public function openMailUsersCsv(array $projectIds)
    {
        $users = $this->openMailActionUsers($projectIds)->toArray();
        array_unshift($users, [
            '部門',
            '姓名',
            'Email',
            '是否開啟信件Log',
            '是否開啟連結Log',
            '是否開啟附件Log',
            '是否提交表單Log',
            '提交內容',
        ]);
        $f = fopen('php://memory', 'r+');
        foreach ($users as $index => $user) {
            if ($index == 0) {
                fputcsv($f, $user, ",", '"', "\\");
                continue;
            }


            $fn = function ($bool): string {
                return $bool ? '是' : '否';
            };
            $jsonFn = function ($json) {
                $jsonStr = '';
                if (empty($json)) {
                    return $jsonStr;
                }
                $json = json_decode($json, true);

                foreach ($json as $key => $value) {
                    if ($key == 'uuid') {
                        continue;
                    }
                    $jsonStr .= $jsonStr ? "\n" : '';
                    $jsonStr .= $key . ':' . $value;
                }
                return $jsonStr;
            };

            $targetItem = [];
            $targetItem[] = $user->department_name;
            $targetItem[] = $user->name;
            $targetItem[] = $user->email;
            $targetItem[] = $fn($user->is_open);
            $targetItem[] = $fn($user->is_open_link);
            $targetItem[] = $fn($user->is_open_attachment);
            $targetItem[] = $fn($user->is_post_from_website);
            $targetItem[] = $jsonFn($user->request_body);
            fputcsv($f, $targetItem, ",", '"', "\\");
        }
        rewind($f);
        return stream_get_contents($f);
    }

    public function twoActionUsers(array $projectIds)
    {
        $builder = $this->firstBuilder()
            ->whereIn(EmailProject::ID, $projectIds);

        $builder = $this->secondBuilder($builder);

        $builder = $this->thirdBuilder($builder)
            ->whereNotNull("other_action_created_at");

        return $builder->get();
    }

    public function paginateEmailProject(array $where = [])
    {
        return $this->allActionLogCountByEmailProjectBuilder()
            ->where($where)
            ->paginate();
    }

    protected function allActionLogCountByEmailProjectBuilder()
    {

        return $this->baseProjectWithoutTestDepartment()
            ->groupBy(EmailProject::ID)
            ->orderByDesc(EmailProject::ID)
            ->select([
                EmailProject::ID,
                EmailProject::NAME,
                EmailProject::START_AT,
                TargetCompany::NAME . " AS company_name",
                DB::raw("COUNT(*) AS 'user_count'"),
                DB::raw("SUM(CASE email_log.is_open WHEN true THEN 1 ELSE 0 END)              AS 'open_count'"),
                DB::raw("SUM(CASE email_log.is_open_link WHEN true THEN 1 ELSE 0 END)         AS 'open_link_count'"),
                DB::raw("SUM(CASE email_log.is_open_attachment WHEN true THEN 1 ELSE 0 END)   AS 'open_attachment_count'"),
                DB::raw("SUM(CASE email_log.is_post_from_website WHEN true THEN 1 ELSE 0 END) AS 'post_count'"),
                DB::raw("SUM(CASE email_log.is_open = false AND
                    email_log.is_open_link = false AND
                    email_log.is_open_attachment = false AND
                    email_log.is_post_from_website = false
               WHEN true THEN 1 ELSE 0 END)                                   AS 'none_count'"),
            ]);
    }
}
