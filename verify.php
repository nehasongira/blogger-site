
<head>
    <title>NETTUTS > Sign up</title>
    <link href="css/style.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <!-- start header div --> 
    <div id="header">
        <h3>BLOGERS > Sign up</h3>
        <li><a href='login_form.html'>login</a></li>
    </div>
    <!-- end header div -->   
     
    <!-- start wrap div -->   
    <div id="wrap">
        <!-- start PHP code -->
        <?php
         
            mysql_connect("localhost", "root", "mysecretcleartextpassword") or die(mysql_error()); // Connect to database server(localhost) with username and password.
            mysql_select_db("db") or die(mysql_error()); // Select registration database.


            if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    // Verify data
    $email = mysql_escape_string($_GET['email']); // Set email variable
    $password = mysql_escape_string($_GET['hash']); // Set hash variable
    //echo $email;
    //echo $password;
                 
    $search = mysql_query("SELECT email, password, active FROM blog_members WHERE email='".$email."' AND password='".$password."' AND active='0'") or die(mysql_error()); 
    //echo $search;
    $match  = mysql_num_rows($search);
    //echo $match;
                 
    if($match > 0){
        // We have a match, activate the account
        mysql_query("UPDATE blog_members SET active='1' WHERE email='".$email."' AND password='".$password."' AND active='0'") or die(mysql_error());
        echo '<div class="statusmsg">Your account has been activated, you can now login</div>';
    }else{
        // No match -> invalid url or account has already been activated.
        echo '<div class="statusmsg">The url is either invalid or you already have activated your account.</div>';
    }
                 
}else{
    // Invalid approach
    echo '<div class="statusmsg">Invalid approach, please use the link that has been send to your email.</div>';
}
             
        ?>
        <!-- stop PHP Code -->
 
         
    </div>
    <!-- end wrap div --> 
</body>
</html>
