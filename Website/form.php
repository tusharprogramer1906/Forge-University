<?php
$name = $_POST['name'];
$v_email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$email_from = 'info@santoshpublicschool.netlify.app'

$email_subject = 'New Form Submission';

$email_body = "User Name: $name <br>". "User Email: $v_email <br>" . "subject: $subject <br>". "User Message : $message <br>";

$to = 'info19tushar@gmail.com';

$headers = "From : $email_from \r\n";

$headers .= "Reply-To : $v_email \r\n";

mail($to,$email_subject,$email_body,$headers); 

header("Location: contact.html");
?>