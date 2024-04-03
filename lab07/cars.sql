

-- all records --
SELECT * FROM cars;

-- make, model, price sorted by make and model --
SELECT make, model, price FROM cars ORDER BY make, model;

-- the make and model of the cars which cost $20000 or more --
SELECT make, model FROM cars WHERE price >= 20000;

-- the make and model of the cars which cost below $15000 --
SELECT make, model FROM cars WHERE price < 15000;

-- the average price of cars for similar make --
SELECT make, AVG(price) AS average FROM cars GROUP BY make;