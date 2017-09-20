
<?php require('connection.php'); 

$db=null;
       define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','mysecretcleartextpassword');
define('DBNAME','db');

$db = new PDO("mysql:host=".DBHOST.";port=3306;dbname=".DBNAME, DBUSER, DBPASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



$stmt = $db->prepare('SELECT username,lname,contact,email,interest FROM blog_members WHERE username = :username');
$stmt->execute(array(':username' => $_GET['id']));
$row = $stmt->fetch();

//if post does not exists redirect user.
//if($row['postID'] == ''){
  //  header('Location: ./');
    //exit;
//}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blog - <?php echo $row['postTitle'];?></title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
</head>
<body>

    <div id="wrapper">


        <h1>About The Author</h1>
        

        <?php    
            echo '<div>';
                //echo '<h1>'.$row['username'].'</h1>';
                //echo '<p>Posted on '.date('jS M Y', strtotime($row['postDate'])).'</p>';
                 echo '<p>'.$row['username'].'</p>';
                echo '<p>'.$row['lname'].'</p>';
                echo '<p>'.$row['contact'].'</p>';
                echo '<p>'.$row['email'].'</p>';
                echo '<p>'.$row['interest'].'</p>';
                //session_start();
                //$_SESSION['pid'] = $row['postID'];               
            echo '</div>';
        ?>

    </div>





<div>

    
<form  action="like_button.php" method="POST">
  



</form>



</div>

</body>
</html>