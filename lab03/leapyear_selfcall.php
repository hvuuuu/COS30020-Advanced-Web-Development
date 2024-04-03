<!DOCTYPE html>
<html lang="en" lang="en" >
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Web Application Development :: Lab 3" />
    <meta name="keywords" content="Web,programming" />
    <title>Using if and while statements</title>
</head>
<body>
    <h1>Lab03 Task 2 - Leap Year</h1>
        <form action = "leapyear_selfcall.php" method = "get">
            <label for="number">Year:</label>
            <input type="number" name="number"></br>
            <input type="submit" value="Check for Leap Year" name="submit">
        </form>
        <?php 
            function is_leapyear($n) {
                if($n >= 0) {
                    if ($n % 400 == 0) {
                        return true;
                    } elseif ($n % 100 == 0) {
                        return false;
                    } elseif ($n % 4 == 0) {
                        return true;
                    } else {
                        return false;
                    }
                } 
            }
            if (isset ($_GET["number"])) { // check if form data exists
                $num = $_GET["number"]; // obtain the form data
                if (is_numeric($num)) {
                    $roundedNumber = round($num);
                    if (is_leapyear($roundedNumber) == 1) {
                        echo "<p>The year you entered $roundedNumber is a leap year.";
                    } else {
                        if ($num >= 0) {
                            echo "<p>The year you entered $roundedNumber is not a leap year.";
                        } else {
                            echo "<p>Please enter a positive year. </p>";
                        }
                    }
                } else { 
                    echo "<p>Please enter a year.</p>";
                }
            } else { // no input
                echo "<p>Please enter a year.</p>";
            }
        ?>
</body>
</html>
