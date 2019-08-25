DROP TABLE movies CASCADE CONSTRAINT;
DROP TABLE viewings CASCADE CONSTRAINT;
DROP TABLE customers CASCADE CONSTRAINT;
DROP TABLE sales CASCADE CONSTRAINT;
DROP TABLE screens CASCADE CONSTRAINT;

CREATE TABLE movies
(
    movie_id INT NOT NULL,
    movie_name VARCHAR(30) NOT NULL,
    movie_duration VARCHAR(30) NOT NULL,
    rating VARCHAR(30),
    PRIMARY KEY(movie_id)
);

CREATE TABLE viewings
(
    viewing_id INT NOT NULL,
    start_time VARCHAR(30),
    movie_id INT NOT NULL,
    screen_number INT NOT NULL,
    PRIMARY KEY(viewing_id),
    FOREIGN KEY(movie_id) REFERENCES movies
);

CREATE TABLE customers
(
    customer_id INT NOT NULL,
    customer_name VARCHAR(30) NOT NULL,
    card_number NUMBER NOT NULL,
    PRIMARY KEY(customer_id)
);

CREATE TABLE sales
(
    sale_id INT NOT NULL,
    sale_date TIMESTAMP NOT NULL,
    ticket_amount INT NOT NULL,
    seating_type VARCHAR(30) NOT NULL,
    viewing_id INT NOT NULL,
    customer_id INT NOT NULL,
    PRIMARY KEY(sale_id),
    FOREIGN KEY(viewing_id) REFERENCES viewings
);

CREATE TABLE screens
(
    screen_number INT NOT NULL,
    capacity INT NOT NULL,
    PRIMARY KEY(screen_number)
);

-- ALTER TABLE movies
-- ADD FOREIGN KEY(screen_number) REFERENCES viewings;

ALTER TABLE viewings
ADD FOREIGN KEY(screen_number) REFERENCES screens;

-- Why should customer reference to anything?
-- ALTER TABLE customers
-- ADD FOREIGN KEY(card_number) REFERENCES sales;

ALTER TABLE sales
ADD FOREIGN KEY(customer_id) REFERENCES customers;

-- Populate Tables
-- Screens
INSERT INTO screens VALUES(1, 250);
INSERT INTO screens VALUES(2, 150);
INSERT INTO screens VALUES(3, 75);
INSERT INTO screens VALUES(4, 140);
INSERT INTO screens VALUES(5, 100);
INSERT INTO screens VALUES(6, 40);
INSERT INTO screens VALUES(7, 100);
INSERT INTO screens VALUES(8, 150);
INSERT INTO screens VALUES(9, 200);
INSERT INTO screens VALUES(10, 185);

-- Movies
INSERT INTO movies VALUES(1, 'Lord of the Two Towers', '2:00', '12PG');
INSERT INTO movies VALUES(2, 'The Importance of Ear', '1:50', 'U');
INSERT INTO movies VALUES(3, 'Einstein''s Big Adventure', '1:30', 'U');
INSERT INTO movies VALUES(4, 'The House of Horrors', '2:00', '15PG');
INSERT INTO movies VALUES(5, 'Beautiful Horizons', '2:00', '12PG');
INSERT INTO movies VALUES(6, 'Marion and Michelle', '2:30', '18only');

-- Viewings
INSERT INTO viewings VALUES(1, '11:30', 1, 1);
INSERT INTO viewings VALUES(2, '13:00', 2, 2);
INSERT INTO viewings VALUES(3, '13:00', 1, 1);
INSERT INTO viewings VALUES(4, '14:00', 3, 3);
INSERT INTO viewings VALUES(5, '15:00', 4, 2);
INSERT INTO viewings VALUES(6, '15:15', 5, 1);
INSERT INTO viewings VALUES(7, '15:45', 2, 3);
INSERT INTO viewings VALUES(8, '17:15', 4, 2);
INSERT INTO viewings VALUES(9, '18:00', 6, 1);
INSERT INTO viewings VALUES(10, '18:15', 4, 3);
INSERT INTO viewings VALUES(11, '19:30', 2, 2);
INSERT INTO viewings VALUES(12, '20:15', 6, 1);
INSERT INTO viewings VALUES(13, '21:30', 1, 2);
INSERT INTO viewings VALUES(14, '22:00', 4, 3);

-- Customers
INSERT INTO customers VALUES(1, 'John Doe', 1234);
INSERT INTO customers VALUES(2, 'Jane Doe', 6421);
INSERT INTO customers VALUES(3, 'Peter Mulligan', 7776);
INSERT INTO customers VALUES(4, 'Cathelyn Parker', 9081);

-- Sales
INSERT INTO sales VALUES(1, to_date('02-07-2014', 'DD-MM-YYYY'), 1, 'Premium', 9, 1);
INSERT INTO sales VALUES(2, to_date('03-07-2014', 'DD-MM-YYYY'), 3, 'Standard', 4, 2);
INSERT INTO sales VALUES(3, to_date('04-07-2014', 'DD-MM-YYYY'), 2, 'Standard', 7, 3);
INSERT INTO sales VALUES(4, to_date('05-07-2014', 'DD-MM-YYYY'), 15, 'Premium', 12, 4);
INSERT INTO sales VALUES(5, to_date('06-07-2014', 'DD-MM-YYYY'), 14, 'Premium', 14, 4);

-- Test queries
SELECT customer_name, card_number
FROM customers
WHERE customer_id IN (
    SELECT customer_id
    FROM sales
    WHERE customer_id = 1
);

SELECT sales.*, customers.card_number
FROM sales
JOIN customers ON customers.customer_id = sales.customer_id;

-- View that has all the good stuff
CREATE OR REPLACE VIEW BJUUTIFUL AS (
    SELECT customers.customer_name AS Name, customers.customer_id AS ID, customers.card_number AS Card,
    sales.ticket_amount AS Tickets, sales.seating_type AS Seats,
    viewings.screen_number AS Screen, viewings.start_time AS Start_Time,
    movies.movie_name AS Movie, movies.movie_duration AS Duration, movies.rating AS Rating
    FROM customers
    JOIN sales ON sales.customer_id = customers.customer_id
    JOIN viewings ON viewings.viewing_id = sales.viewing_id
    JOIN movies ON movies.movie_id = viewings.movie_id
);