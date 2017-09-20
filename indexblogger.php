

<?php require('connection.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blog</title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
</head>
<body>

    <div id="wrapper">

        <h1>Blog</h1>
        
        echo 
        <a href="add-post.php">add-post</a>
    </br>
<a href="edit-post.php">edit-post</a>
        <hr />

<?php
            try {$db=null;
                  define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','mysecretcleartextpassword');
define('DBNAME','db');


$db = new PDO("mysql:host=".DBHOST.";port=3306;dbname=".DBNAME, DBUSER, DBPASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
session_start();



$uname= $_SESSION['username1']; 
echo $uname;// green


//$me=$_GET['id'];
//echo $me;

                $stmt = $db->query('SELECT postID, postTitle, postDesc, postDate ,username FROM blog_posts ORDER BY postID desc ');
 //$stmt->execute(array(':uname' => $_GET['id']));
  //$row = $stmt->fetch();


                while($row = $stmt->fetch() ){
                    if($row['username']==$uname)
                    {
                    echo '<div>';
                        echo '<h1><a href="viewpost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></h1>';
                        echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['postDate'])).'</p>';
                        echo '<p>'.$row['postDesc'].'</p>';
                         echo '<p>'.$row['username'].'</p>';               
                        echo '<p><a href="viewpost.php?id='.$row['postID'].'">Read More</a></p>'; 
                       echo '<p>'.$row['postID'].'</p>';              
                    echo '</div>';
                      }  
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        ?>

    </div>

<?php //session_start();
$_SESSION['user'] = $uname;

?>
