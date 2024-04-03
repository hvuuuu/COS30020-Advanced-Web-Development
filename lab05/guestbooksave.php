<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Huy Vu Tran" />
    <title>TITLE</title>
</head>
<body>
    <h1>Lab05 Task 2 - Sign Guestbook</h1>
    <?php
        umask(0007);
        $dir = "../../data/lab05";
        if (!file_exists($dir)) {
            mkdir($dir, 02770);
        }
        if (isset($_POST["fname"]) && isset($_POST["lname"]) && !empty($_POST["fname"]) && !empty($_POST["lname"])) {
            $fname = $_POST["fname"];
            $lname = $_POST["lname"];
            $filename = "../../data/lab05/guestbook.txt";
            $handle = fopen($filename, "a");
            // method 1 to write file
            $data = addslashes($fname . " " . $lname . "\n");
            fwrite($handle, $data);
            // method 2 to write file
            // file_put_contents($filename, $data, FILE_APPEND);
            fclose($handle);
            echo "<p style='color:green'>Thank you for signing our guest book!</p>";
        } else {
            echo "<p style='color:red'>You must enter your first and last name!<br>Use the Browser's 'Go Back' button to return to the Guestbook form.</p>";
        }
        echo '<p><a href="guestbookshow.php">Show Guest Book</a></p>';
    ?>
</body>
</html>
