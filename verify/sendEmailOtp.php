<!-- Scroll below to edit smtp username and password -->
<?php
// Function to generate OTP
function generateNumericOTP($n) {
    $generator = "1357902468";
    $result = "";

    for ($i = 1; $i <= $n; $i++) {
        $result .= substr($generator, (rand()%(strlen($generator))), 1);
    }
    // Return result
    return $result;
}

session_start();
$n = 6;
$_SESSION["backendOtp"] = generateNumericOTP($n);
?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require '../credentials.php';

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
    $mail->addAddress($_POST['email'], $_POST['name']);

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Network Complain Portal';
    $mail->Body    = 'This is your one time password for Network Complain Portal -> <b>'.$_SESSION["backendOtp"].'</b>';
    $mail->AltBody = 'This is your one time password for Network Complain Portal -> '.$_SESSION["backendOtp"];

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
echo "<script>if($flag==1){ alert('OTP has been sent to your email.'); }</script>";
echo "<script>if($flag==0){ alert('Failed to send OTP'); }</script>";
echo "<script>window.open('','_parent',''); window.close();</script>";
?>
</body>
</html>
