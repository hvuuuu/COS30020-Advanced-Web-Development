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
    <h1>Lab06 Task 2 - Guestbook</h1>
    <form action = "guestbooksave.php" method = "post" >
        <fieldset>
            <legend><strong>Enter your details to sign our guest book</strong></legend>
            <label for="name">Name</label>
            <input type="text" name="name"></br>
            <label for="email">E-mail</label>
            <input type="text" name="email"></br>
            <input type="submit" value="Sign" name="submit">
            <input type="reset" value="Reset Form" name="reset">
        </fieldset>
    </form>
    <a href="guestbookshow.php">Show Guest Book</a>
</body>
</html>