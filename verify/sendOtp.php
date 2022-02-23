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
$flag = 0;
$message='';
$apiKey = '6aa2981b-7d04-11ec-b9b5-0200cd936042';
$mobile = $_POST['mobile'];
?>

<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://2factor.in/API/V1/".$apiKey."/SMS/".$mobile."/".$_SESSION['backendOtp'],
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "",
  CURLOPT_HTTPHEADER => array(
    "content-type: application/x-www-form-urlencoded"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
  $flag = 0;
} else {
  echo $response;
  $flag = 1;
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
echo "<script>if($flag==1){ alert('Otp has been sent to your mobile.'); }</script>";
echo "<script>if($flag==0){ alert('Failed to send otp!'); }</script>";
echo "<script>window.open('','_parent',''); window.close();</script>";
?>
</body>
</html>
