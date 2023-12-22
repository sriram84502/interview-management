<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/iofrm-theme3.css">
    <link rel="icon" type="image/x-icon" href="./assets/images/svec.png">
</head>
<body>
    <div class="form-body">
        <div class="row">
            <div class="img-holder p-0">
                <div class="bg"></div>
                <div class="info-holder" style="top: 12%; right: 35%; width: auto; height: 150px;">
                    <img src="./assets/images/logo1-dark.png" alt="" srcset="" height="100px" style="width: auto;">
                </div>
            </div>
            <div class="form-holder">
                <div class="info-holder mobile-logo" style="top: 10%; right: 35%; width: auto; height: 70px;">
                    <img src="./assets/images/logo2-dark.png" alt="" class="m-3" srcset="" height="50px" style="width: auto;">
                </div>
                <div class="form-content p-0">
                    <div class="form-items">
                        <div class="matter"></div>
                        <h3>Signup here</h3>
                        <!-- <p>Access to the most powerfull tool in the entire design and web industry.</p> -->
                        <div class="page-links">
                            <a href="index">Login</a><a href="register" class="active">Register</a>
                        </div>
                        <?php
                            session_start();
                            if (isset($_SESSION['user_email'])) {
                                if($_SESSION['role'] == 0){
                                    header('Location:interviewer');
                                    exit();
                                }else{
                                    header('Location:candidate');
                                    exit();
                                }
                            }
                            include 'conn.php';
                            if(isset($_POST["submit"])){
                                $name=$_POST["name"]; 
                                $password2=$_POST["password"];
                                $repassword = $_POST["re-password"];
                                $email =$_POST["email"]; 
                                $checkEmailQuery = "SELECT * FROM candidate WHERE email='$email'";
                                $result = $conn->query($checkEmailQuery);
                                $sql = "INSERT INTO candidate(name,email,password) VALUES ('$name','$email','$password2')";
                                if ($result->num_rows > 0) {
                                    echo '<div class="alert alert-warning alert-dismissible fade show with-icon" role="alert">
                                            Email already exists
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                                } else {
                                    if($password2==$repassword){ 
                                        if ($conn->query($sql) === TRUE) {
                                            echo "record inserted successfully";
                                            header("Location: index");
                                        } else {
                                            echo $conn->error;
                                        }
                                    }else{
                                        echo '<div class="alert alert-warning alert-dismissible fade show with-icon" role="alert">
                                            Please enter password correctly
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                                    }
                                }
                            }
                            
                        ?>
                        <form action="register" method="post">
                            <input class="form-control" type="text" name="name" placeholder="Full Name" required>
                            <input class="form-control" type="email" name="email" placeholder="E-mail Address" required>
                            <input class="form-control" id="pass1" type="password" name="password" placeholder="Password" minlength="8" required>
                            <input class="form-control" id="pass2" type="password" name="re-password" placeholder="Re-password" minlength="8" required>
                            <div class="form-button">
                                <button id="submit" type="submit" name="submit" class="ibtn">Register</button>
                            </div>
                        </form>                   
                        <div class="other-links">
                            <span>follow us on</span><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-google"></i></a><a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
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