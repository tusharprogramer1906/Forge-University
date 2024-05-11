<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Result</title>
    <link rel="stylesheet" href="mine.css">
</head>
<body>
    
    <section id="banner">
        <img src="img/new.png" class="logo">
</section>
<div align="center" class="head">
    Online Result Portal 
    <hr class="hr" />
</div>

<div class="shead" align="center">
    View Result
</div>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<table border="0" cellpadding="5" cellspacing="5" class="design" align="center">
<tr><td class="labels">Enter your Enrollment No:</td><td><input type="text" required="required" name="enrollment_number" class="fields" size="15"  /></td></tr>
<tr><td colspan="2" align="center"><input type="submit" value="Submit" class="fields" /></td></tr>
</table>
</form>

<div align="center">
  <br>  <a href="success.php" class="iam"> Admin View ? </a>
</div>
</body>
</html>



<?php
// Database connection
$servername = "localhost"; // Change this to your database server name
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "website"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if enrollment number is provided
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enrollment_number = sanitize_input($_POST["enrollment_number"]);

    // Query to select student details by enrollment number
    $sql_student = "SELECT * FROM Students WHERE EnrollmentNumber = $enrollment_number";
    $result_student = $conn->query($sql_student);

    // Query to select subject marks by enrollment number
    $sql_marks = "SELECT Subject, Marks FROM SubjectMarks WHERE EnrollmentNumber = $enrollment_number";
    $result_marks = $conn->query($sql_marks);

    if ($result_student->num_rows > 0) {
        // Display student details
        $row_student = $result_student->fetch_assoc();

        echo "<center> <h2>Student Details</h2></center>";
        echo " <center>Name: " . $row_student["Name"]. "<br>";
        echo "Age: " . $row_student["Age"]. "<br>";
        echo "Course: " . $row_student["Course"]. "<br></center>";

        if ($result_marks->num_rows > 0) {
            // Display subject marks
            echo "<center><h2>Subject Marks</h2></center>"; ?>

<table border="0" cellpadding="5" cellspacing="5" class="design" align="center">
<tr><td class="labels" style="text-decoration:underline;color:#0F0;">Subject</td><td class="labels" style="text-decoration:underline;color:#0F0;">Marks</td></tr>
<?php 
while($row_marks = $result_marks->fetch_assoc()) { ?>
<tr><td class="labels"><?php echo $row_marks["Subject"];?></td><td class="labels"><?php echo $row_marks["Marks"]; } ?></td></tr>
</table>
            <?php
        } else {
            echo "No subject marks found for the provided enrollment number.";
        }
    } else {
        echo "No student found with the provided enrollment number.";
    }
}

$conn->close();
?>