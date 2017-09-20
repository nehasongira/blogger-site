<?php //include config
require_once('connection.php');

//if not logged in redirect to login page
//if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Add User</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
</head>
<body>

<div id="wrapper">

   
   

        <?php

    //if form has been submitted process it
    if(isset($_POST['submit'])){

        //collect form data
        extract($_POST);

        //very basic validation
        if($username ==''){
            $error[] = 'Please enter the username.';
        }

        if($password ==''){
            $error[] = 'Please enter the password.';
        }

        if($passwordConfirm ==''){
            $error[] = 'Please confirm the password.';
        }

        if($password != $passwordConfirm){
            $error[] = 'Passwords do not match.';
        }

        if($email ==''){
            $error[] = 'Please enter the email address.';
        }

        if(!isset($error)){

            //$hashedpassword = $user->create_hash($password);

            try {
                    $db=null;
                //insert into database
                       define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','mysecretcleartextpassword');
define('DBNAME','db');

$db = new PDO("mysql:host=".DBHOST.";port=3306;dbname=".DBNAME, DBUSER, DBPASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $db->prepare('INSERT INTO blog_members (username,password,email) VALUES (:username, :password, :email)') ;
                $stmt->execute(array(
                    ':username' => $username,
                    ':password' => $password,
                    ':email' => $email
                ));

                //redirect to index page
                header('Location: users.php?action=added');
                exit;

            } catch(PDOException $e) {
                echo $e->getMessage();
            }

        }

    }

    //check for any errors
    if(isset($error)){
        foreach($error as $error){
            echo '<p class="error">'.$error.'</p>';
        }
    }
    ?>

    <form action='' method='post'>

        <p><label>Username</label><br />
        <input type='text' name='username' value='<?php if(isset($error)){ echo $_POST['username'];}?>'></p>

        <p><label>Password</label><br />
        <input type='password' name='password' value='<?php if(isset($error)){ echo $_POST['password'];}?>'></p>

        <p><label>Confirm Password</label><br />
        <input type='password' name='passwordConfirm' value='<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>'></p>

        <p><label>Email</label><br />
        <input type='text' name='email' value='<?php if(isset($error)){ echo $_POST['email'];}?>'></p>
        
        <p><input type='submit' name='submit' value='Add User'></p>

    </form>

</div>
