SELECT 
    MIN(id) AS id,
    batch_id,
    sc_sm_id,
    MIN(created_on),
    MAX(updated_on),
    SUM(CASE
        WHEN status = 'IN-QUEUE' THEN 1
        ELSE 0
    END) AS cnt_inqueue,
    SUM(CASE
        WHEN status = 'IN-PROGRESS' THEN 1
        ELSE 0
    END) AS cnt_inprogress,
    SUM(CASE
        WHEN status = 'COMPLETED' THEN 1
        ELSE 0
    END) AS cnt_completed,
    SUM(CASE
        WHEN status = 'FAILED' THEN 1
        ELSE 0
    END) AS cnt_failed,
    COUNT(id) AS total
FROM
    `acc_bill_approval_process`
WHERE
    (created_on BETWEEN '2026-02-01 00:00:00' AND '2026-02-03 00:00:00')
        AND id > 34500638
        AND batch_id > 1109000
        AND updated_on IS NOT NULL
HAVING cnt_completed > 0;




SELECT 
    a.sc_sm_id,
    a.is_manual,
    a.batch_id,
    DATE(a.created_on) 'Date',
    COALESCE(a.updated_on),
    COUNT(DISTINCT a.batch_id) 'Total Batches Created',
    COUNT(a.id) T,
    COALESCE(SUM(a.status = 'IN-QUEUE'), 0) T_Q,
    COALESCE(SUM(a.status = 'IN-PROGRESS'), 0) T_IP,
    COALESCE(SUM(a.status = 'COMPLETED'), 0) T_C,
    COALESCE(SUM(a.status = 'FAILED'
                AND a.error_data IS NOT NULL),
            0) T_F,
    COALESCE(SUM(a.status = 'FAILED'
                AND a.error_data IS NULL),
            0) T_WO_E,
    COALESCE(a.error_data)
FROM
    acc_bill_generate_process a
WHERE
    a.id > 37891608
GROUP BY a.batch_id
HAVING T_Q + T_IP > 0;
