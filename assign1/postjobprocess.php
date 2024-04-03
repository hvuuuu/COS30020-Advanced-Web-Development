<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Assignment 1" />
    <meta name="keywords" content="Web,programming" />
    <link rel="stylesheet" href="style.css" />
    <title>Job Vacancy Posting System</title>
</head>
<body>
    <div class="indexPage">
        <div>
            <?php
                // Function to validate form inputs and return error messages
                function form_validate() {
                    $msg = ""; // Variable to store error messages
                    if (isset($_POST['submit'])) {
                        // Validate position ID
                        if (isset($_POST['pid'])) {
                            $GLOBALS['position_id'] = $_POST['pid'];
                            $pattern = '/^PID\d{4}$/'; // Check if the input follows the specified pattern
                            // Check if the Position ID is not empty and matches the specified pattern
                            if (!empty($GLOBALS['position_id']) && preg_match($pattern, $GLOBALS['position_id'])) {
                                // Call the directory_check() function to ensure the directory exists
                                directory_check();

                                // Check if position ID is unique
                                $filename = "../../data/jobposts/jobs.txt";

                                // If the file does not exist, create it
                                if (!file_exists($filename)) {
                                    fopen($filename, "a");
                                } else {
                                    // If the file exists, read its contents and check for existing Position IDs
                                    $data = file($filename);
                                    foreach ($data as $line) {
                                        // Split each line into fields using tab delimiter
                                        $fields = explode("\t", $line);
                                        // Check if the first field (Position ID) matches the input Position ID
                                        if ($fields[0] === $GLOBALS['position_id']) {
                                            // If a match is found, add an error message indicating that the Position ID already exists
                                            $msg .= "<p>Position ID already exists. Please enter a unique Position ID.</p>";
                                            break;
                                        }
                                    }
                                }
                            } else {
                                // If the Position ID is empty or does not match the pattern, add an error message
                                $msg .= "<p>Please enter a valid Position ID following the pattern (e.g. PID0001).</p>";
                            }

                        } else {
                            $msg .= "<p>Please enter a position ID.</p>";
                        }
            
                        // Validate title
                        if(isset($_POST['tit'])) {
                            $title = trim($_POST['tit']); // Remove leading and trailing spaces
                            if (!empty($title) && strlen($title) <= 20 && preg_match('/^[A-Za-z0-9,.\s!]+$/', $title)) {
                                $GLOBALS['title'] = $title;
                            } else {
                                $msg .= "<p>Please enter a valid title with a maximum of 20 alphanumeric characters including spaces, comma, period, and exclamation point.</p>";
                            }
                        } else {
                            $msg .= "<p>Please enter a title.</p>";
                        }
                        
                        // Validate description
                        if(isset($_POST['des'])) {
                            $description = trim($_POST['des']); // Remove leading and trailing spaces
                            if (!empty($description) && strlen($description) <= 250) {
                                $GLOBALS['description'] = $description;
                            } else {
                                $msg .= "<p>Please enter a description with a maximum of 250 characters.</p>";
                            }
                        } else {
                            $msg .= "<p>Please enter a description.</p>";
                        }
                        
                        // Validate closing date
                        if(isset($_POST['dat'])) {
                            $GLOBALS['closingDate'] = $_POST['dat'];
                            $pattern = '/^\d{2}\/\d{1,2}\/\d{2}$/'; // Check if the closing date is in the correct format (dd/mm/yy)
                            if (!empty($GLOBALS['closingDate']) && preg_match($pattern, $GLOBALS['closingDate'])) {
                            } else {
                                $msg .= "<p>Please enter a valid closing date in the dd/mm/yy format.</p>";
                            }
                        } else {
                            $msg .= "<p>Please enter a closing date.</p>";
                        }
            
                        // Validate position and contract
                        if(isset($_POST['pos'])) {
                            $GLOBALS['position'] = $_POST['pos'];
                        } else {
                            $msg .= "<p>Please choose a position.</p>";
                        }
            
                        if(isset($_POST['con'])) {
                            $GLOBALS['contract'] = $_POST['con'];
                        } else {
                            $msg .= "<p>Please choose a contract.</p>";
                        }
            
                        // Validate application method
                        if(isset($_POST['post']) || isset($_POST['mail'])) {
                            if(isset($_POST['post']) && !isset($_POST['mail'])) {
                                $GLOBALS['app'] = $_POST['post'];
                            } elseif(isset($_POST['mail']) && !isset($_POST['post'])) {
                                $GLOBALS['app'] = $_POST['mail'];
                            } else {
                                $GLOBALS['app'] = $_POST['post'] . ' and ' . $_POST['mail']; // Concatenate values with 'and'
                            }
                        } else {
                            $msg .= "<p>Please choose between 1 or 2 applications.</p>";
                        }
            
                        // Validate location
                        if(isset($_POST['loc'])) {
                            $GLOBALS['location'] = $_POST['loc'];
                        } else {
                            $msg .= "<p>Please choose a location.</p>";
                        }
                        return $msg; // Return the error messages
                    }
                }
    
                $formValidation = form_validate(); // Perform form validation

                // Function to check directory existence and create if necessary
                function directory_check() {
                    umask(0007);
                    $directory = "../../data/jobposts";
                    if (!file_exists($directory)) {
                        mkdir($directory, 0777, true);
                    }
                }
                
                // Check directory existence and create if necessary
                directory_check();
                
                if (empty($formValidation)) {
                    $filename = "../../data/jobposts/jobs.txt";
                    umask(0007);
                    // unlink($filename);
                    $handle = fopen($filename, "a");
                    // Trim whitespace from global variables
                    $position_id = trim($GLOBALS['position_id']);
                    $title = trim($GLOBALS['title']);
                    $description = trim($GLOBALS['description']);
                    $closingDate = trim($GLOBALS['closingDate']);
                    $position = trim($GLOBALS['position']);
                    $contract = trim($GLOBALS['contract']);
                    $app = trim($GLOBALS['app']);
                    $location = trim($GLOBALS['location']);
                    // Concatenate trimmed values
                    $data = "$position_id\t$title\t$description\t$closingDate\t$position\t$contract\t$app\t$location\n";
                    if (fwrite($handle, $data)) {
                        echo "<p>Write data successfully</p>";
                    } else {
                        echo "<p>Can't write data</p>";
                    }
                    fclose($handle);
                } else {
                    echo "<p class='formError'>$formValidation</p>"; // Display form validation errors
                }
                
            ?>
        </div>
        <a href='index.php' class='link'>&#10084; Return to homepage &#10084;</a>
    </div>
</body>
</html>
