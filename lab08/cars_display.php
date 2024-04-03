<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Huy Vu Tran" />
    <title>TITLE</title>
</head>
<body>
    <h1>Web Programming - Lab08</h1>
    <?php
        require_once("settings.php");
        $conn = @mysqli_connect($host, $user, $pswd, $dbnm) or die('Failed to connect to server');

        $query = "SELECT car_id, make, model, price FROM cars";
        $queryResult = mysqli_query($conn, $query);


        echo "<table width='100%' border='1'>"; 
        echo "<tr>
                <th>Car_ID</th><th>Make</th> 
                <th>Model</th><th>Price</th></tr>"; 
        while ($row = mysqli_fetch_row($queryResult)) {
            echo "<tr><td>{$row[0]}</td>"; 
            echo "<td>{$row[1]}</td>"; 
            echo "<td>{$row[2]}</td>"; 
            echo "<td>{$row[3]}</td></tr>"; 
        } 
        echo "</table>";

        mysqli_free_result($queryResult); 
        mysqli_close($conn);
    ?>

</body>
</html>