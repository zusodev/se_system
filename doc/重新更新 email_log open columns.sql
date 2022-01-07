DROP TABLE if exists t;
CREATE TEMPORARY TABLE t
    (
        SELECT *
        FROM email_detail_logs
        GROUP BY log_id,
                 action
    );
UPDATE email_log
SET is_open              = (
    CASE
        WHEN (SELECT COUNT(*) AS count
              FROM t
              WHERE t.log_id = email_log.id
                AND action = 'is_open') > 0
            THEN true
        ELSE false END
    ),
    is_open_link         = (
        CASE
            WHEN (SELECT COUNT(*) AS count
                  FROM t
                  WHERE t.log_id = email_log.id
                    AND action = 'is_open_link') > 0
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
WHERE email_log.job_id IN (SELECT email_job.id FROM email_job WHERE email_job.project_id = ?);
