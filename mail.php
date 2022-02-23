<!-- Scroll below to edit smtp username and password -->
<?php
session_start();

$id = $_SESSION["ticketId"];
$type = $_SESSION["type"];

?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'credentials.php';

$mail = new PHPMailer(true);
$flag = 0;

// make required changes in the commented lines
try {
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host       = $smtpHost;                             //SMTP host -> change if other than gmail
    $mail->SMTPAuth   = true;
    $mail->Username   = $smtpUsername;                     //Enter SMTP username here
    $mail->Password   = $smtpPassword;                               //Enter SMTP password here
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    $mail->setFrom($smtpUsername, 'MNNIT Computer Centre'); // Enter email address here too
    $mail->addAddress($_SESSION['email'], $_SESSION['name']);

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Network Complain Portal';
    if($type=="id") {
        $mail->Body    = 'This is your ticket number -> <b>'.$id.'</b>';
        $mail->AltBody = 'This is your ticket number -> '.$id;
    } else if($type=="update") {
        $mail->Body    = 'Your complain for ticket number <b>'.$id.'</b> has been closed.';
        $mail->AltBody = 'This is your ticket number '.$id.' has been closed.';
    }

    $mail->send();
    echo 'Message has been sent';
    $flag = 1;
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    $flag = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>page</title>
</head>
<body>
  <?php
//    echo "<script>if($flag==1){ alert('Ticket Number has been mailed to your email.'); }</script>";
//    echo "<script>if($flag==0){ alert('Failed to send ticket number to your email.'); }</script>";
    echo "<script>window.open('','_parent',''); window.close();</script>";
  ?>
</body>
</html>
