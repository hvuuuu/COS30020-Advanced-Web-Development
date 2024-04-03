<!DOCTYPE html>
<html>
<head>
<title>Guest Book</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    <?php
    // validate input
    if (empty($_GET['first_name']) || empty($_GET['last_name']))
        die("<p>You must enter your first and last name! Click your browser's Back button to return to the Guest Book form.</p>");

    // select database
    $DBConnect = @mysqli_connect("feenix-mariadb.swin.edu.au", "s104177995", "180804")
        or die("<p>Unable to connect to the database server.</p>"
        . "<p>Error code " . mysqli_connect_error()
        . ": " . mysqli_connect_error()) . "</p>";

    // select and create database
	$DBName = "s104177995_db";
	try {
		@mysqli_select_db($DBConnect, $DBName);
	} catch (mysqli_sql_exception $exception) {
		$SQLstring = "CREATE DATABASE $DBName";
		$QueryResult = @mysqli_query($DBConnect, $SQLstring)
			or die("<p>Unable to execute the query.</p>"
			. "<p>Error code " . mysqli_error($DBConnect)
			. ": " . mysqli_error($DBConnect)) . "</p>";
		echo "<p>You are the first visitor!</p>";
		mysqli_select_db($DBConnect, $DBName);
	}

    // create table if necessary
	$TableName = "visitors";
	try {
		$SQLstring = "SELECT * FROM $TableName";
		$QueryResult = @mysqli_query($DBConnect, $SQLstring);
	} catch (mysqli_sql_exception $exception) {
		$SQLstring = "CREATE TABLE $TableName (countID SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY, last_name VARCHAR(40), first_name VARCHAR(40))";
		$QueryResult = @mysqli_query($DBConnect, $SQLstring)
			Or die("<p>Unable to create the table.</p>"
			. "<p>Error code " . mysqli_error($DBConnect)
			. ": " . mysqli_error($DBConnect)) . "</p>";
	}
    
    // sign
    $LastName = addslashes($_GET['last_name']);
    $FirstName = addslashes($_GET['first_name']);
    $SQLstring = "INSERT INTO $TableName VALUES(NULL, '$LastName', '$FirstName')";
    $QueryResult = @mysqli_query($DBConnect, $SQLstring)
        Or die("<p>Unable to execute the query.</p>"
            . "<p>Error code " . mysqli_error($DBConnect)
            . ": " . mysqli_error($DBConnect)) . "</p>";
    echo "<h1>Thank you for signing our guest book!</h1>";
    mysqli_close($DBConnect);
    ?>
</body>
</html>