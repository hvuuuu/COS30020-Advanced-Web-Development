<?php 
    session_start();                            // start the session 
    if (!isset ($_SESSION["randNum"])) {         // check if random number exists
        $_SESSION["randNum"] = rand(1, 100);     // generate a random number
    }
    if (!isset ($_SESSION["guess_ncount"])) {   // check if guess_ncount exists
        $_SESSION["guess_ncount"] = 0;          // initialize guess_ncount
    }
    $randNum = $_SESSION["randNum"];             // store the number in the session
    $guess_ncount = $_SESSION["guess_ncount"];  // store the number of guesses in the session
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
    <p>Guess a number between 1 and 100, then press the Guess button</p>
    <form action="guessinggame.php" method="post"> 
        <input type="text" name="guess" /> 
        <input type="submit" value="Guess" />
    </form>
    <?php

        if (isset($_POST["guess"]) && !empty($_POST["guess"])) {                                // if the form is submitted
            $guess = $_POST["guess"];                                                           // get the guess
            if (is_numeric($guess) && $guess > 0 && $guess == round($guess) && $guess < 101) {  // check if the guess is valid
                $guess = (int)$guess;                                                           // convert the guess to an integer
                $_SESSION["guess_ncount"]++;                                                    // increment the number of guesses
                $guess_ncount = $_SESSION["guess_ncount"];                                      // store the number of guesses in the session
                if ($guess == $randNum) {                                                       // if the guess is correct
                    echo "<p>Congratulations! You have guessed the hidden number.</p>";
                    echo "<p>Number of guesses: $guess_ncount.</p>";
                } else if ($guess < $randNum) {                                                 // if the guess is too low
                    echo "<p>Too low! Try again</p>";
                    echo "<p>Number of guesses: $guess_ncount.</p>"; 
                } else {                                                                        // if the guess is too high
                    echo "<p>Too high! Try again</p>";
                    echo "<p>Number of guesses: $guess_ncount.</p>"; 
                }
            } else {
                echo "<p>Please enter a valid number</p>"; 
            }
        } else {
            echo "<p>Please enter a valid number</p>"; 
        }
        
    ?>
    <p><a href="giveup.php">Give Up</a></p>
    <!-- links to give up page -->  
    <p><a href="startover.php">Start Over</a></p> 
    <!-- links to start over page -->  
</body> 
</html> 