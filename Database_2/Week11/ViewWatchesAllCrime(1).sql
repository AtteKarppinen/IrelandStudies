/*Add a viewer and record that he / she watches all crime shows*/
SET SERVEROUTPUT ON
DECLARE
  V_VIEWER_ID viewer.viewer_id%type :='&Enter_Viewer_id';
  V_SHOW_ID tv_show.show_id%type;
  V_VNAME     viewer.vname%type;
  V_WATCHCOUNT integer:= 0;
  V_NEWWATCH integer:=0;
--
  CURSOR crimes IS
    SELECT show_id FROM tv_show WHERE show_type LIKE 'Crime';
BEGIN
  SELECT vname INTO V_VNAME FROM viewer WHERE viewer_id LIKE in_viewer;
  OPEN crimes;
  LOOP
    FETCH crimes INTO V_SHOW_ID;
    EXIT WHEN crimes%notfound;
    select count(*) into V_WATCHCOUNT from watches
    where viewer_id = V_VIEWER_ID and show_id = V_SHOW_ID;
    dbms_output.put_line('Viewer '||V_VIEWER_ID||' watches '||V_SHOW_ID||
    ' '||V_WATCHCOUNT||' times.');
    if V_WATCHCOUNT = 0 then
    INSERT INTO watches VALUES(V_VIEWER_ID, V_SHOW_ID);
    V_NEWWATCH := V_NEWWATCH + 1;
    end if;
  END LOOP;
  DBMS_OUTPUT.PUT_LINE('There were '|| 
  crimes%rowcount||'  crime shows. Viewer '||
  V_VIEWER_ID||' has been added to '||V_NEWWATCH);
  CLOSE CRIMES;
  commit;
EXCEPTION
WHEN NO_DATA_FOUND THEN
  DBMS_OUTPUT.PUT_LINE('This viewer does not exist.');
  ROLLBACK WORK;
WHEN DUP_VAL_ON_INDEX THEN
  DBMS_OUTPUT.PUT_LINE('A viewer was found that already watches crime - the operation has failed.');
  ROLLBACK WORK;
WHEN  OTHERS THEN
  DBMS_OUTPUT.PUT_LINE ('The error '||SQLCODE||' has occurred.'||' meaning '||SQLERRM||'.');
  ROLLBACK WORK;
END;

