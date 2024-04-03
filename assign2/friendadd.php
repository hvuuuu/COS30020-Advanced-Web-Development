<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Huy Vu Tran" />
    <!-- Link to the Bootstrap CSS library -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Friend Add Page</title>
</head>
<body>
    <div class="container-fluid p-5 text-black ">
        <?php
            // Start the session
            session_start();

            // Include the settings file
            require_once("settings.php");

            // Connect to the database
            $conn = @mysqli_connect($host, $user, $pswd, $dbmn) or die('Failed to connect to server');

            // Get the friend_id and profile_name from the session
            $profile_name = $_SESSION['profile_name'];
            $friend_id = $_SESSION['friend_id'];

            // If the friend_id and profile_name are set, display a welcome message
            if (isset($friend_id) && isset($profile_name)) {
                echo "<h2>Friend Add Page</h2>";
                echo "<p>Welcome $profile_name : $friend_id !</p>";
            } else {
                header("Location: login.php");
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

            // If the success GET parameter is set, display a success message
            if (isset($_GET['success'])) {
                echo "<p>Successfully added new friend. Total number of friends is $total_friends</p>";
            }

            // Define the number of results per page
            $results_per_page = 5;

            // Query to get the number of friends not already added
            $query = "SELECT * FROM friends WHERE friend_id NOT IN (
                SELECT IF(friend_id1 = '$friend_id', friend_id2, friend_id1) FROM myfriends WHERE friend_id1 = '$friend_id' OR friend_id2 = '$friend_id'
            ) AND friend_id != '$friend_id'";
            $result = mysqli_query($conn, $query);
            if ($result === FALSE) {
                die("SQL error: " . mysqli_error($conn));
            }
            $number_of_results = mysqli_num_rows($result);

            // Calculate the number of pages
            $number_of_pages = ceil($number_of_results / $results_per_page);

            // Determine the current page
            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            // Calculate the first result for the current page
            $this_page_first_result = ($page - 1) * $results_per_page;

            // Query to get the friends for the current page
            $queryNewFriends = "SELECT * FROM friends WHERE friend_id NOT IN (
                SELECT IF(friend_id1 = '$friend_id', friend_id2, friend_id1) FROM myfriends WHERE friend_id1 = '$friend_id' OR friend_id2 = '$friend_id'
            ) AND friend_id != '$friend_id' LIMIT " . $this_page_first_result . ',' . $results_per_page;
            $resultNewFriends = mysqli_query($conn, $queryNewFriends);

            // If a new friend is being added
            if (isset($_POST['new_friend_id'])) {
                $new_friend_id = $_POST['new_friend_id'];
            
                // Query to add the new friend
                $friend_id1 = ($friend_id < $new_friend_id) ? $friend_id : $new_friend_id;
                $friend_id2 = ($friend_id < $new_friend_id) ? $new_friend_id : $friend_id;

                $addFriendQuery = "INSERT INTO myfriends (friend_id1, friend_id2) VALUES ('$friend_id1', '$friend_id2')";
                $addFriendResult = mysqli_query($conn, $addFriendQuery);
            
                // If the friend was added successfully, redirect to the same page with a success parameter
                if ($addFriendResult) {
                    // Query to update the new friend
                    $updateFriendQuery = "UPDATE friends SET num_of_friends = (
                        SELECT COUNT(*)
                        FROM myfriends
                        WHERE myfriends.friend_id1 = friends.friend_id OR myfriends.friend_id2 = friends.friend_id
                        )";
                    $updateFriendResult = mysqli_query($conn, $updateFriendQuery);
                    if ($updateFriendResult) {
                        echo "<p>Successfully added new friend.</p>";
                        header("Location: friendadd.php?page=$page&success=1");
                        exit;
                    } else {
                        echo "<p>Failed to add new friend.</p>";
                    }
                } else {
                    echo "<p>Failed to add new friend.</p>";
                }
            }

            // If the query for new friends was successful
            if ($resultNewFriends) {
                echo "<table class='table table-striped table-bordered'>"; 
                echo "<tr><th>Friend</th><th>Mutual Friends<th>Button</th></tr>";

                // Loop through each friend
                while ($row = mysqli_fetch_assoc($resultNewFriends)) {
                    $new_friend_id = $row['friend_id'];
                    $new_friend_name = $row['profile_name'];

                    echo "<tr><td>$new_friend_name</td>"; 

                    // Query to get the number of mutual friends
                    $queryMutualFriends = "SELECT COUNT(*) AS mutual FROM (
                        SELECT friend_id2 FROM myfriends WHERE friend_id1 = '$friend_id' AND friend_id2 IN (
                            SELECT IF(friend_id1 = '$new_friend_id', friend_id2, friend_id1) FROM myfriends WHERE friend_id1 = '$new_friend_id' OR friend_id2 = '$new_friend_id'
                        )
                        UNION ALL
                        SELECT friend_id1 FROM myfriends WHERE friend_id2 = '$friend_id' AND friend_id1 IN (
                            SELECT IF(friend_id1 = '$new_friend_id', friend_id2, friend_id1) FROM myfriends WHERE friend_id1 = '$new_friend_id' OR friend_id2 = '$new_friend_id'
                        )
                    ) AS mutual_friends";
                    $resultMutualFriends = mysqli_query($conn, $queryMutualFriends);

                    // Display the number of mutual friends
                    while ($rowMutualFriends = mysqli_fetch_assoc($resultMutualFriends)) {
                        $mutualFriends = $rowMutualFriends['mutual'];
                        echo "<td>$mutualFriends mutual friends</td>";
                    }

                    // Form to add the friend
                    echo "<td>
                            <form method='post' action='friendadd.php'>
                                <input type='hidden' name='new_friend_id' value='$new_friend_id'>
                                <input type='submit' class='btn btn-primary' value='Add Friend'>
                            </form>
                        </td></tr>"; 
                } 
                echo "</table>";

                echo "<div class='row'>";
                // If not on the first page, display a link to the previous page
                if ($page > 1) {
                    echo '<div class="col text-start"><a href="friendadd.php?page=' . ($page - 1) . '" class="text-decoration-none btn btn-warning">Previous</a></div>';
                } else {
                    echo '<div class="col"></div>'; // Empty column for alignment when there is no 'Previous' button
                }
                
                // If not on the last page, display a link to the next page
                if ($page < $number_of_pages) {
                    echo '<div class="col text-end"><a href="friendadd.php?page=' . ($page + 1) . '" class="text-decoration-none btn btn-success">Next</a></div>';
                } else {
                    echo '<div class="col"></div>'; // Empty column for alignment when there is no 'Next' button
                }
                echo "</div>";
            } else {
                echo "<p>Failed to retrieve new friends.</p>";
            }
        ?>
        <div class="mt-3">
            <!-- Link to the friend list page -->
            <a href="friendlist.php" class="text-decoration-none btn btn-dark">Friend List</a>
            <!-- Link to the logout page -->
            <a href="logout.php" class="text-decoration-none btn btn-danger">Log Out</a>
        </div>
    </div>
</body>
</html>