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
    <h1>Lab05 Task 2 - Guestbook</h1>
    <?php
        $filename = "../../data/lab05/guestbook.txt";
        if (!file_exists($filename)) {
            echo "<p style='color:red'>Guestbook is empty!</p>";
            exit;
        } else {
            $handle = fopen($filename, "r");
            // Method 1
            // $data = "";
            // while (!feof($handle)) {
            //     $temp = stripslashes(fgets($handle));
            //     $data .= $temp;
            // }
            // Method 2 
            $data = fread($handle, filesize($filename));
            echo "<pre style=\"font-family: 'Times New Roman', Times, serif;\">$data</pre>";
            fclose($handle);
        }
    ?>
</body>
</html>
