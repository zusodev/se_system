# 先統計目前 log 筆數
SELECT COUNT(*)
FROM email_detail_logs
         JOIN email_log el on email_detail_logs.log_id = el.id
         JOIN email_job on el.job_id = email_job.id AND
                           email_job.project_id = ?;

# 驗證離職有沒有被過濾
SELECT *
FROM (
         SELECT I2.user_name,
                I2.department_name,
                I2.src_ip,
                INET_ATON(I2.src_ip) AS src_ipv4_num
         FROM (
                  SELECT I.user_name,
                         I.department_name,
                         SUBSTR(CAST(I.src_ip AS CHAR), 1, locate(',', I.src_ip) - 1) AS src_ip
                  FROM (
                           SELECT td.name                                                   AS `user_name`,
                                  tu.name                                                   AS `department_name`,
                                  JSON_VALUE(email_detail_logs.ips, '$.HTTP_X_FORWARD_FOR') AS src_ip
                           FROM email_detail_logs
                                    JOIN email_log ON email_detail_logs.log_id = email_log.id
                                    JOIN email_job job ON email_log.job_id = job.id AND
                                                          job.project_id = 29
                                    JOIN target_user tu ON email_log.target_user_id = tu.id
                                    JOIN target_department td ON job.department_id = td.id AND
                                                                 td.is_test = false
                               AND td.name LIKE '%離%'
                           ORDER BY td.name, tu.name
                       ) AS I
              ) AS I2
     ) AS I3
WHERE NOT (src_ipv4_num IS NULL AND
           src_ip LIKE '%2a01:111:f400%')
  AND NOT ((
        src_ipv4_num IS NOT NULL AND
        (
                (675938304 <= src_ipv4_num AND src_ipv4_num <= 679313407) OR
                (840925184 <= src_ipv4_num AND src_ipv4_num <= 840957951) OR
                (1815937024 <= src_ipv4_num AND src_ipv4_num <= 1816002559)
            )
    ));

# 取得要刪除的 id
SELECT email_detail_log_id
FROM (
         SELECT I2.email_detail_log_id,
                I2.user_name,
                I2.department_name,
                I2.src_ip,
                INET_ATON(I2.src_ip) AS src_ipv4_num
         FROM (
                  SELECT I.email_detail_log_id,
                         I.user_name,
                         I.department_name,
                         SUBSTR(CAST(I.src_ip AS CHAR), 1, locate(',', I.src_ip) - 1) AS src_ip
                  FROM (
                           SELECT email_detail_logs.id                                      AS email_detail_log_id,
                                  td.name                                                   AS `user_name`,
                                  tu.name                                                   AS `department_name`,
                                  JSON_VALUE(email_detail_logs.ips, '$.HTTP_X_FORWARD_FOR') AS src_ip
                           FROM email_detail_logs
                                    JOIN email_log ON email_detail_logs.log_id = email_log.id
                                    JOIN email_job job ON email_log.job_id = job.id AND
                                                          job.project_id = 29
                                    JOIN target_user tu ON email_log.target_user_id = tu.id
                                    JOIN target_department td ON job.department_id = td.id AND
                                                                 td.is_test = false
                               AND td.name LIKE '%離%'
                           ORDER BY td.name, tu.name
                       ) AS I
              ) AS I2
     ) AS I3
WHERE ((src_ipv4_num IS NULL AND
        src_ip LIKE '%2a01:111:f400%'))
   OR (
        src_ipv4_num IS NOT NULL AND
        (
                (675938304 <= src_ipv4_num AND src_ipv4_num <= 679313407) OR
                (840925184 <= src_ipv4_num AND src_ipv4_num <= 840957951) OR
                (1815937024 <= src_ipv4_num AND src_ipv4_num <= 1816002559)
            )
    );

# 刪除
DELETE
FROM email_detail_logs
WHERE id IN
      (1794, 1845, 1906, 1915, 1948, 1949, 2172, 2173, 2278, 2279, 2288, 2289, 2351, 2353, 2384, 2444, 2468, 2628, 2629,
       2643, 2644);

# 最後確認次數是不是第一次少
SELECT COUNT(*)
FROM email_detail_logs
         JOIN email_log el on email_detail_logs.log_id = el.id
         JOIN email_job on el.job_id = email_job.id AND
                           email_job.project_id = ?;

# 更新 log
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

