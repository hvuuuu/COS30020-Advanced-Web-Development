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
    <h1>Lab04 Task 3 - Standard Palindrome</h1>
    <?php // read the comments for hints on how to answer each item
        if (isset ($_POST["submit"])){ // check if form data exists
            $str = $_POST["string"]; // obtain the form data
            $rep = str_replace(' ', '', preg_replace('/[^a-zA-Z]/', '', $str));
            $low = strtolower($rep);
            $rev = strrev($low);
            if ($low == $rev) {
                echo "<p>The text you entered '$str' is a standard palindrome!</p>";
            } else {
                echo "<p>The text you entered '$str' is not a standard palindrome!</p>";
            }
        } else { // no input
            echo "<p>Please enter a string from the input form.</p>";
        }
    ?>
</body>
</html>