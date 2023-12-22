<?php 
    session_start();
    if (!isset($_SESSION['user_email'])) {
        header('Location: index');
        exit;
    }
    if($_SESSION['role']==0)
    {
        header('Location: 404');
        exit();
    }
    include 'conn.php';
    $checkEmailQuery = "SELECT * FROM candidate_info WHERE email='".$_SESSION['user_email']."'";
    $result = $conn->query($checkEmailQuery);
    if ($result->num_rows > 0) {
        $email = $_SESSION['user_email'];
        $checkEmailQuery = "SELECT email FROM apply WHERE email = ? OR pan = ?";
        $stmt = $conn->prepare($checkEmailQuery);
        $stmt->bind_param("ss", $email,$pan);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            header("Location: successful");
            exit;
        } else {
            $insertSql = "INSERT INTO apply (email) VALUES (?)";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param("s", $email);
            if ($insertStmt->execute()) {
                echo "Record inserted successfully";
                header("Location: successful");
                exit;
            } else {
                echo '<script>alert("Failed to insert record")</script>';
                echo $conn->error;
            }
        }

    }
    
    if(isset($_POST["submit"])){
        // $email =$_POST["email"];
        $name =$_POST["name"];
        $phone =$_POST["phone"]; 
        $address =$_POST["address"];
        $dob =$_POST["dob"]; 
        $age =$_POST["age"];
        $pan =$_POST["pan"];
        $branch =$_POST["rad1"];
        $caste =$_POST["rad"];
        $btech_clg =$_POST["btech_clg"];
        $btech_prec =$_POST["btech_prec"];
        $btech_year =$_POST["btech_year"];  
        $mtech_clg =$_POST["mtech_clg"];
        $mtech_prec =$_POST["mtech_prec"];
        $mtech_year =$_POST["mtech_year"];  
        $phd_clg =$_POST["phd_clg"];
        $phd_prec =$_POST["phd_prec"];
        $phd_year =$_POST["phd_year"];  
        $teaching_exp =$_POST["teaching_exp"]; 
        $industry_exp =$_POST["industry_exp"]; 
        $date = date("Y/m/d");
        // Image upload handling
        if (isset($_FILES['profile_picture']['name'])) {
            $image_name = $_FILES['profile_picture']['name'];
            $image_tmp = $_FILES['profile_picture']['tmp_name'];
            $allowed_extensions = array('jpg', 'jpeg');
            $file_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

            if (in_array($file_extension, $allowed_extensions)) {
                move_uploaded_file($image_tmp, "./images/" . $name . ".jpg");
            } else {
                echo '<script>alert("Invalid file type. Please upload JPG or JPEG only.")</script>';
                // Handle error or redirect as needed
                exit();
                // header('Location: image_format');
            }
            // move_uploaded_file($image_tmp, "./images/" . $name . ".jpg");
        }

        if (isset($_FILES['resume']['name']))
        {
          $file_name = $_FILES['resume']['name'];
          $file_tmp = $_FILES['resume']['tmp_name'];
          echo "$file_tmp";
          move_uploaded_file($file_tmp,"./pdf/".$name.".pdf");
        }
        $email = $_SESSION['user_email'];
        $sql = "INSERT INTO candidate_info VALUES ('','$name','$email','$pan','$phone','$dob','$age','$branch','$btech_clg','$btech_prec','$btech_year','$mtech_clg','$mtech_prec','$mtech_year','$phd_clg','$phd_prec','$phd_year','$teaching_exp','$industry_exp','$caste','$address','$date','$file_name','$image_name')";
        if ($conn->query($sql) === TRUE) {
            echo "record inserted successfully";
            header("Location: successful");
        } else {
            echo '<script>alert("failed")</script>';
            echo $conn->error;
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
                    <h3 class="p-0">Welcome back, <?php echo ''.$_SESSION['name'].'';?></h3>
                    <h3 class="p-0">How to Apply: Teacher Recruitment Form</h3>
                    <p class="p-0"><b>Complete Personal Details:</b><br>&nbsp; Start by filling in your name, contact information, and address accurately. <br><br>
                        <b>Educational Background:</b><br>&nbsp; Detail your degrees, certifications, and any specialties. <br><br>
                        <b>Teaching Experience:</b><br>&nbsp; Outline your experience, subjects taught, and any notable achievements. <br><br>
                        <b>Submit Supporting Documents:</b><br>&nbsp; Attach your resume, cover letter, and any relevant certifications. <br></p>
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
                        
                        <h3 class="form-title">Complete the form</h3>
                        <form action="candidate" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Personal Information</label>
                                <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                                <div class="form-row">
                                    <div class="col">
                                        <input type="email" class="form-control" name="email" value=<?php echo $_SESSION['user_email'];?> disabled placeholder="E-mail Address" required>
                                    </div>
                                    <div class="col">
                                        <input type="tel" class="form-control" name="phone" placeholder="Phone Number" required>
                                    </div>
                                </div>
                                <input type="text" class="form-control" name="address" placeholder="Address" required>
                                <input type="text" class="form-control" name="pan" placeholder="PAN Number" required>
                                <label>Branch</label><br>
                                <!-- <input type="text" class="form-control" name="branch" placeholder="Branch" required> -->
                                <div class="custom-options">
                                    <input type="radio" id="rad11" value="cse" name="rad1"><label for="rad11">CSE</label>
                                    <input type="radio" id="rad22" name="rad1" value="ece"><label for="rad22">ECE</label>
                                    <input type="radio" id="rad33" name="rad1" value="eee"><label for="rad33">EEE</label>
                                    <input type="radio" id="rad44" name="rad1" value="civil"><label for="rad44">CIVIL</label>
                                    <input type="radio" id="rad55" name="rad1" value="mech"><label for="rad55">MECH</label>
                                </div>
                                <label>Date of Birth & Age</label>
                                <div class="form-row">
                                    <div class="col">
                                        <input type="date" class="form-control" name="dob" placeholder="Date of birth" required>
                                    </div>
                                    <div class="col">
                                        <input type="number" minlength="2" maxlength="2" class="form-control" name="age" placeholder="Enter Age" required>
                                    </div>
                                </div>
                                <label>Caste</label><br>
                                <div class="custom-options">
                                    <input type="radio" id="rad1" value="OC" name="rad"><label for="rad1">OC</label>
                                    <input type="radio" id="rad2" name="rad" value="OBC"><label for="rad2">OBC</label>
                                    <input type="radio" id="rad3" name="rad" value="BC"><label for="rad3">BC</label>
                                    <input type="radio" id="rad4" name="rad" value="SC"><label for="rad4">SC</label>
                                    <input type="radio" id="rad5" name="rad" value="ST"><label for="rad5">ST</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Education</label><br>
                                <label>&nbsp;&nbsp;&nbsp;BTech <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="btech_clg" required placeholder="Institute Name" required>
                                <div class="form-row">
                                    <div class="col">
                                        <input type="text" class="form-control" name="btech_prec" required placeholder="Percentage" required>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" name="btech_year" required maxlength="4" minlength="4" placeholder="Graduation year" required>
                                    </div>
                                </div>
                                <label>&nbsp;&nbsp;&nbsp;MTech <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="mtech_clg" required placeholder="Institute Name" required>
                                <div class="form-row">
                                    <div class="col">
                                        <input type="text" class="form-control" name="mtech_prec" required placeholder="Percentage" required>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" name="mtech_year" required maxlength="4" minlength="4" placeholder="Graduation year" required>
                                    </div>
                                </div>
                                <label>&nbsp;&nbsp;&nbsp;PHD</label>
                                <input type="text" class="form-control" name="phd_clg" placeholder="Institute Name">
                                <div class="form-row">
                                    <div class="col">
                                        <input type="text" class="form-control" name="phd_prec" placeholder="Percentage">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" name="phd_year" maxlength="4" minlength="4" placeholder="Graduation year">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Experience</label>
                                <div class="form-row">
                                    <input type="text" class="form-control" name="teaching_exp" placeholder="Teaching Experience" required>
                                    <input type="text" class="form-control" name="industry_exp" placeholder="Industry Experience" required>
                                </div>
                                <label>Resume</label>
                                <div class="custom-file">
                                    <input type="file" accept=".pdf" name="resume" class="custom-file-input" id="validatedCustomFile" required>
                                    <label class="custom-file-label" for="validatedCustomFile">CV (Resume)</label>
                                </div>
                                <div class="custom-file">
                                    <input type="file" accept=".jpg, .jpeg" name="profile_picture" class="custom-file-input" id="validatedCustomFile" required>
                                    <label class="custom-file-label" for="validatedCustomFile">image</label>
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