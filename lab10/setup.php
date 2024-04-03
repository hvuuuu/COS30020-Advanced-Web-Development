<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Huy Vu Tran" />
    <title>Setup Page</title>
</head>
<body>
    <h1>Hit Counter Table Add Form</h1>
    <form action = "setup.php" method = "post">
        <label for="host">Host</label>
        <input type="text" name="host"></br>
        <label for="name">Username</label>
        <input type="text" name="name"></br>
        <label for="password">Password</label>
        <input type="text" name="password"></br>
        <label for="dbname">Database Name</label>
        <input type="text" name="dbname"></br>
        <input type="submit" value="Sign" name="submit">
        <input type="reset" value="Reset Form" name="reset">
    </form>
    <?php
        function validateInput($input, $type) {
            if (isset($_POST[$input])) {
                $value = trim($_POST[$input]);
                if (empty($value)) {
                    return "Your $type can't be empty.";
                } else {
                    return $value; // return the actual value
                }
            } else {
                return "Please enter your $type.";
            }
        }

        $host = validateInput("host", "host");
        $username = validateInput("name", "username");
        $password = validateInput("password", "password");
        $dbname = validateInput("dbname", "database name");

        $errors = [];

        if (strpos($host, 'host') !== false) {
            $errors[] = $host;
        }
        
        if (strpos($username, 'username') !== false) {
            $errors[] = $username;
        }
        
        if (strpos($password, 'password') !== false) {
            $errors[] = $password;
        }
        
        if (strpos($dbname, 'database name') !== false) {
            $errors[] = $dbname;
        }

        if (empty($errors)) {

            $conn = @mysqli_connect($host, $username, $password, $dbname) or die('Failed to connect to server');

            $query = "CREATE TABLE IF NOT EXISTS hitcounter(
                id SMALLINT NOT NULL,
                hits SMALLINT NOT NULL,
                PRIMARY KEY (id)
            )";
            
            $queryResult = mysqli_query($conn, $query);

            $insertQuery = "INSERT INTO hitcounter (id, hits) VALUES (1, 0)";
            $insertQueryResult = mysqli_query($conn, $insertQuery);

            if($queryResult && $insertQueryResult) {
                echo "<p>Setup sucessfully.</p>";
            } elseif ($queryResult) {
                echo "<p>Table created successfully and row already exists.</p>";
            } elseif ($insertQueryResult) {
                echo "<p>Row inserted successfully and table already exists.</p>";
            } else {
                echo "<p>Setup failed.</p>";
            }

            umask(0007);
            $dir = "../../data/lab10";
            if (!file_exists($dir)) {
                mkdir($dir, 02770);
            }

            $filename = "../../data/lab10/mykeys.inc.php";
            $handle = fopen($filename, "w");
            $data = "<?php\n\$host = '{$host}';\n\$username = '{$username}';\n\$password = '{$password}';\n\$dbname = '{$dbname}';\n?>";
            fwrite($handle, $data);
            fclose($handle);
        }

    ?>
</body>
</html>