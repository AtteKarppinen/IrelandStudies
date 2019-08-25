CREATE OR REPLACE FUNCTION ADDMOVIE(
M_name movies.movie_name%TYPE,
M_duration movies.movie_duration%TYPE,
M_rating movies.rating%TYPE)
RETURN VARCHAR2 IS
  PRAGMA AUTONOMOUS_TRANSACTION; -- To allow commiting
  r_name VARCHAR2(50);    -- Name to be returned
  largest_id INTEGER;
  next_id INTEGER;
  movie_exists INTEGER;
BEGIN
  -- Fetch most recent id and add one before inserting
  SELECT MAX(movie_id) INTO largest_id FROM movies;
  next_id := largest_id + 1;

  -- If movie exists, do not add and inform user
  SELECT COUNT(*) INTO movie_exists FROM movies
  WHERE(M_name = movie_name);

  IF movie_exists > 0 THEN
    RETURN 'Movie already exists in database';
  ELSE
    INSERT INTO movies VALUES
      (next_id, M_name, M_duration, M_rating);

  -- Get and return the movie name
  SELECT movie_name INTO r_name FROM movies 
  WHERE (next_id = movie_id);
  
  COMMIT;
  RETURN r_name;
  END IF;

EXCEPTION
WHEN OTHERS THEN
  ROLLBACK;
  RAISE;
END ADDMOVIE;

-- Example SELECT statement:
-- SELECT dt2nn3_b7.ADDMOVIE('Added Movie Sequel', '3:10', '18only') FROM DUAL;
