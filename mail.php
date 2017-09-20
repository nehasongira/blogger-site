<?php
$to      = khyatikapadia21@; // Send email to our user
$subject = 'Signup | Verification'; // Give the email a subject 
$message = '
 
Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
 
------------------------
Username: '.$name.'
Password: '.$password.'
------------------------
 
Please click this link to activate your account:
http://www.yourwebsite.com/verify.php?email='.$email.'&hash='.$password.'
 
'; // Our message above including the link
                     
$headers = 'From:noreply@yourwebsite.com' . "\r\n"; // Set from headers
mail($to, $subject, $message, $headers); // Send our email



actual smtp confif of php
[mail function]
; For Win32 only.
; http://php.net/smtp
SMTP=localhost
; http://php.net/smtp-port
smtp_port=25

; For Win32 only.
; http://php.net/sendmail-from
;sendmail_from = me@example.com





//sendmail_from

smtp_server=mail.mydomain.com

; smtp port (normally 25)

smtp_port=25

; SMTPS (SSL) support
;   auto = use SSL for port 465, otherwise try to use TLS
;   ssl  = alway use SSL
;   tls  = always use TLS
;   none = never try to use SSL

smtp_ssl=auto






auth_username=
auth_password=

; if your smtp server uses pop3 before smtp authentication, modify the 
; following three lines.  do not enable unless it is required.

pop3_server=
pop3_username=
pop3_password=










<?php
  require "connection.php";
  	$EMAIL_ID = $_POST["email"];
    $PASSWORD = $_POST["psw"];

$search = mysql_query("SELECT email, password, active FROM blog_members WHERE email='".$EMAIL_ID."' AND password='".$PASSWORD."' AND active='1'") ; 

$match  = mysql_num_rows($search);

   // $sql_query="SELECT * FROM blog_members WHERE username LIKE '$EMAIL_ID' AND password LIKE '$PASSWORD' AND active='0';";


    $result = mysqli_query($con,$search);

    if(mysqli_num_rows($result)>0)
    {
      header("Location: blogger.html");
    }
    else
    {
      echo "User ID or Password is Incorrect!!!";
    }
?>
