<!DOCTYPE html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Web Application Development :: Lab 1" />
    <meta name="keywords" content="Web,programming" />
    <title>Using if and while statements</title>
</head>
<body>
    <h1>Lab03 Task 3 - Prime Number</h1>
    <?php 
        function is_primenumber($n) {
            if ($n > 1 && $n < 1000) {
                for ($i = 2; $i < $n; $i++)
                {
                    if ($n % $i == 0) 
                    {
                        return false;
                        break;
                    }               
                }
                return true;      
            } 
        }
    ?>
    <?php
        if (isset ($_GET["submit"])) { // check if form data exists
            $num = $_GET["number"]; // obtain the form data
            if (is_numeric($num)) {
                $roundedNumber = round($num);
                if (is_primenumber($roundedNumber) == 1) {
                    echo "<p>The number you entered $roundedNumber is a prime number.";
                } else {
                    if ($num >= 0) {
                        echo "<p>The number you entered $roundedNumber is not a prime number.";
                    } else {
                        echo "<p>Please enter a positive number greater than 1 and smaller than 1000.</p>";
                    }
                }
            } else { 
                echo "<p>Please enter a number.</p>";
            }
        } else { // no input
            echo "<p>Please enter a number.</p>";
        }
    ?>
</body>
</html>