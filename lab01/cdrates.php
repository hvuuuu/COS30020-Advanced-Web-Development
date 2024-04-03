<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Second PHP webpage</title>
    <meta charset="utf-8">
    <meta name="description" content="Web development">
    <meta name="keywords" content="HTML, CSS, JavaScript">
    <meta name="author" content="Huy Vu Tran">
</head>
<body>
    <h1>Forestville Credit Union</h1>
    <h2>CD Rates</h2>
    <?php 
        echo "<ul>
                <li>4.35% (36-Month Term CD)</li>
                <li>3.85% (12-Month Term CD)</li> 
                <li>2.65% (6-Month Term CD)</li> 
            </ul>";
        echo "<p>$1,000 minimum deposit.</p>";
    ?>
</body>
</html>