<?php
    session_start();
    if (!isset($_SESSION['user_email'])) {
        header('Location: index');
        exit;
    }
    if($_SESSION['role']==1)
    {
        header('Location: 404');
        exit();
    }
    if($_SESSION['role']==0)
    {
        header('Location: 404');
        exit();
    }
    include 'conn.php';
    $query = "SELECT COUNT(*) as total FROM candidate_info";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        $total = $row['total'];
    } else {
        echo "Error: " . $conn->error;
        $total = 0; 
    }

    $query0 = "SELECT COUNT(DISTINCT email) as total FROM candidate_marks";
    $result0 = $conn->query($query0);
    if ($result0) {
        $row = $result0->fetch_assoc();
        $total0 = $row['total'];
    } else {
        echo "Error: " . $conn->error;
        $total0 = 0; 
    }

    $query1 = "SELECT COUNT(*) as total1 FROM candidate_info WHERE branch='cse'";
    $result1 = $conn->query($query1);
    if ($result1) {
        $row = $result1->fetch_assoc();
        $cse = $row['total1'];
    } else {
        echo "Error: " . $conn->error;
        $cse = 0; 
    }

    $query10 = "SELECT COUNT(DISTINCT email) as total1 FROM candidate_marks WHERE branch='cse'";
    $result10 = $conn->query($query10);
    if ($result10) {
        $row = $result10->fetch_assoc();
        $cse0 = $row['total1'];
    } else {
        echo "Error: " . $conn->error;
        $cse0 = 0; 
    }

    $query2 = "SELECT COUNT(*) as total2 FROM candidate_info WHERE branch='ece'";
    $result2 = $conn->query($query2);
    if ($result2) {
        $row = $result2->fetch_assoc();
        $ece = $row['total2'];
    } else {
        echo "Error: " . $conn->error;
        $ece = 0; 
    }
    $query20 = "SELECT COUNT(DISTINCT email) as total2 FROM candidate_marks WHERE branch='ece'";
    $result20 = $conn->query($query20);
    if ($result20) {
        $row = $result20->fetch_assoc();
        $ece0 = $row['total2'];
    } else {
        echo "Error: " . $conn->error;
        $ece0 = 0; 
    }
    $query3 = "SELECT COUNT(*) as total3 FROM candidate_info WHERE branch='eee'";
    $result3 = $conn->query($query3);
    if ($result3) {
        $row = $result3->fetch_assoc();
        $eee = $row['total3'];
    } else {
        echo "Error: " . $conn->error;
        $eee = 0; 
    }
    $query30 = "SELECT COUNT(DISTINCT email) as total3 FROM candidate_marks WHERE branch='eee'";
    $result30 = $conn->query($query30);
    if ($result30) {
        $row = $result30->fetch_assoc();
        $eee0 = $row['total3'];
    } else {
        echo "Error: " . $conn->error;
        $eee0 = 0; 
    }
    $query4 = "SELECT COUNT(*) as total4 FROM candidate_info WHERE branch='civil'";
    $result4 = $conn->query($query4);
    if ($result4) {
        $row = $result4->fetch_assoc();
        $civil = $row['total4'];
    } else {
        echo "Error: " . $conn->error;
        $civil = 0; 
    }
    $query40 = "SELECT COUNT(DISTINCT email) as total4 FROM candidate_marks WHERE branch='civil'";
    $result40 = $conn->query($query40);
    if ($result40) {
        $row = $result40->fetch_assoc();
        $civil0 = $row['total4'];
    } else {
        echo "Error: " . $conn->error;
        $civil0 = 0; 
    }
    $query5 = "SELECT COUNT(*) as total5 FROM candidate_info WHERE branch='mech'";
    $result5 = $conn->query($query5);
    if ($result5) {
        $row = $result5->fetch_assoc();
        $mech = $row['total5'];
    } else {
        echo "Error: " . $conn->error;
        $mech = 0; 
    }
    $query50 = "SELECT COUNT(DISTINCT email) as total5 FROM candidate_marks WHERE branch='mech'";
    $result50 = $conn->query($query50);
    if ($result50) {
        $row = $result50->fetch_assoc();
        $mech0 = $row['total5'];
    } else {
        echo "Error: " . $conn->error;
        $mech0 = 0; 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Results</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/fontawesome-all.min.css">
  <link rel="icon" type="image/x-icon" href="./assets/images/svec.png">
<style>
    body {
      background: #f5f7fa; /* subtle background gradient */
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card-custom {
      border-radius: 20px;
      color: #343a40;
      font-weight: bold;
      box-shadow: 0 8px 16px rgba(0,0,0,.1);
      overflow: hidden; /* Ensure the border-radius applies to child elements as well */
      width: 90%;
      max-width: 400px;
    }
    
    .card-header-custom {
      background: linear-gradient(to right, #0062cc, #0096ff);
      color: #fff;
      padding: 1.5rem;
      font-size: 1.75rem; /* Increased size */
    }

    .card-body-custom {
      background: #ffffff;
      color: #212529;
      padding: 2rem;
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .party-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.75rem 1rem;
      background-color: #e9ecef;
      border-radius: 10px;
      margin-bottom: 0.5rem;
      font-size: 1.2rem;
      transition: all 0.3s ease;
      text-decoration: none;
      color: inherit;
    }

    .party-row:hover {
      background-color: #d6e4f0;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0,0,0,.1);
    }

    .card-title {
      margin-bottom: 0.5rem;
      font-size: 1.5rem; /* Increased size */
    }

    .card-text {
      font-size: 1.25rem; /* Increased size */
    }

  </style>
</head>
<body>
<form action="logout" method="post" style="margin:20px 20px;position:absolute; top:0;right:0">
    <a href="admin" style="text-decoration: none; "><button type="button" class="btn btn-outline-primary">Home</button></a>
    <button type="submit" class="btn btn-outline-danger" name="logout" placeholder="logout">logout</button>
</form>
<div class="card card-custom">
  <div class="card-header card-header-custom text-center">
    Results
  </div>
  <div class="card-body card-body-custom">
    <p class="text-muted text-center">Status of Candidates</p>
    <a href="cse-results" class="party-row">
      <span>CSE</span>
      <span><?php echo $cse0;?>/<?php echo $cse;?></span>
    </a>
    <a href="ece-results" class="party-row">
      <span>ECE</span>
      <span><?php echo $ece0;?>/<?php echo $ece;?></span>
    </a>
    <a href="eee-results" class="party-row">
      <span>EEE</span>
      <span><?php echo $eee0;?>/<?php echo $eee;?></span>
    </a>
    <a href="civil-results" class="party-row">
      <span>Civil</span>
      <span><?php echo $civil0;?>/<?php echo $civil;?></span>
    </a>
    <a href="mech-results" class="party-row">
      <span>Mech</span>
      <span><?php echo $mech0;?>/<?php echo $mech;?></span>
    </a>
    <div style="border-top:1px solid gray;"></div>
    <a href="overall" class="party-row">
      <span>Overall</span>
      <span><?php echo $total0;?>/<?php echo $total;?></span>
    </a>
  </div>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
