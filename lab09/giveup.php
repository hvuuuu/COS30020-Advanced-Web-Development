<?php 
    session_start();                     // start the session 
    $randNum = $_SESSION["number"];      // copy the number in the session
?> 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="utf-8" /> 
    <meta name="description" content="Web application development" /> 
    <meta name="keywords" content="PHP" /> 
    <meta name="author"   content="Huy Vu Tran" /> 
    <title>Guessing Game</title> 
</head> 
<body> 
    <h1>Guessing Game</h1> 
    <?php
        echo "<p>The hidden number is $randNum</p>";
    ?>
    <p><a href="startover.php">Start Over</a></p> 
    <!-- links to start over page -->  
</body> 
</html> 