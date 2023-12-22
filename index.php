<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
                <div class="form-content mobile-login p-0 px-2">
                    <div class="form-items">
                        <h3>Welcome back! Please enter your credentials to access your account.</h3>
                        <div class="page-links">
                            <a href="index" class="active">Login</a><a href="register">Register</a>
                        </div>
                        <?php
                            if(isset($_SESSION['user_email'])){
                                header('Location: interviewer');
                            }
                            session_start();
                            if (isset($_SESSION['user_email'])) {
                                if($_SESSION['role'] == 2){
                                    header('Location:admin');
                                    exit();
                                }else if($_SESSION['role'] == 0){
                                    header('Location:interviewers');
                                    exit();
                                }else{
                                    header('Location:candidate');
                                    exit();
                                }
                            }
                            include 'conn.php';
                            if(isset($_POST["submit"])){
                                $password=$_POST["password"];
                                $email =$_POST["username"]; 
                                $sql = "SELECT * FROM candidate WHERE email = '$email' AND password = '$password'";
                                $result = mysqli_query($conn, $sql);
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $storedPassword = $row["password"];
                                    $role = $row["role"];
                                    echo "$storedPassword";
                                    if ($password==$storedPassword) {
                                        if($role == 0){
                                            $_SESSION['user_email'] = $row['email'];
                                            $_SESSION['role'] = $row['role'];
                                            $_SESSION['name'] = $row['name'];
                                            header('Location:interviewers');
                                            exit();
                                        }else if($role == 1){
                                            $_SESSION['name'] = $row['name'];
                                            $_SESSION['user_email'] = $row['email'];
                                            $_SESSION['role'] = $row['role'];
                                            header('Location:candidate');
                                            exit();
                                        }else{
                                            $_SESSION['name'] = $row['name'];
                                            $_SESSION['user_email'] = $row['email'];
                                            $_SESSION['role'] = $row['role'];
                                            header('Location:admin');
                                            exit();
                                        }
                                    } else {
                                        echo '<div class="alert alert-warning alert-dismissible fade show with-icon" role="alert">
                                            Incorrect password
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-warning alert-dismissible fade show with-icon" role="alert">
                                            incorrect credentials.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                                }
                            }
                            
                        ?>
                        <form action="index" method="post">
                            <input class="form-control" type="email" name="username" placeholder="E-mail Address" required>
                            <input class="form-control" type="password" name="password" minlength="8" placeholder="Password" required>
                            <div class="form-button">
                                <button id="submit" type="submit" name="submit" class="ibtn">Login</button> <a href="forget3.html">Forget password?</a>
                            </div>
                        </form>
                        <div class="other-links">
                            <span>follow us on</span><a href="https://www.instagram.com/sves_official_info/"><i class="fab fa-instagram"></i></a><a href="http://srivasaviengg.ac.in/"><i class="fab fa-google"></i></a><a href="https://www.linkedin.com/school/sri-vasavi/"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/popper.min.js"></script>
</body>
</html>