-- Return the names of consumers who have eaten every type of crisp.
-- REWORDED Return names of consumers where there is no type of crisp they haven't eaten
SELECT * FROM crisp_type;
SELECT * FROM has_eaten;

SELECT cn_name
FROM consumer cn
WHERE NOT EXISTS
  (SELECT *
  FROM crisp_type ct
  WHERE NOT EXISTS
    (SELECT *
    FROM has_eaten e
    WHERE cn.consumerId = e.consumer
    AND ct.crispkey     = e.crispkey));

-- Return the names of staff members who have been paid by evey customer.
-- REWORDED Return names of staff members

-- Return the names of students who have passed all modules
-- REWORDED Return

-- Return a list of clubs that all undergraduate students joined (studylevel = 'UG')

-- CLUB IS A
-- JOINED IS X
-- STUDENTS IS B

CREATE OR REPLACE VIEW ugstudents AS (
  SELECT * FROM SSTUDENT WHERE studylevel = 'UG'
)

SELECT cname FROM CCLUB WHERE NOT EXISTS (
  SELECT * FROM ugstudents WHERE NOT EXISTS (
    SELECT * FROM JOINED WHERE (CCLUB.CLUBID = JOINED.CLUBID
    AND ugstudents.SNO = JOINED.SNO)));
