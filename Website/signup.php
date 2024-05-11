<!DOCTYPE html>
<html>
<head>
	<title>Signup</title>
	<link rel="stylesheet" href="help.css">
	<script src="https://kit.fontawesome.com/9e6a6707dd.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="con">
        <div class="form-box">
            <h1 id="title">Sign Up</h1>
            <form method="post">
                <div class="input-grp">

                <div class="input-feilds" id="NameField">
                    <i class="fa-solid fa-user" ></i>
                    <input type="text" placeholder="Your Name" name="user_name">
                </div>

				<div class="input-feilds" id="NameField">
				<i class="fa-solid fa-envelope"></i>
                    <input type="email" placeholder="Your Email" name="email">
                </div>
            
                <div class="input-feilds">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" placeholder="Your password"  name="password">
                </div>
            
                <div class="btn-field">
						<button type="submit" id="login-btn">Sign Up</button>
						<a href="login.php"><button type="button" id="login-btn" class="disable">Login</button></a>
                </div>
				</div>
            </form>
        </div>
    </div>

			

		
</body>
</html>


<!-- PHP CODE -->
<?php 
session_start();

	include("connection.php");
	include("functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];

		if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
		{

			//save to database
			$user_id = random_num(20);
			$query = "insert into users (user_id,user_name,password) values ('$user_id','$user_name','$password')";

			mysqli_query($con, $query);

			header("Location: https://santoshpublicschool.netlify.app/");
			die;
		}else
		{
			echo "Please enter some valid information!";
		}
	}
?>