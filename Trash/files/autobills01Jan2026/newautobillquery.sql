use erp;
select
abm.bill_gen_pro_batch_id,
abm.sc_sm_id,
abgp.bill_type,
(CASE WHEN abgp.is_manual = '1' THEN 'MANUAL' ELSE 'ABS' END) AS billing_mode,
abgp.created_on AS created_on,
count(abm.bill_gen_pro_id ) as total_bill_to_generate,
COALESCE(SUM(abgp.status = 'COMPLETED'), 0) as total_completed_in_consumer,    
count(abm.bill_apr_pro_id ) as total_bill_to_approve,	
SUM(CASE WHEN bap.status = 'COMPLETED' THEN 1 else 0 END) AS total_approval_completed,
SUM(CASE WHEN ab.is_approved = 1 THEN 1 ELSE 0 END) AS total_bill_generated,
COALESCE(SUM(abgp.status = 'IN-QUEUE'), 0) as abgp_queue,    
COALESCE(SUM(abgp.status = 'IN-PROGRESS'), 0)  as abgp_process,      
COALESCE(SUM(abgp.status = 'FAILED'),0) as abgp_failed,
SUM(CASE WHEN ab.is_approved = 0 THEN 1 ELSE 0 END) AS ab_draft,
SUM(CASE WHEN ab.is_approved = 2 THEN 1 ELSE 0 END) AS ab_deleted,
SUM(CASE WHEN ab.is_approved = 3 THEN 1 ELSE 0 END) AS ab_cancelled, 
SUM(CASE WHEN ab.is_approved = 4 THEN 1 ELSE 0 END) AS ab_proforma,
SUM(CASE WHEN bap.status = 'IN-QUEUE' THEN 1 ELSE 0 END) AS bap_queue,
SUM(CASE WHEN bap.status = 'IN-PROGRESS' THEN 1 else 0 END) AS bap_progress,
SUM(CASE WHEN bap.status = 'FAILED' THEN 1 else 0 END) AS bap_failed
from acc_bills_mapping abm 
inner join acc_bill_generate_process abgp on abgp.id = abm.bill_gen_pro_id 
left join acc_bills ab on ab.bill_id = abm.bill_id 
left join acc_bill_approval_process bap on bap.id = abm.bill_apr_pro_id  
where 
abm.created_on > '2026-01-01 00:00:00' 
 and 
abgp.bill_type not in ('SOCIETY_BOOKING', 'CLASS_BOOKING', 'LEASE_MANAGEMENT','SYSTEM_MOVE_IN_MOVE_OUT')
GROUP BY abm.bill_gen_pro_batch_id
HAVING billing_mode ='ABS'














;

select 
abm.bill_gen_pro_batch_id,
abm.sc_sm_id,
abgp.bill_type,
(CASE WHEN abgp.is_manual = '1' THEN 'MANUAL' ELSE 'ABS' END) AS billing_mode,
abgp.created_on AS created_on,
count(abm.bill_gen_pro_id ) as total_bill_to_generate,
COALESCE(SUM(abgp.status = 'COMPLETED'), 0) as total_completed_in_consumer,
count(abm.bill_apr_pro_id ) as total_bill_to_approve,	
SUM(CASE WHEN bap.status = 'COMPLETED' THEN 1 else 0 END) AS total_approval_completed,
SUM(CASE WHEN ab.is_approved = 1 THEN 1 ELSE 0 END) AS total_bill_generated,
COALESCE(SUM(abgp.status = 'IN-QUEUE'), 0) as abgp_queue,
COALESCE(SUM(abgp.status = 'IN-PROGRESS'), 0)  as abgp_process,
COALESCE(SUM(abgp.status = 'FAILED'),0) as abgp_failed,
SUM(CASE WHEN ab.is_approved = 0 THEN 1 ELSE 0 END) AS ab_draft,
SUM(CASE WHEN ab.is_approved = 2 THEN 1 ELSE 0 END) AS ab_deleted,
SUM(CASE WHEN ab.is_approved = 3 THEN 1 ELSE 0 END) AS ab_cancelled,
SUM(CASE WHEN ab.is_approved = 4 THEN 1 ELSE 0 END) AS ab_proforma,
SUM(CASE WHEN bap.status = 'IN-QUEUE' THEN 1 ELSE 0 END) AS bap_queue,
SUM(CASE WHEN bap.status = 'IN-PROGRESS' THEN 1 else 0 END) AS bap_progress,
SUM(CASE WHEN bap.status = 'FAILED' THEN 1 else 0 END) AS bap_failed
from acc_bills_mapping abm
inner join acc_bill_generate_process abgp on abgp.id = abm.bill_gen_pro_id
left join acc_bills ab on ab.bill_id = abm.bill_id
left join acc_bill_approval_process bap on bap.id = abm.bill_apr_pro_id
where
abm.created_on > '2026-01-01 00:00:00'
 and
abgp.bill_type not in ('SOCIETY_BOOKING', 'CLASS_BOOKING', 'LEASE_MANAGEMENT','SYSTEM_MOVE_IN_MOVE_OUT')
GROUP BY date(abm.created_on)
HAVING billing_mode ='ABS'
