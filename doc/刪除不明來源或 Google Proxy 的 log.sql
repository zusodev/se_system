DELETE
FROM email_detail_logs
WHERE id IN (SELECT email_detail_logs.id
             FROM email_job
                      JOIN email_log ON email_job.id = email_log.job_id
                      JOIN target_user ON email_log.target_user_id = target_user.id
                      JOIN email_detail_logs ON email_log.id = email_detail_logs.log_id
             WHERE agent LIKE '%TelegramBot%'
             ORDER BY email_detail_logs.id DESC);
