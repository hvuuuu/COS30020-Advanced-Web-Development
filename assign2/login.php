<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags for document information -->
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Huy Vu Tran" />
    
    <!-- Linking Bootstrap CSS stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Title of the document -->
    <title>Sign In Page</title>
</head>
<body>
    <div class="container-fluid p-5 text-black ">
        <!-- Form for user login -->
        <form action="login.php" method="post">
            <h2>My Friend System Login Page</h2><br />
            <!-- Input field for email -->
            <div class="mb-3 mt-3">
                <label for="email">Email</label>
                <!-- PHP code to echo back the entered email if form is submitted -->
                <input type="text" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"><br />
                <!-- Display error message if email validation fails -->
                <?php if (isset($errors['email'])) echo "<p>" . htmlspecialchars($errors['email']) . "</p>"; ?>
            </div>
            <!-- Input field for password -->
            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password"><br />
                <!-- Display error message if password validation fails -->
                <?php if (isset($errors['password'])) echo "<p>" . htmlspecialchars($errors['password']) . "</p>"; ?>
            </div>
            <!-- Submit and reset buttons -->
            <input type="submit" value="Login" name="submit" class="btn btn-primary mb-3">
            <input type="reset" value="Clear" class="btn btn-secondary mb-3">
        </form>
        
        <!-- PHP code for handling form submission -->
        <?php
            // Start session and include settings
            session_start();
            require_once("settings.php");
            // Establish database connection
            $conn = @mysqli_connect($host, $user, $pswd, $dbmn) or die('Failed to connect to server');

            // Check if the database connection was successful
            if (!$conn) {
                die('Failed to connect to server: ' . mysqli_connect_error());
            }
            
            $errors = []; // Initialize errors array

            // Function to validate input fields
            function validateInput($input, $type, $maxLength, $conn, &$errors) {
                if (isset($_POST[$input])) {
                    $value = trim($_POST[$input]);
                    if (!empty($value) && strlen($value) <= $maxLength) {
                        if ($type == 'email') {
                            // Validate email format
                            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                $errors[$input] = "Your email must match the correct format.";
                            } else {
                                // Check if email exists in database
                                $query = "SELECT * FROM friends WHERE friend_email = '$value'"; 
                                $result = mysqli_query($conn, $query); 
                                if (mysqli_num_rows($result) <= 0) { 
                                    $errors[$input] = "This email doesn't exist."; 
                                }
                            }
                        } elseif ($type == 'password') {
                            // Validate password format
                            if (!ctype_alnum($value)) {
                                $errors[$input] = "Password must contain only letters and numbers.";
                            } else {
                                // Check if password matches the email in database
                                $email = mysqli_real_escape_string($conn, $_POST['email']);
                                $query = "SELECT * FROM friends WHERE friend_email = '$email'"; 
                                $result = mysqli_query($conn, $query);
                                if ($result) {
                                    $row = mysqli_fetch_assoc($result);
                                    if ($value != $row['password']) {
                                        $errors[$input] = "Incorrect password."; 
                                    }
                                } else {
                                    $errors[$input] = "Failed to retrieve password.";
                                }
                            }
                        }
                    } else {
                        $errors[$input] = "Your $type can't be empty and must be <= $maxLength characters.";
                    }
                } else {
                    $errors[$input] = "Please enter your $type.";
                }
            }

            // Handle form submission
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Validate email and password
                validateInput("email", "email", 50, $conn, $errors);
                validateInput("password", "password", 20, $conn, $errors);

                if (empty($errors)) {
                    // Retrieve friend_id from database
                    $email = mysqli_real_escape_string($conn, $_POST['email']);
                    $query = "SELECT friend_id FROM friends WHERE friend_email = '$email'";
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        // Start session and store friend_id
                        $_SESSION['friend_id'] = $row['friend_id'];
                        // Redirect to friendlist page
                        header("location: friendlist.php");
                    } else {
                        echo "<p>Failed to retrieve friend_id.</p>";
                    }
                } else {
                    // Display error messages
                    foreach ($errors as $error) {
                        echo "<p>$error</p>";
                    }
                }
                mysqli_close($conn); // Close database connection
            }
        ?>
        
        <!-- Link to home page -->
        <div class="mt-3">
            <a href="index.php" class="text-decoration-none btn btn-success">Home</a>
        </div>
    </div>
</body>
</html>
