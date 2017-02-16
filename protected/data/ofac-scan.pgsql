CREATE VIEW phonetic_filtered AS

SELECT
  source.phonetic_data_entity_class AS filtered_source_entity_class,
  source.phonetic_data_entity_id AS filtered_source_entity_id,
  result.phonetic_data_entity_class AS filtered_result_entity_class,
  result.phonetic_data_entity_id AS filtered_result_entity_id,
  'name' AS data_type,
  COUNT( source.phonetic_data_key ) as total_hits
FROM
  phonetic_data source
  JOIN phonetic_data result
  ON
  (
    source.phonetic_data_encoding_method = result.phonetic_data_encoding_method
    AND source.phonetic_data_type = result.phonetic_data_type
    AND source.phonetic_data_key = result.phonetic_data_key
    AND result.phonetic_data_entity_class IN ( 'OfacSdn', 'OfacAlt' )
  )
WHERE
  source.phonetic_data_entity_class NOT IN ( 'OfacSdn', 'OfacAlt' )
  AND source.phonetic_data_type IN ( 'last_name', 'first_name' )
GROUP BY
  result.phonetic_data_entity_class,
  source.phonetic_data_entity_class,
  source.phonetic_data_entity_id,
  result.phonetic_data_entity_id
HAVING COUNT( source.phonetic_data_key ) >= 5

UNION

SELECT
  source.phonetic_data_entity_class AS filtered_source_entity_class,
  source.phonetic_data_entity_id AS filtered_source_entity_id,
  result.phonetic_data_entity_class AS filtered_result_entity_class,
  result.phonetic_data_entity_id AS filtered_result_entity_id,
  'company' AS data_type,
  COUNT( source.phonetic_data_key ) as total_hits
FROM
  phonetic_data source
  JOIN phonetic_data result
  ON
  (
    source.phonetic_data_encoding_method = result.phonetic_data_encoding_method
    AND source.phonetic_data_type = result.phonetic_data_type
    AND source.phonetic_data_key = result.phonetic_data_key
    AND result.phonetic_data_entity_class IN ( 'OfacSdn', 'OfacAlt' )
  )
WHERE
  source.phonetic_data_entity_class NOT IN ( 'OfacSdn', 'OfacAlt' )
  AND source.phonetic_data_type IN ( 'company' )
GROUP BY
  result.phonetic_data_entity_class,
  source.phonetic_data_entity_class,
  source.phonetic_data_entity_id,
  result.phonetic_data_entity_id
HAVING COUNT( source.phonetic_data_key ) >= 2;

