select
tsm.sc_sm_name ,
abm.bill_gen_pro_batch_id,
abm.sc_sm_id,
abgp.bill_type,
(CASE WHEN abgp.is_manual = '1' THEN 'MANUAL' ELSE 'ABS' END) AS billing_mode,
aabc.auto_approve  as autoapprove,
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
SUM(CASE WHEN ab.is_approved = 4 THEN 1 ELSE 0 END) AS 	ab_proforma,
SUM(CASE WHEN bap.status = 'IN-QUEUE' THEN 1 ELSE 0 END) AS bap_queue,
SUM(CASE WHEN bap.status = 'IN-PROGRESS' THEN 1 else 0 END) AS bap_progress,
SUM(CASE WHEN bap.status = 'FAILED' THEN 1 else 0 END) AS bap_failed
from acc_bills_mapping abm 
inner join tbl_society_master tsm on tsm.sc_sm_id  = abm.sc_sm_id 
inner join acc_bill_generate_process abgp on abgp	.id = abm.bill_gen_pro_id 
left join acc_bills ab on ab.bill_id = abm.bill_id 
left join acc_bill_approval_process bap on bap.id = abm.bill_apr_pro_id  
inner join acc_auto_bills_config aabc on aabc.sc_sm_id  = abm.sc_sm_id and abgp.bill_type = aabc.auto_bill_type and aabc.is_active  = 1 and aabc.is_deleted  = 0
where 
abm.created_on > '2026-02-01 00:00:00'  and auto_approve='1'
 and 
abgp.bill_type not in ('SOCIETY_BOOKING', 'CLASS_BOOKING', 'LEASE_MANAGEMENT')
GROUP BY abm.bill_gen_pro_batch_id
 HAVING billing_mode ='ABS' 
   -- and total_bill_to_approve = 0
 --  and ab_draft > 0
 --  and autoapprove = 1
 -- and abm.sc_sm_id  = 21
-- and abm.bill_gen_pro_batch_id  = 1043069
limit 10000;