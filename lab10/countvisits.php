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
    <h1>Hit Counter</h1>
    <?php
        require_once("hitcounter.php");
        require_once("../../data/lab10/mykeys.inc.php");

        $counter = new HitCounter($host, $username, $password, $dbname);
        $counter->getHits();
        $counter->setHits($counter->hits + 1);
        $counter->closeConnection();
        echo "<p>This page has received: " . $counter->hits . "</p>";
    ?>
</body>
</html>
