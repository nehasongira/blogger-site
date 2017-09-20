
<?php
session_start();
include("connection.php");
if(!isset($_SESSION['username']))
{
    $_SESSION['user'] = session_id();
}
$uid = $_SESSION['user'];
$pid = $_SESSION['pid'];
  // set your user id settings
echo $uid;
echo $pid;
 
$query  = "SELECT * FROM  `blog_posts`"; // products list
$res    = mysqli_query($con,$query);
$HTML = "";
while($row=mysqli_fetch_array($res))
{
    // get likes and dislikes of a product
    $query = mysqli_query($con,"select sum(`like`) as `like`,sum(`unlike`) as `unlike` from `likes` where pid = ".$row['postID']);
    $rowCount = mysqli_fetch_array($query);
    if($rowCount['like'] == "")
        $rowCount['like'] = 1;
        
    if($rowCount['unlike'] == "")
        $rowCount['unlike'] = 2;
        
    if($uid == "") // if user not loggedin then show login link on like button click
    {
        $like = '
            <input onclick="location.href = \'login.php\';" type="button" value="'.$rowCount['like'].'" rel="'.$row['postID'].'" data-toggle="tooltip"  data-placement="top" title="Login to Like" class="button_like" />
            <input onclick="location.href = \'login.php\';" type="button" value="'.$rowCount['unlike'].'" rel="'.$row['postID'].'" data-toggle="tooltip" data-placement="top" title="Login to Unlike" class="button_unlike" />';
    }
    else
    {
        $query = mysqli_query($con,"SELECT * from `likes` WHERE pid='".$row['postID']."' and uid='".$uid."'");
        if(mysqli_num_rows($query)>0){ //if already liked od disliked a product
            $likeORunlike = mysqli_fetch_array($query);
            // clear values of variables
            $liked = '';
            $unliked = '';
            $disable_like = '';
            $disable_unlike = '';
            
            if($likeORunlike['like'] == 1) // if alredy liked then disable like button
            {
                $liked = 'disabled="disabled"';
                $disable_unlike = "button_disable";
            }
            elseif($likeORunlike['unlike'] == 1) // if alredy dislike the disable unlike button
            {
                $unliked = 'disabled="disabled"';
                $disable_like = "button_disable";
            }
            
            $like = '
            <input '.$liked.' type="button" value="'.$rowCount['like'].'" rel="'.$row['id'].'" data-toggle="tooltip"  data-placement="top" title="Like" class="button_like '.$disable_like.'" id="linkeBtn_'.$row['id'].'" />
            <input '.$unliked.' type="button" value="'.$rowCount['unlike'].'" rel="'.$row['id'].'" data-toggle="tooltip" data-placement="top" title="Un-Like" class="button_unlike '.$disable_unlike.'" id="unlinkeBtn_'.$row['id'].'" />
            ';
        }
        else{ //not liked and disliked product
            $like = '
            <input  type="button" value="'.$rowCount['like'].'" rel="'.$row['postID'].'" data-toggle="tooltip"  data-placement="top" title="Like" class="button_like" id="linkeBtn_'.$row['postID'].'" />
            <input  type="button" value="'.$rowCount['unlike'].'" rel="'.$row['postID'].'" data-toggle="tooltip" data-placement="top" title="Un-Like" class="button_unlike" id="unlinkeBtn_'.$row['postID'].'" />
            ';
        }
    }
        
    $HTML.='
        <li> <img src="images/'.$row['postID'].'" class="">
            <h4 class="">'.$row['postCont'].'</h4>
            <div class="product-price">
                <span class="normal-price">$'.$row['username'].'</span>
            </div>
            <a href="#" class="btn btn-default navbar-btn" >Buy Now</a>
            <div class="grid">
                '.$like.'
            </div>
        </li>';
}
 
?>
<?php
if($_POST)
{
    $pid    = mysqli_real_escape_string($con,$_POST['pid']);  // product id
    $op     = mysqli_real_escape_string($con,$_POST['op']);  // like or unlike op
    echo $pid;
    echo $op;
 
    if($op == "like")
    {
        $gofor = "like";
    }
    elseif($op == "unlike")
    {
        $gofor = "unlike";
    }
    else
    {
        exit;
    }
    // check if alredy liked or not query
    $query = mysqli_query($con,"SELECT * from `likes` WHERE pid='".$pid."' and uid='".$uid."'");
    $num_rows = mysqli_num_rows($query);
 
    if($num_rows>0) // check if alredy liked or not condition
    {
        $likeORunlike = mysqli_fetch_array($query);
    
        if($likeORunlike['like'] == 1)  // if alredy liked set unlike for alredy liked product
        {
            mysqli_query($con,"update `likes` set `unlike`=1,`like`=0 where id='".$likeORunlike['id']."' and uid='".$uid."'");
            echo 2;
        }
        elseif($likeORunlike['unlike'] == 1) // if alredy unliked set like for alredy unliked product
        {
            mysqli_query($con,"update `likes` set `like`=1,`unlike`=0 where id='".$likeORunlike['id']."' and uid='".$uid."'");
            echo 2;
        }
    }
    else  // New Like
    {
       mysqli_query($con,"INSERT INTO `likes` (`pid`,`uid`, `$gofor`) VALUES ('$pid','$uid','1')");
       echo 1;
    }
    exit;
}
?>


<!doctype html>
<head>
    <title>Create Like & Unlike System in PHP MySQL and jQuery [Improved] | PHPGang.com</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <script type="text/javascript" src="jquery-1.8.0.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  </head>
  <body>
  <h2><a href="http://www.phpgang.com/?p=4814">Create Like & Unlike System in PHP MySQL and jQuery [Improved]</a></h2><br><br>
  <div class="container">
    <div class="row">
    <h1>PHPGang Shopping store</h1>
        <div class="col-sm-12 col-md-12">
            <ul class="thumbnail-list">
            <?php echo $HTML; ?>
            </ul>
        </div>
    </div>
</div>
  </body>
</html>




