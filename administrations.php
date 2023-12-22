<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require './PHPMailer/src/Exception.php';
    require './PHPMailer/src/PHPMailer.php';
    require './PHPMailer/src/SMTP.php';
    session_start();
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
    if (!isset($_SESSION['user_email'])) {
        header('Location: index');
        exit();
    }
    include 'conn.php';
    $email = $_SESSION['selected_email'];
    $sql3 = "SELECT * from candidate_info WHERE email='$email'";
    $result3 = $conn->query($sql3);
    if ($result3->num_rows > 0) {
        while($row = $result3->fetch_assoc()) {
            $name1 = $row['name'];
            $exp_teaching = $row['exp_teaching'];
            $exp_industry = $row['exp_industry'];
            $branch = $row['branch'];
            $_SESSION['selected_user_branch'] = $branch;
        }
    }
    if(isset($_POST["submit"])){
        $teacher1 = $_POST["teacher1"];
        $teacher1_email = $_POST["teacher1_email"];
        $teacher1_password = $_POST["teacher1_password"];
        $teacher2 = $_POST["teacher2"];
        $teacher2_email = $_POST["teacher2_email"];
        $teacher2_password = $_POST["teacher2_password"];
        $teacher3 = $_POST["teacher3"];
        $teacher3_email = $_POST["teacher3_email"];
        $teacher3_password = $_POST["teacher3_password"];
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        for ($i = 1; $i <= 3; $i++) {
            $teacher_name = $_POST["teacher$i"];
            $teacher_email = $_POST["teacher{$i}_email"];
            $teacher_password = $_POST["teacher{$i}_password"];
        
            // Create a new PHPMailer instance
            $mail = new PHPMailer(true);
        
            try {
                // Server settings
                // $mail->isSMTP();
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'vanapallisaisriram7@gmail.com';
                $mail->Password = 'qgad ydjb qmys puzw';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                // ... (your existing server settings)
        
                // Recipients
                $mail->setFrom('vanapallisaisriram7@gmail.com', 'Sri Vasavi Engineering College');
                $mail->addAddress($teacher_email, $teacher_name);
        
                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Login Credentials';
                $mail->Body = 'Your username: '.$teacher_email.' your password: '.$teacher_password.' Website: ';
        
                // Send the email
                $mail->send();
                // echo "Email sent successfully to $teacher_email<br>";
            } catch (Exception $e) {
                echo "Failed to send email to $teacher_email. Error: {$mail->ErrorInfo}<br>";
            }
        
            // Insert data into the database (your existing code)
            // ...
        
        }
        
        $sql = "INSERT INTO candidate (name, email, password,role) VALUES (?, ?, ?, ?), (?, ?, ?, ?), (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $role1 = 0;
        $role2 = 0;
        $role3 = 0;
        $stmt->bind_param("sssisssisssi", $teacher1, $teacher1_email, $teacher1_password, $role1, $teacher2, $teacher2_email, $teacher2_password, $role2, $teacher3, $teacher3_email, $teacher3_password, $role3);
        $sql1 = "INSERT INTO candidate_allocation VALUES ('','$email','$teacher1_email','$teacher2_email','$teacher3_email','$teacher1','$teacher2','$teacher3')";
        if ($conn->query($sql1) && $stmt->execute()) {
            echo "record inserted successfully";
            header("Location: successful");
        } else {
            // echo '<script>alert("failed")</script>';
            echo $conn->error;
        }
        $stmt->close();
    }
    $query = "SELECT COUNT(*) as total FROM apply";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        $total = $row['total'];
    } else {
        echo "Error: " . $conn->error;
        $total = 0; 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>
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

    .button-container {
            position: relative;
            display: inline-block;
        }

        .count-indicator {
            position: absolute;
            top: 0;
            right: 0;
            background-color: blue;
            color: white;
            border-radius: 50%;
            padding: 1px 5px 1px 5px;
            font-size: 10px;
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
                                <h5 class="text-muted ">Email: <?php echo $_SESSION['selected_email'];?></h5>
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
                <form action="logout" method="post" style="margin:10px 20px;display:flex;justify-content:end;gap:10px; align-items: end;">
                    <a href="manage-users" style="text-decoration: none; "><button type="button" class="btn btn-outline-info">Manage Users</button></a>
                    <div class="button-container">
                        <a href="re-apply" style="text-decoration: none; "><button type="button" class="btn btn-outline-primary">Re-Applied</button></a>
                        <div class="count-indicator"><?php echo $total ?></div>
                    </div>
                    <a href="results" style="text-decoration: none; "><button type="button" class="btn btn-outline-success">Results</button></a>
                    <button type="submit" class="btn btn-outline-danger" name="logout" placeholder="logout">logout</button>
                </form>
                <div class="form-content form-sm">
                    <div class="form-items">
                        <h3 class="form-title">Complete the form</h3>
                        <form action="administrations" id="secondform" method="post" >
                            <div class="form-group">
                                <label>Interviewer 1</label>
                                <input type="text" class="form-control" name="teacher1" placeholder="Enter name" required>
                                <div class="form-row">
                                    <div class="col">
                                        <input type="email" class="form-control" name="teacher1_email" placeholder="Enter Email" required>
                                    </div>
                                    <div class="col">
                                        <input type="password" class="form-control" name="teacher1_password" minlength="8" placeholder="Enter Password" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Interviewer 2</label>
                                <input type="text" class="form-control" name="teacher2" placeholder="Enter name" required>
                                <div class="form-row">
                                    <div class="col">
                                        <input type="email" class="form-control" name="teacher2_email" placeholder="Enter Email" required>
                                    </div>
                                    <div class="col">
                                        <input type="password" class="form-control" name="teacher2_password" minlength="8" placeholder="Enter Password" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Interviewer 3</label>
                                <input type="text" class="form-control" name="teacher3" placeholder="Enter name">
                                <div class="form-row">
                                    <div class="col">
                                        <input type="email" class="form-control" name="teacher3_email" placeholder="Enter Email">
                                    </div>
                                    <div class="col">
                                        <input type="password" class="form-control" name="teacher3_password" minlength="8" placeholder="Enter Password">
                                    </div>
                                </div>
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
</body>
</html>