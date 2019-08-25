-- Selection
SELECT * FROM dt2nn3_b7.sales 
WHERE customer_id = 2;

-- Projection
SELECT ticket_amount AS Tickets_sold, seating_type AS Type, customer_id AS Customer
FROM dt2nn3_b7.sales;

-- Aggregation with filters on aggregates. Returns count of movies with same age ratings
SELECT COUNT(movie_name), rating
FROM dt2nn3_b7.movies
GROUP BY rating
HAVING COUNT(rating) > 1;

-- Union. Unifies customers and their tickets they have bought
SELECT customer_id AS ID, 
seating_type AS Name_And_Type, 
ticket_amount AS Card_Tickets
FROM dt2nn3_b7.sales
UNION
SELECT * FROM dt2nn3_b7.Customers
ORDER BY ID;

-- Minus. Returns movies that have no screen time at the moment
SELECT movie_id FROM dt2nn3_b7.movies
MINUS
SELECT movie_id FROM dt2nn3_b7.viewings;

-- Difference. Left joins returns all movies. Right join returns all movies in both tables. Intersect returns identical rows
SELECT m.movie_name, v.start_time
FROM dt2nn3_b7.movies m
LEFT JOIN dt2nn3_b7.viewings v ON v.movie_id = m.movie_id
INTERSECT
SELECT m.movie_name, v.start_time
FROM dt2nn3_b7.movies m
RIGHT JOIN dt2nn3_b7.viewings v ON v.movie_id = m.movie_id;


-- Inner Join. Returns customers that appear in both tables and name is Peter. See Outer Join:
SELECT dt2nn3_b7.customers.customer_name, dt2nn3_b7.sales.ticket_amount, dt2nn3_b7.sales.seating_type
FROM dt2nn3_b7.customers
INNER JOIN dt2nn3_b7.sales ON dt2nn3_b7.sales.customer_id = dt2nn3_b7.customers.customer_id
WHERE dt2nn3_b7.customers.customer_name LIKE '%Peter%';

-- Outer Join. Same query except return all customers named Peter, regardless if they appear on sales or not.
SELECT dt2nn3_b7.customers.customer_name, dt2nn3_b7.sales.ticket_amount, dt2nn3_b7.sales.seating_type
FROM dt2nn3_b7.customers
LEFT JOIN dt2nn3_b7.sales ON dt2nn3_b7.sales.customer_id = dt2nn3_b7.customers.customer_id
WHERE dt2nn3_b7.customers.customer_name LIKE '%Peter%';

-- Semi Join. Returns movies (each only once) that are in the viewings table
SELECT m.movie_id, m.movie_name
FROM dt2nn3_b7.movies m
WHERE EXISTS(
    SELECT 1
    FROM dt2nn3_b7.viewings v
    WHERE v.movie_id = m.movie_id
);

-- Anti-join. Returns movies that are not in the viewings table
SELECT m.movie_id, m.movie_name
FROM dt2nn3_b7.movies m
WHERE m.movie_id NOT IN (
    SELECT v.movie_id
    FROM dt2nn3_b7.viewings v
);

-- Correlated sub-query. Returns all sale records of a customer named Cathelyn
SELECT * FROM dt2nn3_b7.sales s
WHERE s.customer_id = (
    SELECT c.customer_id
    FROM dt2nn3_b7.customers c
    WHERE c.customer_name LIKE '%Cathelyn%'
);