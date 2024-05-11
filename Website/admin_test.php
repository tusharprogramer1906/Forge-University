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

// Define variables and initialize with empty values
$enrollmentnumber = $subject = $marks = "";
$enrollmentnumber_err = $subject_err = $marks_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate enrollment number
    if (empty(trim($_POST["enrollmentnumber"]))) {
        $enrollmentnumber_err = "Please enter enrollment number.";
    } else {
        $enrollmentnumber = trim($_POST["enrollmentnumber"]);
    }

    // Validate subject
    if (empty(trim($_POST["subject"]))) {
        $subject_err = "Please enter subject.";
    } else {
        $subject = trim($_POST["subject"]);
    }

    // Validate marks
    if (empty(trim($_POST["marks"]))) {
        $marks_err = "Please enter marks.";
    } else {
        $marks = trim($_POST["marks"]);
    }
$enrollmentnumber = trim($_POST["enrollmentnumber"]);


    // Check input errors before inserting into database
    if (empty($enrollment_number_err) && empty($subject_err) && empty($marks_err)) {
        // Prepare a select statement to check if the enrollment number exists
        $sql_check_enrollment = "SELECT EnrollmentNumber FROM Students WHERE EnrollmentNumber = ?";
        if ($stmt_check_enrollment = $conn->prepare($sql_check_enrollment)) {
            // Bind variables to the prepared statement as parameters
            $stmt_check_enrollment->bind_param("s", $param_enrollmentnumber);

            // Set parameters
            $param_enrollmentnumber = $enrollmentnumber;
            // Attempt to execute the prepared statement
            if ($stmt_check_enrollment->execute()) {
                // Store result
                $stmt_check_enrollment->store_result();
                if ($stmt_check_enrollment->num_rows == 1) {
                    // Enrollment number exists, proceed to insert marks
                    // Prepare an insert statement for SubjectMarks table
                    $sql_insert_marks = "INSERT INTO SubjectMarks (EnrollmentNumber, Subject, Marks) VALUES (?, ?, ?)";
                    if ($stmt_insert_marks = $conn->prepare($sql_insert_marks)) {
                        // Bind variables to the prepared statement as parameters
                        $stmt_insert_marks->bind_param("iss", $param_enrollmentnumber, $param_subject, $param_marks);
                        // Set parameters
                        $param_subject = $subject;
                        $param_marks = $marks;
                        // Attempt to execute the prepared statement
                        if ($stmt_insert_marks->execute()) {
                            // Redirect to success page
                            header("location: marks.php");
                            exit();
                        } else {
                            echo "Something went wrong. Please try again later.";
                        }
                        // Close statement
                        $stmt_insert_marks->close();
                    }
                } else {
                    // Enrollment number does not exist
                    $enrollmentnumber_err = "Enrollment number does not exist.";
                }
            } else {
                echo "Something went wrong. Please try again later.";
            }
            // Close statement
            $stmt_check_enrollment->close();
        }
    }

    // Close connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Details</title>
    <link rel="stylesheet" href="grid.css">
</head>
<body>
<section id="banner">
        <img src="new.png" class="logo">
</section>

<div align="center" class="head">
    Admin Control
    <hr class="hr" />
</div>

<div class="shead" align="center">
   Welcome Admin !
</div>

<div class="container" align="center">
    <h2>Add Marks</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <table border="0" cellpadding="5" cellspacing="5" class="design" align="center">
    <tr><td class="labels">Enrollment_Number</td>
       <td> <input type="text"  class="fields" name="enrollmentnumber"  <?php echo (!empty($enrollmentnumber_err)) ? 'is-invalid' : ''; ?> value="<?php echo $enrollmentnumber; ?>"></td>
            <span class="invalid-feedback"><?php echo $enrollmentnumber_err; ?></span>
            <tr><td class="labels">subject</td><td>
            <input type="text" name="subject"  class="fields" ></td>
        
            <tr><td class="labels">marks</td>
            <td><input type="number" name="marks" class="fields"></td>
            <tr><td colspan="2">
            <input type="submit" class="fields" value="Submit"></td>
    </form>
</div>

</body>
</html>



