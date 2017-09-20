<?php include('menu.php');?>
<?php require('connection.php'); 

$db=null;
       define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','mysecretcleartextpassword');
define('DBNAME','db');

$db = new PDO("mysql:host=".DBHOST.";port=3306;dbname=".DBNAME, DBUSER, DBPASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



$stmt = $db->prepare('SELECT postID, postTitle, postCont, postDate,username FROM blog_posts WHERE postID = :postID');
$stmt->execute(array(':postID' => $_GET['id']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if($row['postID'] == ''){
    header('Location: ./');
    exit;
}

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


        <h1>Blog</h1>
        <hr />
        <p><a href="./">Blog Index</a></p>


        <?php    
            echo '<div>';
                echo '<h1>'.$row['postTitle'].'</h1>';
                echo '<p>Posted on '.date('jS M Y', strtotime($row['postDate'])).'</p>';
                echo '<p>'.$row['postCont'].'</p>';
                echo '<p>'.$row['username'].'</p>';
                echo '<a href="viewauthorinfo.php?id='.$row['username'].'">About the author</a>';
                echo '<p>'.$row['postID'].'</p>';
                session_start();
                $_SESSION['pid'] = $row['postID'];               
            echo '</div>';
        ?>

    </div>





<div>

    
<form  action="like_button.php" method="POST">
  


<button type="submit" value="Submit">Submit</button>

</form>



</div>

</body>
</html>