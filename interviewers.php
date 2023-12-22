<?php 
    session_start();
    if($_SESSION['role']==1)
    {
        header('Location: 404');
        exit();
    }
    if (!isset($_SESSION['user_email'])) {
        header('Location: index');
        exit();
    }
    include 'conn.php';
    $email = $_SESSION['user_email'];
    $sql10 = "SELECT email from candidate_allocation WHERE teacher1='$email' OR teacher2='$email' OR teacher3='$email'";
    $result10 = $conn->query($sql10);
    if ($result10->num_rows > 0) {
        while($row = $result10->fetch_assoc()) {
            $emails = $row['email'];
        }
    }
    $sql4 = "SELECT * from candidate_info WHERE email='$emails'";
    $result3 = $conn->query($sql4);
    if ($result3->num_rows > 0) {
        while($row = $result3->fetch_assoc()) {
            $name1 = $row['name'];
            $exp_teaching = $row['exp_teaching'];
            $exp_industry = $row['exp_industry'];
            $branch = $row['branch'];
            $pan = $row['pan'];
        }
    }
    if(isset($_POST["submit"])){
        $marks1 = $_POST["parta"];
        $marks2 = $_POST["partb"];
        $marks3 = $_POST["subk"];
        $marks4 = $_POST["presentation"];
        $total = $marks3+$marks4;
        $remark = $_POST["remarks"];
        $sql = "SELECT name from candidate_info WHERE email='$emails'";
        $result2 = $conn->query($sql);
        if ($result2->num_rows > 0) {
            while($row = $result2->fetch_assoc()) {
                $name = $row['name'];
            }
            $sql2 = "INSERT INTO candidate_marks VALUES ('','$name','$emails','$marks1','$marks2','$marks3','$marks4','$remark','$total','$branch','$email','$pan')";
            if ($conn->query($sql2) === TRUE) {
                $sql3 = "DELETE from candidate WHERE email='$email'";
                if ($conn->query($sql3) === TRUE) {
                    echo "<script>alert('submission successful...')</script>";
                    header("Location: logout");
                }else {
                    echo '<script>alert("failed")</script>';
                    echo $conn->error;
                }
            } else {
                echo '<script>alert("failed")</script>';
                echo $conn->error;
            }
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/iofrm-theme15.css">
    <link rel="icon" type="image/x-icon" href="./assets/images/svec.png">
    <style>
    body {
      background: #f5f7fa; /* subtle background color */
      /* padding: 2rem 0; */
    }

    .card-custom {
        border-radius: 25px; /* Increased border-radius */
        color: #343a40;
        font-weight: bold;
        margin: 1rem; /* Added margin around cards */
        box-shadow: 0 4px 8px rgba(0,0,0,0.2); /* Subtle box-shadow */
        display: inline-block;
        width: 100%;
        break-inside: avoid; /* Prevent card split across columns */
        background: #fff; /* White background for the card */
        }

        /* Maintain spacing around the container */
        .container {
        padding: 2rem;
        /* margin: 2rem; */
        max-width: 100vw;
        }

        /* Custom columns layout */
        .cards-column {
        column-gap: 2rem; /* Gap between columns */
        }

        @media (min-width: 768px) {
        .cards-column {
            column-count: 2; /* two columns for medium screens and up */
        }
        }

        @media (min-width: 992px) {
        .cards-column {
            column-count: 4; /* four columns for large screens and up */
        }
        }


    .card-header-custom {
      background: linear-gradient(to right, #0062cc, #0096ff);
      color: #fff;
      padding: 0.75rem;
      font-size: 1.25rem;
    }

    .card-body-custom {
      background: #ffffff;
      color: #212529;
      padding: 1rem;
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .party-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.5rem 0.75rem;
      background-color: #e9ecef;
      border-radius: 10px;
      margin-bottom: 0.5rem;
      font-size: 1rem;
    }

    .details-btn {
      text-decoration: none;
      color: #0056b3;
      font-weight: bold;
      background: #e7f5ff;
      border: 2px solid #0056b3;
      padding: 0.5rem 1rem;
      border-radius: 20px;
      transition: all 0.3s ease;
      align-self: center;
      margin-top: auto;
    }

    .details-btn:hover {
      background-color: #0056b3;
      color: #fff;
    }

    /* Custom columns layout */
    .cards-column {
      column-count: 1; /* one single column by default */
    }

    @media (min-width: 768px) {
      .cards-column {
        column-count: 2; /* two columns for medium screens and up */
      }
    }

    @media (min-width: 992px) {
      .cards-column {
        column-count: 4; /* four columns for large screens and up */
      }
    }

    .card-custom {
      display: inline-block;
      width: 100%;
      break-inside: avoid; /* Prevent card split across columns */
    }
  </style>
</head>
<body>
    <div class="form-body">
        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder" style="top: 5%; right: 35%; width: auto; height: 100px;">
                    <img src="./assets/images/logo1-dark.png" alt="" srcset="" height="100px" style="width: auto;">
                </div>
                <div class="info-holder">
                    <div class="container">
                        <div class="row"> 
                            <div class="col"> 
                            <div class="card card-custom">
                            <div class="card-header card-header-custom text-center"><?php echo $name1;?></div>
                            <div class="card-body card-body-custom">
                                <h5 class="text-muted ">Email: <?php echo $emails;?></h5>
                                <div class="party-row">
                                <span>Branch</span>
                                <span><?php echo $branch;?></span>
                                </div>
                                <div class="party-row">
                                <span>Teaching Experience</span>
                                <span><?php echo $exp_teaching;?></span>
                                </div>
                                <div class="party-row">
                                <span>Industry Experience</span>
                                <span><?php echo $exp_industry;?></span>
                                </div>
                                <a href="./pdf/<?php echo $name1;?>.pdf" download="" class="details-btn">Download resume</a>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-holder">
                <form action="logout" class="form-filling" method="post" style="margin:10px 20px;display:flex;justify-content:space-between;align-item:center;gap:10px; align-items: end;">
                    <div class="info-holder mobile-logo" style="top: 10%; right: 35%; width: auto; height: 70px;">
                        <img src="./assets/images/logo2-dark.png" alt="" class="m-3" srcset="" height="50px" style="width: auto;">
                    </div>
                    <button type="submit" class="btn btn-outline-danger" name="logout" placeholder="logout">logout</button>
                </form>
                <div class="form-content form-sm p-3">
                    <div class="form-items">
                        <h3 class="form-title">Candiate Performance</h3>
                        <form action="interviewers" id="secondform" method="post" >
                            <div class="form-group">
                                <label>Written Exam (30M)</label>
                                <div class="form-row">
                                    <div class="col">
                                        <input type="number" class="form-control" id="parta" name="parta" placeholder="Part-A (20M)" min="0" max="20">
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control" id="partb" name="partb" placeholder="Part-B (10M)" min="0" max="10">
                                    </div>
                                    <div class="col">
                                        <input type="number" id="total" disabled class="form-control" name="presentation" value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Interview</label>
                                <div class="form-row">
                                    <div class="col">
                                        <input type="number" class="form-control" id="subk" name="subk"
                                         placeholder="Subject Knowledge">
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control" id="presentation" name="presentation" placeholder="Presentation" min="0" max="10">
                                    </div>
                                    <div class="col">
                                        <input type="number" disabled class="form-control" id="itotal" name="interview_total" value="0" min="0" max="10">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Remarks</label>
                                <textarea class="form-control" name="remarks" placeholder="Remarks"></textarea>
                            </div>
                            <div class="form-button text-right">
                                <button id="submit" type="submit" name="submit" class="ibtn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/main.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var partAInput = document.getElementById('parta');
        var partBInput = document.getElementById('partb');
        var subkInput = document.getElementById('subk');
        var presentationInput = document.getElementById('presentation');

        // Validate Part A (max value: 20)
        partAInput.addEventListener('input', function () {
            var value = parseFloat(partAInput.value) || 0;
            if (value > 20) {
                //partAInput.value = 20;
            }
            updateTotal();
        });

        // Validate Part B (max value: 10)
        partBInput.addEventListener('input', function () {
            var value = parseFloat(partBInput.value) || 0;
            if (value > 10) {
                // partBInput.value = 10;
            }
            updateTotal();
        });

        // Validate Subject Knowledge (max value: 10)
        subkInput.addEventListener('input', function () {
            var value = parseFloat(subkInput.value) || 0;
            if (value > 10) {
                // subkInput.value = 10;
            }
            updateInterviewTotal();
        });

        // Validate Presentation (max value: 10)
        presentationInput.addEventListener('input', function () {
            var value = parseFloat(presentationInput.value) || 0;
            if (value > 10) {
                // presentationInput.value = 10;
            }
            updateInterviewTotal();
        });

        function updateTotal() {
            var partAValue = parseFloat(partAInput.value) || 0;
            var partBValue = parseFloat(partBInput.value) || 0;
            var totalInput = document.getElementById('total');
            totalInput.value = partAValue + partBValue;
        }

        function updateInterviewTotal() {
            var subkValue = parseFloat(subkInput.value) || 0;
            var presentationValue = parseFloat(presentationInput.value) || 0;
            var itotalInput = document.getElementById('itotal');
            itotalInput.value = subkValue + presentationValue;
        }
    });
</script>
</body>
</html>