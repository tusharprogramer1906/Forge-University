<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Santosh Public School</title>
    <link rel="stylesheet" href="css.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script src="https://kit.fontawesome.com/9e6a6707dd.js" crossorigin="anonymous"></script>

</head>
<body>
       
    <div class="con">
        <div class="form-box">
            <h1 id="title">Login</h1>
            <form method="post">
                <div class="input-grp"></div>

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
                    <button type="button" id="login-btn" value="Login">Login</button>
                    <button type="button" class="disable" id="signup-btn">Sign Up</button>
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