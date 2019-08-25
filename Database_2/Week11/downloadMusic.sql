SET SERVEROUTPUT ON
DECLARE
  V_ARTIST_NAME musictrack.t_artist%TYPE :='&Enter band name';
  V_LOVERS_NAME musiclover.l_name%TYPE :='&Enter music lover''s name';
  V_LOVERS_ID musiclover.l_id%TYPE;
  V_NOT_LOADED INTEGER := 0;
--
-- Save track id's that user loves in cursor
  CURSOR downloader IS
    SELECT t_id 
    FROM downloaded
    WHERE l_id IN (
      SELECT  l_id FROM musiclover 
      WHERE l_name LIKE CONCAT(CONCAT('%', V_LOVERS_NAME), '%')
    )
    AND t_id IN (
      SELECT t_id FROM musictrack
      WHERE t_artist LIKE CONCAT(CONCAT('%', V_ARTIST_NAME), '%')
    );

  TRACK_ID downloader%ROWTYPE;

BEGIN
  OPEN downloader;  

  -- Save music lover's id
  SELECT  l_id INTO V_LOVERS_ID FROM musiclover 
  WHERE l_name LIKE CONCAT(CONCAT('%', V_LOVERS_NAME), '%');

  LOOP
    FETCH downloader INTO TRACK_ID; -- Fetch row (t_id) into records
    EXIT WHEN downloader%NOTFOUND;  -- Exit when no more records

    -- Return one if record is not already in downloaded table
    SELECT 1 INTO V_NOT_LOADED 
    FROM musictrack
    WHERE t_id != TRACK_ID
    AND t_artist LIKE CONCAT(CONCAT('%', V_ARTIST_NAME), '%');

    IF V_NOT_LOADED = 1 THEN
      INSERT INTO downloaded VALUES(TRACK_ID, V_LOVERS_ID, CURRENT_DATE);
      V_NOT_LOADED := 0;
    END IF;
    
  END LOOP;
  CLOSE downloader;
  COMMIT;

EXCEPTION
  WHEN NO_DATA_FOUND THEN
    DBMS_OUTPUT.PUT_LINE('This music lover does not exist.');
    ROLLBACK WORK;
  WHEN DUP_VAL_ON_INDEX THEN
    DBMS_OUTPUT.PUT_LINE('A music lover was found that already loves this track - the operation has failed.');
    ROLLBACK WORK;
  WHEN  OTHERS THEN
    DBMS_OUTPUT.PUT_LINE ('The error '||SQLCODE||' has occurred.'||' meaning '||SQLERRM||'.');
    ROLLBACK WORK;

END;




SELECT COUNT(*) FROM musictrack
WHERE t_id NOT IN (
  SELECT t_id FROM downloaded
  WHERE l_id = 1
)
AND t_artist LIKE CONCAT(CONCAT('%', 'Oasis'), '%')
AND ROWNUM = 1;


SELECT * FROM downloaded;
SELECT * FROM musictrack;
SELECT * FROM musiclover;


SELECT t_id 
FROM downloaded
WHERE l_id IN (
  SELECT  l_id FROM musiclover 
  WHERE l_name LIKE CONCAT(CONCAT('%', 'Carina'), '%')
)
AND t_id IN (
  SELECT t_id FROM musictrack
  WHERE t_artist LIKE CONCAT(CONCAT('%', 'Eagles'), '%')
);