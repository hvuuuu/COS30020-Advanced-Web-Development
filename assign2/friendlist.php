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
    <title>Friend List Page</title>
</head>
<body>
    <div class="container-fluid p-5 text-black ">
        <?php
            // Start a new session or resume the existing one
            session_start();
            // Get the friend_id from the session
            $friend_id = $_SESSION['friend_id'];

            // Include the settings.php file
            require_once("settings.php");
            // Connect to the database
            $conn = @mysqli_connect($host, $user, $pswd, $dbmn) or die('Failed to connect to server');

            // Check if a POST request has been made
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Get the friend_id2 from the POST request
                $friend_id2 = $_POST['friend_id2'];

                // Query to unfriend
                $queryUnfriend1 = "DELETE FROM myfriends WHERE friend_id1 = '$friend_id' AND friend_id2 = '$friend_id2'";
                $queryUnfriend2 = "DELETE FROM myfriends WHERE friend_id1 = '$friend_id2' AND friend_id2 = '$friend_id'";

                // Execute the queries
                $resultUnfriend1 = mysqli_query($conn, $queryUnfriend1);
                $resultUnfriend2 = mysqli_query($conn, $queryUnfriend2);

                // Check if the query was successful
                if ($resultUnfriend1 && $resultUnfriend2) {
                    // Query to update the friend
                    $updateFriendQuery = "UPDATE friends SET num_of_friends = (
                        SELECT COUNT(*)
                        FROM myfriends
                        WHERE myfriends.friend_id1 = friends.friend_id OR myfriends.friend_id2 = friends.friend_id
                        )";
                    $updateFriendResult = mysqli_query($conn, $updateFriendQuery);
                    if ($updateFriendResult) {
                        echo "<p>Successfully unfriended.</p>";
                    } else {
                        echo "<p>Failed to unfriend.</p>";
                    }
                } else {
                    echo "<p>Failed to unfriend.</p>";
                }
            }

            // Query to get the profile name
            $queryName = "SELECT * FROM friends WHERE friend_id = '$friend_id'"; 
            // Execute the query
            $result = mysqli_query($conn, $queryName);
            // Check if the query was successful
            if ($result) {
                // Fetch the result as an associative array
                $row = mysqli_fetch_assoc($result);
                // Store the profile name in the session
                $_SESSION['profile_name'] = $row['profile_name'];
            } else {
                echo "<p>Failed to retrieve profile name.</p>";
            }

            // Query to get the total number of friends
            $queryTotalFriends = "SELECT num_of_friends FROM friends WHERE friend_id = '$friend_id'";
            // Execute the query
            $resultTotalFriends = mysqli_query($conn, $queryTotalFriends);
            // Check if the query was successful
            if ($resultTotalFriends) {
                // Fetch the result as an associative array
                $rowTotalFriends = mysqli_fetch_assoc($resultTotalFriends);
                // Store the total number of friends
                $total_friends = $rowTotalFriends['num_of_friends'];
            } else {
                echo "<p>Failed to retrieve total number of friends.</p>";
            }

            // Check if friend_id and profile_name are set
            if (isset($friend_id) && isset($_SESSION['profile_name'])) {
                echo "<h2>Friend List Page</h2>";
                echo "<p>Welcome {$_SESSION['profile_name']} : $friend_id !</p>";
                echo "<p>Total number of friends is $total_friends</p>";
            } else {
                header("Location: login.php");
            }

            // Query to get the friend_id2 for each friend where friend_id1 = friend_id or friend_id1 where friend_id2 = friend_id
            $query = "(SELECT friend_id2 FROM myfriends WHERE friend_id1 = $friend_id) UNION (SELECT friend_id1 FROM myfriends WHERE friend_id2 = $friend_id)";
            // Execute the query
            $queryResult = mysqli_query($conn, $query);

            // Start a table
            echo "<table class='table table-striped table-bordered'>"; 
            echo "<tr>
                    <th>Friend</th><th>Button</th></tr>";

            // Loop through each row in the result
            while ($row = mysqli_fetch_row($queryResult)) {

                // Query to get each friend's profile name
                $queryFriend = "SELECT * FROM friends WHERE friend_id = '{$row[0]}'"; 
                // Execute the query
                $resultFriend = mysqli_query($conn, $queryFriend);
                // Check if the query was successful
                if ($resultFriend) {
                    // Fetch the result as an associative array
                    $rowFriend = mysqli_fetch_assoc($resultFriend);
                    // Store the friend's profile name
                    $profile_friend = $rowFriend['profile_name'];
                } else {
                    echo "<p>Failed to retrieve profile friend.</p>";
                }

                // Add a row to the table for each friend
                echo "<tr><td>$profile_friend</td>"; 
                echo "<td>
                        <form method='post'>
                            <input type='hidden' name='friend_id2' value='{$row[0]}'>
                            <input type='submit' class='btn btn-warning' value='Unfriend'>
                        </form>
                    </td></tr>"; 
            } 
            echo "</table>";

            // Free the result set
            mysqli_free_result($queryResult); 
            // Close the database connection
            mysqli_close($conn);

        ?>
        <div>
            <!-- Links to add friends and log out -->
            <a href="friendadd.php" class="text-decoration-none btn btn-dark">Add Friends</a>
            <a href="logout.php" class="text-decoration-none btn btn-danger">Log Out</a>
        </div>
    </div>
</body>
</html>