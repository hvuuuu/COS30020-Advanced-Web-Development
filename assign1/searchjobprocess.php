<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Assignment 1" />
    <meta name="keywords" content="Web,programming" />
    <link rel="stylesheet" href="style.css" />
    <title>Search Job Process</title>
</head>
<body>
    <div class="indexPage">
        <div>
            <h1>Job Vacancy Information</h1>
            <?php 
                if(isset($_GET['tit'])) { // Check if job title is provided
                    $job_title = trim($_GET['tit']); // Remove leading and trailing spaces
                    if (!empty($job_title)) { // Check if job title is not empty
                        $GLOBALS['tit'] = $job_title; // Set global variable for job title
                
                        // Check and set other variables if they exist
                        if(isset($_GET['pos'])) {
                            $GLOBALS['pos'] = $_GET['pos']; // Set global variable for position
                        }

                        if(isset($_GET['con'])) {
                            $GLOBALS['con'] = $_GET['con']; // Set global variable for contract
                        }

                        if(isset($_GET['post']) && isset($_GET['mail'])) {
                            $GLOBALS['app'] = $_GET['post'] . ' and ' . $_GET['mail']; // Set global variable for application method
                        } elseif (isset($_GET['mail'])) {
                            $GLOBALS['app'] = $_GET['mail'];
                        } elseif (isset($_GET['post'])) {
                            $GLOBALS['app'] = $_GET['post'];
                        }

                        if(isset($_GET['loc'])) {
                            $GLOBALS['loc'] = $_GET['loc']; // Set global variable for location
                        }
                        
                        $directory = "../../data/jobposts";
                        if (file_exists($directory)) {
                            $filename = "../../data/jobposts/jobs.txt";
                            umask(0007);
                            $handle = fopen($filename, "r");

                            $data = file($filename);
                            $jobs = array();
                            $jobFound = false; // Flag to indicate if job with matching title is found
                            foreach ($data as $jobString) {
                                $job = explode("\t", $jobString); // Split job data by comma
                                $job[7] = rtrim($job[7]); // Remove trailing whitespace from location
                                if (
                                    (empty($GLOBALS['pos']) || $GLOBALS['pos'] === $job[4]) && // Check if position matches
                                    (empty($GLOBALS['con']) || $GLOBALS['con'] === $job[5]) && // Check if contract matches
                                    (empty($GLOBALS['app']) || $GLOBALS['app'] === $job[6]) && // Check if application method matches
                                    (empty($GLOBALS['loc']) || $GLOBALS['loc'] === $job[7]) && // Check if location matches
                                    (stripos($job[1], $GLOBALS['tit']) !== false) // Check if job title contains the provided keyword
                                ) { 
                                    $job['closingDate'] = DateTime::createFromFormat('d/m/y', trim($job[3])); // Parse closing date as DateTime object
                                    $jobs[] = $job; // Add job to jobs array
                                    $jobFound = true;
                                }
                            }

                            if ($jobFound) {
                                // Sort jobs by closing date (ascending order)
                                usort($jobs, function ($a, $b) {
                                    if ($a['closingDate'] < $b['closingDate']) {
                                        return -1;
                                    } elseif ($a['closingDate'] > $b['closingDate']) {
                                        return 1;
                                    } else {
                                        return 0;
                                    }
                                });

                                // Display jobs with closing date starting from the most future date until today
                                $today = new DateTime();
                                foreach ($jobs as $job) {
                                    if ($job['closingDate'] >= $today) {
                                        echo "<div class='jobData'>";
                                        echo "<p>Job Title: {$job[1]}</p>";
                                        echo "<p>Closing Date: {$job[3]}</p>";
                                        echo "<p>Position: {$job[4]}</p>";
                                        echo "<p>Contract: {$job[5]}</p>";
                                        echo "<p>Application by: {$job[6]}</p>";
                                        echo "<p>Location: {$job[7]}</p>";
                                        echo "</div>";
                                    }
                                }
                            } else {
                                echo "<p>No job found.</p>";
                            }
                            fclose($handle);
                        } else {
                            echo "<p>Directory doesn't exist.</p>";
                        }
                    } else {
                        echo "<p>Please enter a job title</p>";
                    }
                } else {
                    echo "<p>Please enter a job title.</p>";
                }
                
            ?>
        </div>
        <a href="searchjobform.php" class="link">&#10084; Search for another job vacancy &#10084;</a><br>
        <a href="index.php" class="link">&#10084; Return to homepage &#10084;</a>
    </div>
</body>
</html>
