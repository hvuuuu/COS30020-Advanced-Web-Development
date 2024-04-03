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
    <form action = "guestbooksave.php" method = "post" >
        <fieldset>
            <legend><strong>Enter your details to sign our guest book</strong></legend>
            <label for="fname">First Name</label>
            <input type="text" name="fname"></br>
            <label for="lname">Last Name</label>
            <input type="text" name="lname"></br>
            <input type="submit" value="Submit" name="submit">
        </fieldset>
    </form>
    <a href="guestbookshow.php">Show Guest Book</a>
</body>
</html>