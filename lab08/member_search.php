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
    <form action = "member_search.php" method = "get">
        <fieldset>
            <legend><strong>Search VIP Member</strong></legend>
            <label for="lname">Last Name</label>
            <input type="text" name="lname"></br>
            <input type="submit" value="Sign" name="submit">
            <input type="reset" value="Reset Form" name="reset">
        </fieldset>
    </form>
    <?php
        if (isset($_GET["submit"])) {
            if (isset($_GET["lname"])) {
                $lname = trim($_GET["lname"]);
                if (!empty($lname) && strlen($lname) <= 40) {
                } else {
                    echo "<p>The last name can't be empty and must be <= 40 characters.</p>";
                }
            } else {
                echo "<p>Please enter last name.</p>";
            }
    
            require_once("settings.php");
            $conn = @mysqli_connect($host, $user, $pswd, $dbnm) or die('Failed to connect to server');
    
            $query = "SELECT member_id, fname, lname FROM vipmembers WHERE lname LIKE '%$lname%'";
            $queryResult = mysqli_query($conn, $query);
            if (!$queryResult) {
                echo "<p>Can't execute the query.</p>";
            } else {
                if (mysqli_num_rows($queryResult) == 0) {
                    echo "<p>No results found for the last name: $lname</p>";
                } else {
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
                }
                mysqli_free_result($queryResult); 
            }
            mysqli_close($conn);
        }
        
    ?>
    <a href="vip_member.php">Return to homepage</a><br>
</body>
</html>