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
$enrollmentnumber = $name = $age = $course = "";
$enrollmentnumber_err = $name_err = $age_err = $course_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

if (empty(trim($_POST["enrollmentnumber"]))) {
        $name_err = "Please enter enrollment number.";
    } else {
        $name = trim($_POST["enrollmentnumber"]);
    }
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate age
    if (empty(trim($_POST["age"]))) {
        $age_err = "Please enter age.";
    } else {
        $age = trim($_POST["age"]);
    }

    // Validate course
    if (empty(trim($_POST["course"]))) {
        $course_err = "Please enter course.";
    } else {
        $course = trim($_POST["course"]);
    }
    $enrollmentnumber=$_POST['enrollmentnumber'];
    // Check input errors before inserting into database
    if (empty($enrollmentnumber_err) && empty($name_err) && empty($age_err) && empty($course_err)) {
        // Prepare an insert statement for Students table
        $sql_student = "INSERT INTO Students (enrollmentnumber ,Name, Age, Course) VALUES (?, ?, ?,?)";
        if ($stmt_std = $conn->prepare($sql_student)) {
            // Bind variables to the prepared statement as parameters
            $param_enrollmentnumber = $enrollmentnumber;
            $param_name = $name;
            $param_age = $age;
            $param_course = $course;
            $stmt_std->bind_param("isis",$param_enrollmentnumber ,$param_name, $param_age, $param_course);
            // Set parameters
            // Attempt to execute the prepared statement
           
          
            $stmt_std->execute();
            // Close statement
            $stmt_std->close();
           
        }

         header("location: admin_test.php");
        exit();
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
     New Entry
</div>

<!-- <table border="0" cellpadding="5" cellspacing="5" class="design" align="center">
<tr><td class="labels">Enter your Enrollment No:</td><td><input type="text" required="required" name="enrollment_number" class="fields" size="15"  /></td></tr>
<tr><td colspan="2" align="center"><input type="submit" value="Submit" class="fields" /></td></tr>
</table> -->

<div class="container" align="center">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <table border="0" cellpadding="5" cellspacing="5" class="design" align="center">
  
    <tr><td class="labels"> EnrollmentNumber </td>
          <td>  <input type="text" name="enrollmentnumber" class="fields" <?php echo (!empty($enrollmentnumber_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $enrollmentnumber; ?>"></td>
            <span class="invalid-feedback"><?php echo $enrollmentnumber_err; ?></span>
        
        <tr><td>
        <tr><td class="labels">Name</td>
            <td><input type="text" name="name" class="fields"<?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>"></td>
            <span class="invalid-feedback"><?php echo $name_err; ?></span>
       
        <tr><td class="labels"> Age </td>
          <td> <input type="number" name="age"class="fields" <?php echo (!empty($age_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $age; ?>"></td>
            <span class="invalid-feedback"><?php echo $age_err; ?></span>
      
       
            <tr><td class="labels">Course</td>
           <td> <input type="text" name="course" class="fields" <?php echo (!empty($course_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $course; ?>"></td>
            <span class="invalid-feedback"><?php echo $course_err; ?></span>
       

            <tr><td class="labels">        <input type="submit" class="fields" value="Submit"></td>
        </div>
        
    </form>
</div>

</body>
</html>

