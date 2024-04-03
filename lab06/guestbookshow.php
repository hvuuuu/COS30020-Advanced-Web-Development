<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Huy Vu Tran" />
    <style>
        table, th, td {
            border: 1px solid;
        }
    </style>
    <title>TITLE</title>
</head>
<body>
    <h1>Lab06 Task 2 - Guestbook</h1>
    <h2>View Guestbook</h2>
    <?php // read the comments for hints on how to answer each item
        $fileName = "../../data/lab06/guestbook.txt";
        if (!file_exists($fileName) || filesize($fileName) == 0) {
            echo "<p style='color:red'>No guestbook entries found!</p>";
        } else {
            $fileArr = file($fileName);

            // Define a custom comparison function to sort based on the first element
            function compareLines($line1, $line2) {
                $lineArr1 = explode(",", $line1);
                $lineArr2 = explode(",", $line2);
                return strcmp($lineArr1[0], $lineArr2[0]);
            }

            // Sort the file array based on the custom comparison function
            usort($fileArr, 'compareLines');

            echo "<table>";
            echo "<tr>";
            echo "<th>Number</th>";
            echo "<th>Name</th>";
            echo "<th>Email</th>";
            echo "</tr>";
            for ($i = 0; $i < count($fileArr); $i++) {
                $lineArr = explode(",", $fileArr[$i]);

                echo "<tr>";
                echo "<td class='center'><b>" . ($i + 1) . "</b></td>";
                echo "<td>" . $lineArr[0] . "</td>";
                echo "<td>" . $lineArr[1] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    ?>

</body>
</html>
