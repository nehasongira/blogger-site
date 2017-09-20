<?php
  require "connection.php";
  	$EMAIL_ID = $_POST["email"];
    $PASSWORD = $_POST["psw"];
session_start();
$_SESSION['username1'] = $EMAIL_ID;


    $sql_query="SELECT * FROM blog_members WHERE username LIKE '$EMAIL_ID' AND password LIKE 'KN2111';";


    $result = mysqli_query($con,$sql_query);

    if(mysqli_num_rows($result)>0)
    {
      header("Location: users.php");
    }
    else
    {
      echo "User ID or Password is Incorrect!!!";
    }
?>
