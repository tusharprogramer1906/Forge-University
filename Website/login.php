<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="help.css">
</head>
<body>
	
	<div class="con">
        <div class="form-box">
            <h1 id="title">Login</h1>
            <form method="post">
                <div class="input-grp">

                <div class="input-feilds" id="NameField">
                    <i class="fa-solid fa-user" ></i>
                    <input type="text" placeholder="Your Name" name="user_name">
                </div>

            
                <div class="input-feilds">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" placeholder="Your password"  name="password">
                </div>
                <p>Lost Password <a href="#">Click Here!</a></p>

                <div class="btn-field">
				<button type="submit" id="login-btn">Login</button>
					<a href="signup.php"><button type="button" class="disable" >Sign Up</button></a>

				    
                        
                </div>
				</div>
            </form>
        </div>
    </div>
</body>
</html>

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

			//read from database
			$query = "select * from users where user_name = '$user_name' limit 1";
			$result = mysqli_query($con, $query);

			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{

					$user_data = mysqli_fetch_assoc($result);
					
					if($user_data['password'] === $password)
					{

						$_SESSION['user_id'] = $user_data['user_id'];
						header("Location: https://santoshpublicschool.netlify.app/");
						die;
					}
				}
			}
			
			echo "wrong username or password!";
		}else
		{
			echo "wrong username or password!";
		}
	}

?>
