<?php

namespace App\Console\Commands;

use App\Models\EmailDetailLog;
use App\Models\EmailJob;
use App\Models\EmailLog;
use Illuminate\Console\Command;
use Illuminate\Database\Query\JoinClause;
use Storage;
use function ip2long;
use function json_decode;

class SyncEmailDetailLogIsTwIp extends Command
{
    protected $signature = 'sync:email-detail-log:is-tw-ipv4';

    protected $description = 'Sync Email Detail log is tw ipv4';

    public function handle()
    {
        $sql = '';
        $ipv4Ranges = json_decode(Storage::disk('local')->get('taiwan-ipv4-range.json'));
//        $ipv4Ranges = [$ipv4Ranges[0], $ipv4Ranges[1]];

        $allWhere = [];
        foreach ($ipv4Ranges as $_ => $range) {
            $start = ip2long($range[0]);
            $end = ip2long($range[1]);

            $sql .= $sql ? ' OR ' : '';
            $sql .= "( {$start} <= src_ipv4_num AND src_ipv4_num <= {$end} )";

        }
        Storage::disk('local')->put('tw-filter.sql', $sql);
        return;
        $builder = $this->getQueryBuilder();
        $builder->where($allWhere)->update([
            EmailDetailLog::IS_TW_IP => true
        ]);
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    private function getQueryBuilder(): \Illuminate\Database\Query\Builder
    {
        return EmailDetailLog::join(
            EmailLog::TABLE,
            EmailDetailLog::T_LOG_ID,
            '=',
            EmailLog::T_ID
        )->join(
            EmailJob::TABLE,
            function (JoinClause $join) {
                $join->on(
                    EmailLog::T_JOB_ID,
                    '=',
                    EmailJob::T_ID
                )->where(EmailJob::PROJECT_ID, 29);
            }
        );
    }
}
