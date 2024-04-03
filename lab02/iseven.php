<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" >
    <meta name="description" content="Web Programming :: Lab 2" >
    <meta name="keywords" content="Web,programming" >
    <title>Using variables, arrays and operators</title>
</head>
<body>
    <form action="#" method="get">
        <label for="number">Input a number:</label>
        <input type="text" name="number">
        <input type="submit" name="submit" value="Submit">
    </form>
    <?php
        echo (isset($_GET['submit'])) 
            ? (is_numeric($_GET['number']))
                ? (round($_GET['number']) % 2 == 0)
                        ? "<p>This is an even number.</p>"
                        : "<p>This is an odd number.</p>"
                : "<p>This is not a number.</p>"
            : "<p>Please enter a number.</p>";
    ?>
</body>
</html>
