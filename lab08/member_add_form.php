<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Huy Vu Tran" />
    <title>Member Add Form</title>
</head>
<body>
    <h1>Member Add Form</h1>
    <form action = "member_add.php" method = "post">
        <fieldset>
            <legend><strong>Enter your details to become a VIP Member</strong></legend>
            <label for="fname">First Name</label>
            <input type="text" name="fname"></br>
            <label for="lname">Last Name</label>
            <input type="text" name="lname"></br>
            <label for="gender">Gender</label>
            <input type="text" name="gender"></br>
            <label for="email">Email</label>
            <input type="text" name="email"></br>
            <label for="phone">Phone</label>
            <input type="text" name="phone"></br>
            <input type="submit" value="Sign" name="submit">
            <input type="reset" value="Reset Form" name="reset">
        </fieldset>
    </form>
    <a href="vip_member.php">Return to homepage</a><br>
</body>
</html>