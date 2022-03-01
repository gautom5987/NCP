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

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Network Complaint Portal</title>
    <link rel="icon" href="../res/logo.png">

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/checkout/">

    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

    <!-- Custom styles for this template -->
    <link href="../css/form-validation.css" rel="stylesheet">

    <script type="text/javascript" defer>
        function checkProblem(val) {
            var element = document.getElementById('problemInput');
            if (val === 'other')
                element.style.display = 'block';
            else
                element.style.display = 'none';
        }
    </script>

</head>
<body class="bg-light">

<div class="container">
    <main>
        <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4" src="../res/mnnit.png" alt="" width="250" height="90">
            <h2>Complaint Information</h2>
            <p class="lead">You can view complaint details here.</p>
        </div>

        <div class="row g-lg-3">
            <div class="col-md-7 col-lg-8">
                <h4 class="mb-3">Complaint Details</h4>
                <form class="needs-validation"  method="POST" action="../verify/updateComplain.php?id=<?php echo $id ?>">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" value="<?php echo $uname ?>" name="name" class="form-control" id="name" placeholder="" required readonly>
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" value="<?php echo $email ?>" name="email" class="form-control" id="email" placeholder="" required readonly>
                        </div>

                        <div class="col-12">
                            <label for="mobile" class="form-label">Mobile No.</label>
                            <input type="number" value="<?php echo $mobile ?>" class="form-control" name="mobile" id="mobile" placeholder="" required readonly>
                        </div>

                        <div class="col-12">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" value="<?php echo $ulocation ?>" id="location" name="location" required readonly>
                        </div>

                        <div class="col-sm-6">
                            <label for="time" class="form-label">Availability time</label>
                            <input type="text" value="<?php echo $fromt.'-' .$till ?>" class="form-control" id="avail" name="avail" required readonly/>
                        </div>

                        <div class="col-md-5">
                            <label for="problemName" class="form-label">Problem</label>
                            <input type="text" value="<?php echo $str[$problemName] ?>" class="form-control" id="problemName" name="problemName" required readonly/>
                        </div>

                        <div class="col-12"  id="problemInput">
                            <label for="problemDes" class="form-label">Problem Description</label>
                            <textarea class="form-control" placeholder="<?php echo $problemDes ?>" id="problemDes" name="problemDes" rows="4" cols="50" required readonly></textarea>
                        </div>

                        <div class="col-sm-6">
                            <label for="status" class="form-label">Status</label>
                            <input type="text" value="<?php echo $isSolved ?>" class="form-control" name="status" id="status" required readonly>
                        </div>

                        <div  <?php if($purpose=='ticket') echo 'style="display : none"'; ?> >
                        <label for="markAs" class="form-label">Mark as</label>
                        <div class="my-3">
                            <div class="form-check">
                                <input id="solved" name="markAs" value="1" type="radio" class="form-check-input" required>
                                <label class="form-check-label" for="solved">Solved</label>
                            </div>
                            <div class="form-check">
                                <input id="unsolved" name="markAs" value="0" type="radio" class="form-check-input" checked required>
                                <label class="form-check-label" for="unsolved">Unsolved</label>
                            </div>
                        </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="asignee" class="form-label">Assigned to</label>
                            <input type="text" value="<?php echo $asignee ?>" class="form-control" name="asignee" id="asignee" required readonly>
                        </div>

                        <div class="col-md-5" <?php if($purpose=='ticket' || $purpose=='tech') echo 'style="display : none"'; ?> >
                            <label for="country" class="form-label">Assign to</label>
                            <select class="form-select" name="selectedTechnician" <?php if($isSolved=="solved") echo "disabled"; ?> >
                                <option value="" disabled selected>pick</option>
                                <?php
                                $sql = mysqli_query($conn, "SELECT * From TechnicianData");
                                if($sql) {
                                    $row = mysqli_num_rows($sql);
                                    $ans = "";
                                    while ($row = mysqli_fetch_array($sql)){
                                        $ans .= '<option value="'. $row['id'] .'">' . $row['uname'] .'</option> ' ;
                                    }
                                    echo $ans;
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">
                                Please select Technician.
                            </div>
                        </div>

                        <div class="col-12"  id="adminComment"  <?php if($purpose=='ticket' || $purpose=='tech') echo 'style="display : none"'; ?> >
                            <label for="problemDes" class="form-label">Admin Comments</label>
                            <textarea class="form-control" id="adminComment" name="adminComment" rows="4" cols="50"><?php echo $adminComment ?></textarea>
                        </div>

                        <div class="col-12" <?php if($purpose=='ticket') echo 'style="display : none"'; ?> >
                            <label for="techComment" class="form-label">Technician Comments</label>
                            <textarea class="form-control" id="techComment" name="techComment" rows="10" cols="50" readonly><?php echo $techComment ?></textarea>
                        </div>

                        <div class="col-12" <?php if($purpose!='tech') echo 'style="display : none"'; ?> >
                            <label for="newComment" class="form-label">Add Comments</label>
                            <textarea class="form-control" id="newComment" name="newComment" rows="4" cols="50"></textarea>
                        </div>

                    </div>

                    <br>

                    <button class="w-50 btn btn-primary btn-lg" id="submit" type="submit" <?php if($purpose=='ticket') echo 'style="display : none"'; ?>>Submit</button>
                </form>
            </div>
        </div>
    </main>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2022 Computer Centre MNNIT</p>
    </footer>
</div>


<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

<script src="../assets/form-validation.js"></script>
</body>
</html>

<?php
$conn->close();
?>