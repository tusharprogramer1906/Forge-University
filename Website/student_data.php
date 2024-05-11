<?php
// Database connection
$servername = "localhost"; 
$username = "root"; 
$password = "";
$dbname = "project"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enrollment_number = sanitize_input($_POST["enrollment_number"]);


    $sql = "SELECT * FROM Students WHERE EnrollmentNumber = $enrollment_number";
    $result = $conn->query($sql);

  if ($result->num_rows > 0) {
        // Output data in a table format
        echo "<table border='1'>
                <tr>
                    <th>Enrollment Number</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Course</th>
                    <th>Marks</th>
                </tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["EnrollmentNumber"] . "</td>";
            echo "<td>" . $row["Name"] . "</td>";
            echo "<td>" . $row["Age"] . "</td>";
            echo "<td>" . $row["Course"] . "</td>";
            echo "<td>" . $row["Marks"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "No student found with the provided enrollment number.";
    }
}
$conn->close();
?>

<html>
<body>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Enter Enrollment Number: <input type="text" name="enrollment_number">
    <input type="submit" value="Submit">
</form>
</body>
</html>
