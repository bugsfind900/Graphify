use erp;
select ag.id,ag.sc_sm_id,ag.batch_id,sm.sc_sm_name,ag.created_on from acc_bill_generate_process ag
inner join tbl_society_master sm on sm.sc_sm_id= ag.sc_sm_id and ag.is_manual='1'
 where  ag.created_on >= '2026-01-02 10:00:00' 
 and  ag.created_on <= '2026-01-04 13:50:00' and ag.status = 'IN-PROGRESS';

select * from erp.tbl_society_master where sc_sm_id ='16333';



select sc_sm_id,count(is_approved),created_on from erp.acc_bills 
where is_approved='0' and created_on >= '2026-01-01 00:00:00' 
and sc_sm_id IN('16093')
group by sc_sm_id;

use erp;
select a.sc_sm_id, a.is_manual, a.batch_id,date(a.created_on) 'Date',coalesce(a.updated_on), count(distinct a.batch_id) 'Total Batches Created', count(a.id) T, coalesce(sum(a.status = 'IN-QUEUE'), 0) T_Q, coalesce(sum(a.status = 'IN-PROGRESS'), 0) T_IP, coalesce(sum(a.status = 'COMPLETED'), 0) T_C, coalesce(sum(a.status = 'FAILED' AND a.error_data is not null), 0) T_F, coalesce(sum(a.status = 'FAILED' AND a.error_data is null), 0) T_WO_E, coalesce(a.error_data) FROM acc_bill_generate_process a where a.id > 70215690  group by a.batch_id having T_Q+T_IP > 0;


select * from erp.acc_bill_generate_process_batch where batch_id='958745';