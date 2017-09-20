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
        if($lname ==''){
            $error[] = 'Please enter the lastname.';
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

        if($contact ==''){
            $error[] = 'Please enter the contact.';
        }

        if($interest ==''){
            $error[] = 'Please enter your genre of interest.';
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

                $stmt = $db->prepare('INSERT INTO blog_members (username,password,email,lname,contact,interest) VALUES (:username, :password, :email,:lname,:contact,:interest)') ;
                $stmt->execute(array(
                    ':username' => $username,
                    ':password' => $password,
                    ':email' => $email,
                    ':lname' => $lname,
                    ':contact' => $contact,
                    ':interest' => $interest
                ));
    







$to      = $email; // Send email to our user
$subject = 'Signup | Verification'; // Give the email a subject 
$message = '
 
Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
 
------------------------
Username: '.$username.'
Password: '.$password.'
------------------------
 
Please click this link to activate your account:
http://localhost/khlab/verify.php?email='.$email.'&hash='.$password.'
 
'; // Our message above including the link
                     
$headers = 'From:noreply@yourwebsite.com' . "\r\n"; // Set from headers
mail($to, $subject, $message, $headers); // Send our email










                //redirect to index page
                header('Location: index.php?action=added');
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


        <p><label>last name</label><br />
        <input type='text' name='lname' value='<?php if(isset($error)){ echo $_POST['lname'];}?>'></p>

        <p><label>Password</label><br />
        <input type='password' name='password' value='<?php if(isset($error)){ echo $_POST['password'];}?>'></p>

        <p><label>Confirm Password</label><br />
        <input type='password' name='passwordConfirm' value='<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>'></p>

        <p><label>Email</label><br />
        <input type='text' name='email' value='<?php if(isset($error)){ echo $_POST['email'];}?>'></p>

        
        <p><label>Contact</label><br />
        <input type='text' name='contact' value='<?php if(isset($error)){ echo $_POST['contact'];}?>'></p>

        <p><label>Interest</label><br />
        <input type='text' name='interest' value='<?php if(isset($error)){ echo $_POST['interest'];}?>'></p>

        
        <p><input type='submit' name='submit' value='Sign up'></p>

    </form>

</div>
