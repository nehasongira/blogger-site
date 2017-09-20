<?php //include config
require_once('connection.php');

//if not logged in redirect to login page
//if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>We hope u loved oursite...</title>
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
        if($fname ==''){
            $error[] = 'Please enter the firstname.';
        }

        if($lname ==''){
            $error[] = 'Please enter the lastname.';
        }

        if($cname ==''){
            $error[] = 'Please confirm the country.';
        }
        if($email ==''){
            $error[] = 'Please enter the email id.';
        }

        //if($password != $passwordConfirm){
          //  $error[] = 'Passwords do not match.';
        //}

        if($contact ==''){
            $error[] = 'Please enter the contact info.';
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

                $stmt = $db->prepare('INSERT INTO viewers (fname,lname,cname,email,contact) VALUES (:fname, :lname,:cname,:email,:contact)') ;
                $stmt->execute(array(
                    ':fname' => $fname,
                    ':lname' => $lname,
                    ':cname' => $cname,
                    ':email' => $email,
                    ':contact' => $contact
                ));

                //redirect to index page
                header('Location: index1.php?action=added');
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



<html>
<head>
<style>
input[type=text], select, textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-top: 6px;
    margin-bottom: 16px;
    resize: vertical;
}

input[type=submit] {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}

.container {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
}
</style>
</head>
<body>

<h3>Contact Form</h3>

<div class="container">
<form action='' method='post'>

        <p><label>Firstname</label><br />
        <input type='text' name='fname' value='<?php if(isset($error)){ echo $_POST['fname'];}?>'></p>

        <p><label>Lastname</label><br />
        <input type='text' name='lname' value='<?php if(isset($error)){ echo $_POST['lname'];}?>'></p>

        <p><label> Country</label><br />
        <input type='text' name='cname' value='<?php if(isset($error)){ echo $_POST['cname'];}?>'></p>

        <p><label>Email</label><br />
        <input type='text' name='email' value='<?php if(isset($error)){ echo $_POST['email'];}?>'></p>
        

        <p><label>contact Information</label><br />
        <input type='text' name='contact' value='<?php if(isset($error)){ echo $_POST['contact'];}?>'></p>
        
        <p><input type='submit' name='submit' value='Submit'></p>

    </form>

</div>

  
</div>

</body>
</html>


    