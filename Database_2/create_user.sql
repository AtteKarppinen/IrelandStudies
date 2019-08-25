-- Create a user with username patricia and password obyrne
--NOTE:  You can see your tablespaces by running 
--SELECT TABLESPACE_NAME from DBA_TABLESPACES - it'll probably be USERS
create user BUILDER2
identified by d18123298
default tablespace USERS
quota unlimited on USERS;
GRANT CREATE SESSION,
      CREATE TABLE, 
      CREATE VIEW,
      CREATE procedure,
      CREATE SEQUENCE,
      CREATE TRIGGER to BUILDER2;
undefine password;
undefine tbsp;
undefine username;
--alter user doreilly identified by C13469208;