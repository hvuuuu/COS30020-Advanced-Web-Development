<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Metadata for the webpage -->
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Huy Vu Tran" />
    <!-- Link to the Bootstrap CSS library -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Homepage</title>
</head>
<body>
    <div class="container-fluid p-5 bg-dark text-white text-center">
        <!-- Page content -->
        <h1>My Friend System</h1>
        <h2>Assignment Homepage</h2>
        <p>Name : Huy Vu Tran</p>
        <p>Student ID : 104177995</p>
        <p>Email : <a href="mailto: 104177995@student.swin.edu.au" class="text-decoration-none text-white">104177995@student.swin.edu.au</a></p>
        <p>I declare that this assignment is my individual work. I have not worked collaboratively nor have I copied from any other student’s work or from any other source.</p>
        <?php
            // Include the settings file
            require_once("settings.php");
            // Connect to the database
            $conn = @mysqli_connect($host, $user, $pswd, $dbmn) or die('Failed to connect to server');

            // Check if the tables 'friends' and 'myfriends' exist
            $checkTable1 = mysqli_query($conn, "SHOW TABLES LIKE 'friends'");
            $checkTable2 = mysqli_query($conn, "SHOW TABLES LIKE 'myfriends'");

            // If both tables exist
            if(mysqli_num_rows($checkTable1) > 0 && mysqli_num_rows($checkTable2) > 0) {
                echo "<p>Tables already exist.</p>";
            } else {
                // If not, create the tables and populate them
                $query = 

                "CREATE TABLE IF NOT EXISTS friends (
                    friend_id INT NOT NULL AUTO_INCREMENT,
                    friend_email VARCHAR(50) NOT NULL,
                    password VARCHAR(20) NOT NULL,
                    profile_name VARCHAR(30) NOT NULL,
                    date_started DATE NOT NULL,
                    num_of_friends INT UNSIGNED,
                    PRIMARY KEY (friend_id)
                );
                
                CREATE TABLE IF NOT EXISTS myfriends (
                    friend_id1 INT NOT NULL,
                    friend_id2 INT NOT NULL,
                    CHECK (friend_id1 < friend_id2)
                );

                INSERT INTO friends (friend_email, password, profile_name, date_started, num_of_friends)
                VALUES 
                ('john@gmail.com', 'john123', 'John Doe', '2020-01-01', 5),
                ('jane@gmail.com', 'jane123', 'Mary Jane', '2020-02-01', 4),
                ('bob@gmail.com', 'bob123', 'Bob Builder', '2020-03-01', 4),
                ('alice@gmail.com', 'alice123', 'Alice Wonderland', '2020-04-01', 5),
                ('charlie@gmail.com', 'charlie123', 'Charlie Brown', '2020-05-01', 2),
                ('david@gmail.com', 'david123', 'David Beckham', '2020-06-01', 0),
                ('emma@gmail.com', 'emma123', 'Emma Watson', '2020-07-01', 1),
                ('frank@gmail.com', 'frank123', 'Frank Sinatra', '2020-08-01', 0),
                ('grace@gmail.com', 'grace123', 'Grace Kelly', '2020-09-01', 0),
                ('harry@gmail.com', 'harry123', 'Harry Potter', '2020-10-01', 0);

                INSERT INTO myfriends (friend_id1, friend_id2)
                VALUES 
                (1, 2), (1, 3), (1, 4), (1, 5), (1, 6),
                (2, 3), (2, 4), (2, 5), (2, 6),
                (3, 4), (3, 5), (3, 6), (3, 7),
                (4, 5), (4, 6), (4, 7), (4, 8), (4, 9),
                (5, 6), (5, 7);
                
                UPDATE friends SET num_of_friends = (
                SELECT COUNT(*)
                FROM myfriends
                WHERE myfriends.friend_id1 = friends.friend_id OR myfriends.friend_id2 = friends.friend_id
                )";

                // Execute the query
                if(mysqli_multi_query($conn, $query)) {
                    do {
                        if ($result = mysqli_store_result($conn)) {
                            mysqli_free_result($result);
                        }
                    } while (mysqli_next_result($conn));
                    echo "<p>Table successfully created and populated.</p>";
                } else {
                    echo "<p>Table unsuccessfully created and populated.</p>";
                }
            }
        ?>
        <!-- Navigation buttons -->
        <a href="signup.php" class="btn btn-danger text-decoration-none">Sign Up</a>
        <a href="login.php" class="text-decoration-none btn btn-warning ">Log In</a>
        <a href="about.php" class="btn btn-info text-decoration-none">About</a>
    </div>
</body>
</html>