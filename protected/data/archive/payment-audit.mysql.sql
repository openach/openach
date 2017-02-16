SELECT
  payment_event_log.payment_schedule_amount, 
  payment_schedule.payment_schedule_amount 
FROM
  payment_event_log, payment_schedule
WHERE
  payment_event_log.payment_schedule_id = payment_schedule.payment_schedule_id
  AND payment_schedule.payment_schedule_amount != payment_event_log.payment_schedule_amount;

SELECT
  payment_event_log.payment_schedule_amount, 
  ach_entry_detail_amount / 100 as ach_entry_detail_amount
FROM
  payment_event_log, ach_entry
WHERE
  payment_event_log.ach_entry_id = ach_entry.ach_entry_id
  AND payment_event_log.payment_schedule_id = ach_entry_payment_schedule_id
  AND (ach_entry_detail_amount / 100 ) != payment_event_log.payment_schedule_amount;

SELECT
  payment_event_log.payment_schedule_amount, 
  ach_entry_detail_amount / 100 as ach_entry_detail_amount
FROM
  payment_event_log, ach_entry
WHERE
  payment_event_log.payment_schedule_id = ach_entry_payment_schedule_id
  AND payment_event_log.ach_entry_id = ach_entry.ach_entry_id
  AND (ach_entry_detail_amount / 100 ) != payment_event_log.payment_schedule_amount;



SELECT 
  payment_type_originator_info_id,
  payment_type_transaction_type,
  SUM( payment_schedule_amount ) AS total
FROM
  payment_event_log,
  payment_type
WHERE
  payment_schedule_payment_type_id = payment_type_id
GROUP BY payment_type_originator_info_id, payment_type_transaction_type;

SELECT
  ach_file_originator_info_id,
  SUM( ach_file_control_total_debits ) AS total_debits,
  SUM( ach_file_control_total_credits ) AS total_credits
FROM
  ach_file
GROUP BY ach_file_originator_info_id;

SELECT
  ach_file_originator_info_id, SUM( ach_entry_detail_amount ) AS total
FROM
  ach_entry
JOIN ach_batch ON ( ach_entry_ach_batch_id = ach_batch_id )
JOIN ach_file ON ( ach_batch_ach_file_id = ach_file_id )
JOIN payment_schedule ON ( ach_entry_payment_schedule_id = payment_schedule_id )
JOIN payment_type ON ( payment_schedule_payment_type_id = payment_type_id AND payment_type_transaction_type = 'credit' )
GROUP BY ach_file_originator_info_id;

SELECT
  ach_file_originator_info_id, SUM( ach_entry_detail_amount ) AS total
FROM
  ach_entry
JOIN ach_batch ON ( ach_entry_ach_batch_id = ach_batch_id )
JOIN ach_file ON ( ach_batch_ach_file_id = ach_file_id )
JOIN payment_schedule ON ( ach_entry_payment_schedule_id = payment_schedule_id )
JOIN payment_type ON ( payment_schedule_payment_type_id = payment_type_id AND payment_type_transaction_type = 'debit' )
GROUP BY ach_file_originator_info_id;

