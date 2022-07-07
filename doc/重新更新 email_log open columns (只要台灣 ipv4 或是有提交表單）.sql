DROP TABLE if exists t;
CREATE TEMPORARY TABLE t
    (
        SELECT email_detail_logs.*
        FROM email_detail_logs
                 JOIN email_log el on email_detail_logs.log_id = el.id
                 JOIN email_job on el.job_id = email_job.id AND
                                   email_job.project_id = 29
    );
UPDATE email_log
SET is_open              = (
    CASE
        WHEN (SELECT COUNT(*) AS count
              FROM t
              WHERE t.log_id = email_log.id
                AND (
                      (action = 'is_open' AND t.is_tw_ip = true) OR
                      action = 'is_post_from_website'
                  )) > 0
            THEN true
        ELSE false END
    ),
    is_open_link         = (
        CASE
            WHEN (SELECT COUNT(*) AS count
                  FROM t
                  WHERE t.log_id = email_log.id
                    AND (
                          (action = 'is_open_link' AND t.is_tw_ip = true) OR
                          action = 'is_post_from_website'
                      )) > 0
                THEN true
            ELSE false END
        ),
    is_post_from_website = (
        CASE
            WHEN (SELECT COUNT(*) AS count
                  FROM t
                  WHERE t.log_id = email_log.id
                    AND action = 'is_post_from_website') > 0
                THEN true
            ELSE false END
        ),
    is_open_attachment   = (
        CASE
            WHEN (SELECT COUNT(*) AS count
                  FROM t
                  WHERE t.log_id = email_log.id
                    AND action = 'is_open_attachment') > 0
                THEN true
            ELSE false END
        )
WHERE email_log.job_id IN (SELECT email_job.id FROM email_job WHERE email_job.project_id = 29);
