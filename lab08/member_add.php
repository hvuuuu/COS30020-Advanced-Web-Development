<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Huy Vu Tran" />
    <title>Member Add</title>
</head>
<body>
    <h1>Member Add</h1>
    <?php
        require_once("settings.php");
        $conn = @mysqli_connect($host, $user, $pswd, $dbnm) or die('Failed to connect to server');

        $query = "CREATE TABLE IF NOT EXISTS vipmembers(
            member_id INT AUTO_INCREMENT,
            fname VARCHAR(40) NOT NULL,
            lname VARCHAR(40) NOT NULL,
            gender VARCHAR(1) NOT NULL,
            email VARCHAR(40) NOT NULL,
            phone VARCHAR(20) NOT NULL,
            PRIMARY KEY (member_id)
        )";

        $queryResult = mysqli_query($conn, $query);
        if($queryResult) {
            echo "<p>Table created successfully.</p>";
        } else {
            echo "<p>Table created failed.</p>";
        }

        function validateInput($input, $type, $maxLength) {
            if (isset($_POST[$input])) {
                $value = trim($_POST[$input]);
                if (!empty($value) && strlen($value) <= $maxLength) {
                    if ($type == 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        return "Your email must match the correct format.";
                    } elseif ($type == 'phone' && !preg_match('/^[0-9]+$/', $value)) {
                        return "Your phone must match the correct format.";
                    } elseif ($type == 'gender' && strtoupper($value) == ['M', 'F']) {
                        return "Your gender must be either M or F.";
                    } else {
                        return $value;
                    }
                } else {
                    return "Your $type can't be empty and must be <= $maxLength characters.";
                }
            } else {
                return "Please enter your $type.";
            }
        }

        $fname = validateInput("fname", "first name", 40);
        $lname = validateInput("lname", "last name", 40);
        $gender = validateInput("gender", "gender", 1);
        $email = validateInput("email", "email", 40);
        $phone = validateInput("phone", "phone", 20);

        $errors = [];

        if (strpos($fname, 'first name') !== false) {
            $errors[] = $fname;
        }
        
        if (strpos($lname, 'last name') !== false) {
            $errors[] = $lname;
        }
        
        if (strpos($gender, 'gender') !== false) {
            $errors[] = $gender;
        }
        
        if (strpos($email, 'email') !== false) {
            $errors[] = $email;
        }
        
        if (strpos($phone, 'phone') !== false) {
            $errors[] = $phone;
        }
        if (empty($errors)) {
            $queryAdd = "INSERT INTO vipmembers (fname, lname, gender, email, phone) VALUES ('$fname', '$lname', '$gender', '$email', '$phone')";
            $queryAddResult = mysqli_query($conn, $queryAdd);

            if($queryAddResult) {
                echo "<p>Add successfully.</p>";
            } else {
                echo "<p>Add failed.</p>";
            }
        } else {
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
        }

        mysqli_close($conn);


    ?>
    <a href="vip_member.php">Return to homepage</a><br>
</body>
</html>