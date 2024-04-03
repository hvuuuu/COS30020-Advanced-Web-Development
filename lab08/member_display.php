<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Huy Vu Tran" />
    <title>Member Display</title>
</head>
<body>
    <h1>Member Display</h1>
    <?php
        require_once("settings.php");
        $conn = @mysqli_connect($host, $user, $pswd, $dbnm) or die('Failed to connect to server');

        $query = "SELECT member_id, fname, lname FROM vipmembers";
        $queryResult = mysqli_query($conn, $query);


        echo "<table border='1'>"; 
        echo "<tr>
                <th>Member ID</th><th>First Name</th> 
                <th>Last Name</th></tr>"; 
        while ($row = mysqli_fetch_row($queryResult)) {
            echo "<tr><td>{$row[0]}</td>"; 
            echo "<td>{$row[1]}</td>"; 
            echo "<td>{$row[2]}</td></tr>"; 
        } 
        echo "</table>";

        mysqli_free_result($queryResult); 
        mysqli_close($conn);
    ?>
    <a href="vip_member.php">Return to homepage</a><br>
</body>
</html>