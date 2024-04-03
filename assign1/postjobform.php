<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Assignment 1" />
    <meta name="keywords" content="Web,programming" />
    <link rel="stylesheet" href="style.css" />
    <title>Job Vacancy Posting System</title>
</head>
<body>
    <!-- Main job form container -->
    <div class="jobForm">
        <!-- Page heading -->
        <h1>Job Vacancy Posting System</h1>
        
        <!-- Job vacancy posting form -->
        <form action="postjobprocess.php" method="post">
            
            <!-- Text input field for Position ID -->
            <div class="textInput">
                <input type="text" name="pid" class="textInput_field" id="pid"><br>
                <label for="pid" class="textInput_label">Position ID</label>
            </div>

            <!-- Text input field for Title -->
            <div class="textInput">
                <input type="text" name="tit" class="textInput_field" id="tit"><br>
                <label for="tit" class="textInput_label">Title</label>
            </div>

            <!-- Textarea input field for Description -->
            <div class="textInput">
                <textarea name="des" class="textInput_field" id="des"></textarea><br>
                <label for="des" class="textInput_label">Description</label>
            </div>

            <!-- Text input field for Closing Date -->
            <div class="textInput">
                <input type="text" name="dat" class="textInput_field" id="dat"><br>
                <label for="dat" class="textInput_label">Closing Date</label>
            </div>

            <!-- Radio and checkbox input for Position (Full-time/Part-time) -->
            <div class="radcheInput">
                <div class="radcheInput_radche">
                    <label for="full">Full-time</label>
                    <input type="radio" name="pos" id="full" value="Full-time">
                    <label for="part">Part-time</label>
                    <input type="radio" name="pos" id="part" value="Part-time">
                </div>
                <p class="radcheInput_label">Position</p>
            </div>

            <!-- Radio input for Contract (On-going/Fixed Term) -->
            <div class="radcheInput">
                <div class="radcheInput_radche">
                    <label for="on">On-going</label>
                    <input type="radio" name="con" id="on" value="On-going">
                    <label for="fix">Fixed-term</label>
                    <input type="radio" name="con" id="fix" value="Fixed-term">
                </div>
                <p class="radcheInput_label">Contract</p>
            </div>

            <!-- Checkbox input for Application by (Post/Mail) -->
            <div class="radcheInput">
                <div class="radcheInput_radche">
                    <label for="post">Post</label>
                    <input type="checkbox" name="post" id="post" value="Post">
                    <label for="mail">Mail</label>
                    <input type="checkbox" name="mail" id="mail" value="Mail">
                </div>
                <p class="radcheInput_label">Application by</p>
            </div>

            <!-- Dropdown select for Locations -->
            <div class="textInput">
                <select name="loc" class="textInput_field" id="loc">
                    <option value="ACT">ACT</option>
                    <option value="NSW">NSW</option>
                    <option value="NT">NT</option>
                    <option value="QLD">QLD</option>
                    <option value="SA">SA</option>
                    <option value="TAS">TAS</option>
                    <option value="VIC">VIC</option>
                    <option value="WA">WA</option>
                </select>
                <br><br><label for="loc" class="textInput_label">Locations</label>
            </div>
            
            <!-- Form submission buttons -->
            <div class="buttonInput">
                <input type="submit" value="Post" name="submit">
                <input type="reset" value="Reset">
            </div>
        </form>

        <!-- Link to return to homepage -->
        <a href="index.php">&#10084; Return to homepage &#10084;</a>
    </div>
</body>
</html>