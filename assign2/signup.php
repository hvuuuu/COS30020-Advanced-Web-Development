<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags and Bootstrap CSS link -->
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Huy Vu Tran" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Sign Up Page</title>
</head>
<body>
    <div class="container-fluid p-5 text-black ">
        <!-- Registration form -->
        <form action = "signup.php" method = "post">
            <h2>My Friend System Registration Page</h2><br />
            <!-- Email input field -->
            <div class="mb-3 mt-3">
                <label for="email">Email</label>
                <input type="text" class="form-control" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"><br />
                <!-- Display email errors -->
                <?php if (isset($errors['email'])) echo "<p>" . htmlspecialchars($errors['email']) . "</p>"; ?>
            </div>
            <!-- Profile name input field -->
            <div class="mb-3">
                <label for="name">Profile Name</label>
                <input type="text" class="form-control" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"><br />
                <!-- Display name errors -->
                <?php if (isset($errors['name'])) echo "<p>" . htmlspecialchars($errors['name']) . "</p>"; ?>
            </div>
            <!-- Password input field -->
            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password"><br />
                <!-- Display password errors -->
                <?php if (isset($errors['password'])) echo "<p>" . htmlspecialchars($errors['password']) . "</p>"; ?>
            </div>
            <!-- Password confirmation input field -->
            <div class="mb-3">
                <label for="cpassword">Confirm Password</label>
                <input type="password" class="form-control" name="cpassword"><br />
                <!-- Display password confirmation errors -->
                <?php if (isset($errors['cpassword'])) echo "<p>" . htmlspecialchars($errors['cpassword']) . "</p>"; ?>
            </div>
            <!-- Register and Clear buttons -->
            <input type="submit" value="Register" class="btn btn-primary mb-3" name="submit">
            <input type="reset" value="Clear" class="btn btn-secondary mb-3">
        </form>
        <?php
            // Start session and connect to database
            session_start();
            require_once("settings.php");
            $conn = @mysqli_connect($host, $user, $pswd, $dbmn) or die('Failed to connect to server');

            // Check if the database connection was successful
            if (!$conn) {
                die('Failed to connect to server: ' . mysqli_connect_error());
            }
            
            // Initialize errors array
            $errors = [];

            // Function to validate user input
            function validateInput($input, $type, $maxLength, $conn, &$errors) {
                // Check if input is set
                if (isset($_POST[$input])) {
                    $value = trim($_POST[$input]);
                    // Check if input is not empty and within maximum length
                    if (!empty($value) && strlen($value) <= $maxLength) {
                        // Validate email
                        if ($type == 'email') {
                            // Check if email is in correct format
                            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                $errors[$input] = "Your email must match the correct format.";
                            } else {
                                // Check if email already exists in database
                                $query = "SELECT * FROM friends WHERE friend_email = '$value'"; 
                                $result = mysqli_query($conn, $query); 
                                if (mysqli_num_rows($result) > 0) 
                                { 
                                    $errors[$input] = "This email already exists."; 
                                }
                            }
                        // Validate profile name
                        } elseif ($type == 'name' && !ctype_alpha($value)) {
                            $errors[$input] = "Profile name must contain only letters and cannot be blank.";
                        // Validate password
                        } elseif ($type == 'password' && !ctype_alnum($value)) {
                            $errors[$input] = "Password must contain only letters and numbers.";
                        // Validate password confirmation
                        } elseif ($type == 'cpassword' && $_POST['password'] != $value) {
                            $errors[$input] = "Passwords do not match.";
                        }
                    } else {
                        $errors[$input] = "Your $type can't be empty and must be <= $maxLength characters.";
                    }
                } else {
                    $errors[$input] = "Please enter your $type.";
                }
            }
            
            // Process form data if form is submitted
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                // Validate all form fields
                validateInput("email", "email", 50, $conn, $errors);
                validateInput("name", "name", 30, $conn, $errors);
                validateInput("password", "password", 20, $conn, $errors);
                validateInput("cpassword", "cpassword", 20, $conn, $errors);
                
                // If there are no errors, insert new user into database
                if (empty($errors)) {
                    // Escape user input to prevent SQL injection
                    $email = mysqli_real_escape_string($conn, $_POST['email']);
                    $name = mysqli_real_escape_string($conn, $_POST['name']);
                    $password = mysqli_real_escape_string($conn, $_POST['password']);

                    // Insert new user into database
                    $queryAdd = "INSERT INTO friends (friend_email, profile_name, password, num_of_friends, date_started) VALUES ('$email', '$name', '$password', 0, NOW())";
                    $queryAddResult = mysqli_query($conn, $queryAdd);

                    // If insertion was successful, retrieve new user's ID and redirect to friendadd.php
                    if($queryAddResult) {
                        echo "<p>Add successfully.</p>";
                        $query = "SELECT friend_id, profile_name FROM friends WHERE friend_email = '$email'";
                        $result = mysqli_query($conn, $query);
                        if ($result) {
                            $row = mysqli_fetch_assoc($result);
                            $_SESSION['profile_name'] = $row['profile_name'];
                            $_SESSION['friend_id'] = $row['friend_id'];
                            header("location: friendadd.php");
                        } else {
                            echo "<p>Failed to retrieve friend_id.</p>";
                        }
                    } else {
                        echo "<p>Add failed.</p>";
                    }
                // If there are errors, display them
                } else {
                    foreach ($errors as $error) {
                        echo "<p>$error</p>";
                    }
                }

                // Close database connection
                mysqli_close($conn);
            }
        ?>
        <!-- Link to home page -->
        <div class="mt-3">
            <a href="index.php" class="text-decoration-none btn btn-success">Home</a>
        </div>
    </div>
    
</body>
</html>