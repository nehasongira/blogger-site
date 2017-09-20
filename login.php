<?php
  require "connection.php";
  	$EMAIL_ID = $_POST["email"];
    $PASSWORD = $_POST["psw"];
session_start();
$_SESSION['username1'] = $EMAIL_ID;


    $sql_query="SELECT * FROM blog_members WHERE username LIKE '$EMAIL_ID' AND password LIKE '$PASSWORD' and active='1';";


    $result = mysqli_query($con,$sql_query);

    if(mysqli_num_rows($result)>0)
    {
      //echo '<p><a href="viewpost.php? id='.$row['postID'].'">Read More</a></p>';
      header("Location: indexblogger.php? id=$EMAIL_ID");
    }
    else
    {
      echo "User ID or Password is Incorrect!!!";
    }
?>
