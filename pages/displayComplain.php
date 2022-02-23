<?php
    session_start();

    if(!isset($_SESSION['purpose'])) {
        $_SESSION['purpose'] = 'ticket';
    }
    $purpose = $_SESSION['purpose'];

    $id = $_REQUEST['id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ncp";

    require_once "../res/strings.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// variables for storing dynamic data from the user
$uname=$mobile=$email=$ulocation=$problemName=$problemDes="";

// fetching data
$sql = "SELECT * FROM ComplainData WHERE id='$id'";

$result = $conn->query($sql);
$data = $result -> fetch_assoc();

$uname = $data['uname'];
$email = $data['email'];
$mobile = $data['mobile'];
$ulocation = $data['ulocation'];
$problemName = $data['problemName'];
$problemDes = $data['problemDes'];
$isSolved = $data['isSolved'];
$asignee = $data['asignee'];
$fromt = $data['fromt'];
$till = $data['till'];
$adminComment = $data['adminComment'];
$techComment = $data['techComment'];

if($isSolved ==="0")
    $isSolved = "unsolved";
else
    $isSolved = "solved";

if ($asignee==null)
    $asignee = "None";
else {
    $sql = "SELECT uname FROM TechnicianData WHERE id='$asignee'";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
    $asignee = $data['uname'];
    $_SESSION['asignee'] = $asignee;
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="icon" href="../res/logo.png">
    <title>Network Complain Portal</title>

</head>

<body>
<div align="center">
    <img src="../res/mnnit.png" height="90" width="250">
</div>
<h1 id="login">Complain Detail</h1>

<br>

<!-- <input type="text" placeholder="location" required=true> -->

<form method="POST" action="../verify/updateComplain.php?id=<?php echo $id ?>" class="box">
    <p>Name :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input value="<?php echo $uname ?>" name="name" required=true readonly></p>

    <p>Email :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input size="30" value="<?php echo $email ?>" name="email" required readonly></p>

    <p>Mobile Number :&nbsp;&nbsp;&nbsp;<input value="<?php echo $mobile ?>" name="mobile" required readonly></p>

    <p>Location :&nbsp;&nbsp;&nbsp;&nbsp;
        <textarea name="location" rows="4" placeholder="<?php echo $ulocation ?>" cols="50" required readonly></textarea>
    </p>

    <p>Availability Time :&nbsp;&nbsp;&nbsp;<input value="<?php echo $fromt.'-' .$till ?>" name="avail" required readonly></p>

    <p>Problem :&nbsp;&nbsp;&nbsp;
        <input size="30" type="email" value="<?php echo $str[$problemName] ?>" name="problemName" required readonly>
    </p>

    <p>Problem Description :&nbsp;&nbsp;&nbsp;&nbsp;
        <textarea name="problemDes" rows="4" placeholder="<?php echo $problemDes ?>" cols="50" required readonly></textarea>
    </p>

    <p>Status :&nbsp;&nbsp;&nbsp;<input value="<?php echo $isSolved ?>" name="status" required readonly></p>

    <p <?php if($purpose=='ticket') echo 'style="display : none"'; ?> >Mark as :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="markAs" value="1" required <?php //if($isSolved=="solved") echo "disabled"; ?> >
        <label for="solved">Solved</label>
        <input type="radio" name="markAs" value="0" required <?php //if($isSolved=="solved") echo "disabled"; ?> >
        <label for="unsolved">Unsolved</label><br>
    </p>

    <p>Assigned to :&nbsp;&nbsp;&nbsp;<input value="<?php echo $asignee ?>" name="asignee" required readonly ></p>

    <p <?php if($purpose=='ticket' || $purpose=='tech') echo 'style="display : none"'; ?> >Assign to :&nbsp;&nbsp;&nbsp;&nbsp;
        <select name="selectedTechnician"<?php if($isSolved=="solved") echo "disabled"; ?> >
            <option value="" disabled selected>pick</option>
            <?php
            $sql = mysqli_query($conn, "SELECT * From TechnicianData");
            $row = mysqli_num_rows($sql);
            $ans = "";
            while ($row = mysqli_fetch_array($sql)){
                $ans .= '<option value="'. $row['id'] .'">' . $row['uname'] .'</option> ' ;
            }
            echo $ans;
            ?>

        </select>
    </p>

    <p <?php if($purpose=='ticket' || $purpose=='tech') echo 'style="display : none"'; ?> >Admin Comments :  &nbsp;&nbsp;&nbsp;&nbsp;
        <textarea name="adminComment" rows="4" cols="60"><?php echo $adminComment ?></textarea>
    </p>

    <p <?php if($purpose=='ticket') echo 'style="display : none"'; ?> >Technician Comments :  &nbsp;&nbsp;&nbsp;&nbsp;
        <textarea name="techComment" rows="4" cols="60" readonly><?php echo $techComment ?></textarea>
    </p>

    <p <?php if($purpose!='tech') echo 'style="display : none"'; ?> >Add Comment :  &nbsp;&nbsp;&nbsp;&nbsp;
        <textarea name="newComment" rows="4" cols="60"></textarea>
    </p>

    <br>

    <input type="submit" value="   Update   " id="submit" <?php if($purpose=='ticket') echo 'style="display : none"'; ?> >

</form>

</body>

</html>

<?php
    $conn->close();
?>
