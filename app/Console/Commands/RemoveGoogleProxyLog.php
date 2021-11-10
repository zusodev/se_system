<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class RemoveGoogleProxyLog extends Command
{
    protected $signature = 'email:detail-log:google-proxy:remove';

    protected $description = 'Remove email-detail logs from google proxy';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $sql = "
        DELETE
        FROM email_detail_logs
        WHERE agent LIKE '%GoogleImageProxy%'
";
        DB::statement($sql);

        $sql = "
        SELECT email_log_id
        FROM (
             SELECT email_log.id AS email_log_id,
                    COUNT(edl.id) AS detail_log_count
            FROM email_log
                LEFT JOIN email_detail_logs edl on email_log.id = edl.log_id
            GROUP BY email_log.id
        ) AS A
        WHERE detail_log_count = 0
";
        DB::statement($sql);

        $sql = "
        UPDATE email_log
            SET is_open            = false,
                is_open_link       = false,
                is_open_attachment = false,
                is_post_from_website = false
        WHERE id IN (
            SELECT email_log_id
            FROM (
                SELECT email_log.id AS email_log_id,
                        COUNT(edl.id) AS detail_log_count
                FROM email_log
                    LEFT JOIN email_detail_logs edl on email_log.id = edl.log_id
                GROUP BY email_log.id
                ) AS A
            WHERE detail_log_count = 0
            );
";
        DB::statement($sql);

    }
}
